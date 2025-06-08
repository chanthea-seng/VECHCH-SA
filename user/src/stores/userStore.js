import { defineStore } from "pinia"
import axios from "axios";
import { ref } from "vue";
import { useAuthStore } from "./authTokenStore";
export const userStore = defineStore('userstore', {
	state: () => ({
		avatar: {
			bin: null,
			url: '/src/assets/images/auth/no_photo.jpg'
		},
		users: [],
		userfrm: {
			fullname: '',
			local_fullname: '',
			email: '',
			old_password: '',
			new_password: '',
			confirm_password: '',

		},
		vvuser: null,
		vvpassword: null,
		tostsuccess: null,
		loading: ref(false)

	}),
	actions: {
		async onLoadData() {
			const authStore = useAuthStore();
			authStore.loadToken();
			try {
				this.loading = true
				const response = await axios.get('/api/auth/me', {
					headers: {
						'Content-Type': 'application/json',
						Authorization: `Bearer ` + authStore.token
					}
				});
				this.users = response.data.user;

			}
			catch (error) {
				localStorage.clear()
				sessionStorage.clear()
				window.location.reload();
				// console.log('error fecht user data',error);
			} finally {
				this.loading = false
			}
		},
		CLearResetPassword() {
			this.userfrm.old_password = '';
			this.userfrm.new_password = '';
			this.userfrm.confirm_password = '';
			if (this.vvpassword) {
				this.vvpassword.old_password?.$reset();
				this.vvpassword.new_password?.$reset();
				this.vvpassword.confirm_password?.$reset();
			}

		}
	}
})