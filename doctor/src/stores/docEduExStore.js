import { defineStore } from 'pinia';
import router from '@/router';
import { useNotyfStore } from './notfyStore';
import axios from 'axios';
import { useAuthStore } from './userAuthStore';
export const eduStore = defineStore('edu', {
	state: () => ({
		selectedId: 0,
		token: null,
		userData: null,
		loginfrm: {
			email: "",
			password: "",
		},
		validation: null,
		educations: null,
		experiences: null,
	}),
	actions: {
		async fetchDoctorExperience() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const { data } = await axios.get("/api/doctor/experiences", {
					headers: { Authorization: `Bearer ${authStore.token}` },
				});
				this.experiences = data.data;
			} catch (error) {
				// console.error(
				// 	"Error fetching experiences:",
				// 	error.response?.data?.message || error.message
				// );
			}
		},
		async fetchDoctorEducation() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const { data } = await axios.get("/api/doctor/educations", {
					headers: { Authorization: `Bearer ${authStore.token}` },
				});

				if (data && data.data) {
					this.educations = data.data;
				} else {
					// console.error("No educations found in the response.");
				}
			} catch (error) {
				// console.error(
				// 	"Error fetching doctor education:",
				// 	error.response?.data?.message || error.message
				// );
			}
		},
	}
});
