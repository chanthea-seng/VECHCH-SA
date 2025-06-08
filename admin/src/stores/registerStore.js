import { defineStore } from "pinia";

export const registerStore = defineStore('register', {
	state: () => ({
		registerfrm: {
			fullname: '',
			local_fullname: '',
			email: '',
			password: '',
			confirm_password: '',
		},
		validation: {
			vvregister: null,
		},


	}),
	actions: {
		onClearRegisterfrm() {
			this.registerfrm.fullname = '';
			this.registerfrm.local_fullname = '';
			this.registerfrm.email = '';
			this.registerfrm.password = '';
			this.registerfrm.confirm_password = '';
			if (this.validation.vvregister) {
				this.validation.vvregister.$reset();
			}
		}
	}
})