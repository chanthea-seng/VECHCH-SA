import { defineStore } from "pinia";

export const forgetpassword = defineStore('views/authstore', {
	state: () => ({
		forgetpass: null,
		getopt: null,
		resetnewpassword: null,

		registerfrm: {
			fullname: '',
			email: '',
			password: '',
			confirm_password: '',
		},
		loginfrm: {
			email: '',
			password: '',
		},
		forgetpassfrm: {
			email: '',
			otp: new Array(4).fill(''),
			newpass: '',
			newpass_confirmation: '',
		},
		validation: {
			vvregister: null,
			vvlogin: null,
			vvforgetpass: null,
			vvgetopt: null,
			vvresetpassword: null,
		}


	}),
	actions: {
		onClearRegisterfrm() {
			this.registerfrm.fullname = '';
			this.registerfrm.email = '';
			this.registerfrm.password = '';
			this.registerfrm.confirm_password = '';
			if (this.validation.vvregister) {
				this.validation.vvregister.$reset();

			}
		},

		onclearLoginfrm() {
			this.loginfrm.email = '';
			this.loginfrm.password = '';
			if (this.vvlogin) {
				this.vvlogin.$reset();
			}
		},
		clearForgetPassForm() {
			this.forgetpassfrm = {
			  email: '',
			  otp: new Array(4).fill(''),
			  newpass: '',
			  newpass_confirmation: '',
			};
		  },

	}
})