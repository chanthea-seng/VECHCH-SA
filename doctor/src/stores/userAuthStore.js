import { defineStore } from 'pinia';
import router from '@/router';
import { useNotyfStore } from './notfyStore';
import axios from 'axios';
import { TimeScale } from 'chart.js';
export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: null,
		userData: null,
		loginfrm: {
			email: "",
			password: "",
		},
		validation: null
	}),
	actions: {
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
			if (!this.token) {
				return;
			}
			const notyf = useNotyfStore();
			try {
				const response = await axios.get("/api/auth/me", {
					headers: {
						Authorization: `Bearer ${this.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.userData = response.data.user;
			} catch (error) {
				notyf.warning("ការអនុញ្ញាតមិនត្រឹមត្រូវ សូមចូលគណនីម្តងទៀត");
				this.userData = null;
				router.push('/');
			}
		},
		async checkIfDoctor() {
			this.loadToken();
			if (!this.token) {
				router.push('/');
				return false;
			}
			await this.onLoadGetMe();
			const isDoctor = this.userData?.role_id === 2;

			if (!isDoctor) {
				router.push('/');
				return false;
			}
			return true;
		},
	}
});
