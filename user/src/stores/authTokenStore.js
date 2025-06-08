import { defineStore } from "pinia";
export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: localStorage.getItem('token') || null,
		userData: null,
		mdlCheckToken: null,
		toastfail:null,
		isregisterfail:null,
		isresetpassfail:null,
		isUpdateinfosuccess:null,
		isupdatepfsuccess:null,
		toatsuccess:null,
		
	}),
	actions: {
		setToken(newToken) {
			this.token = newToken;
			localStorage.setItem('token', newToken);
		},
		loadToken() {
			const saveToken = localStorage.getItem('token');
			if (saveToken) this.token = saveToken;
		},
		setData(newData) {
			localStorage.setItem('userData', JSON.stringify(newData));
			this.userData = newData;
		},
		loadData() {
			const userData = localStorage.getItem('userData');
			this.userData = userData ? JSON.parse(userData) : null;
		},
		clearData()
		{
			this.userData = null;
			localStorage.removeItem('userData')
		},
		clearToken() {
			this.token = null;
			localStorage.removeItem('token');
		}
	}
})