import router from '@/router';
import { defineStore } from 'pinia';
import { useNotyfStore } from './notyfStore';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: null,
		loginfrm: {
			email: "",
			password: "",
		},
		validation: null,
		userData: null,
	}),
	actions: {
		onclearLoginfrm() {
			this.loginfrm.email = '';
			this.loginfrm.password = '';
			if (this.validation) {
				this.validation.$reset();
			}
		},
		setToken(newToken) {
			this.token = newToken;
			localStorage.setItem('token', this.token);
		},
		loadToken() {
			const savedToken = localStorage.getItem('token');
			if (savedToken) this.token = savedToken;
		},
		async onLoadGetMe() {
			this.loadToken()
			const notyf = useNotyfStore();
			try {
				const response = await axios.get("/api/auth/me", {
					headers: {
						Authorization: `Bearer ${this.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.userData = { ...response.data.user };
			} catch (error) {
				notyf.warning("Invalid Authorization please login again");
				this.userData = null;
				router.push('/');
			}
		},
		clearToken() {
			this.token = null;
			this.userData = null;
			localStorage.clear();
		},
		async checkIfAdmin() {
			this.loadToken();
			if (!this.token) {
				router.push('/');
				return false;
			}
			await this.onLoadGetMe();
			const isAdmin = this.userData?.id === 1 && this.userData?.role_id === 1;

			if (!isAdmin) {
				router.push('/');
				return false;
			}
			return true;
		}

	},
});
