import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import router from "@/router";
import { useAuthStore } from "./userAuthStore";
import { useNotyfStore } from "./notyfStore";

export const medicalRecord = defineStore('view/patient', {
	state: () => ({
		medicalRecords: null,
		filter: {
			search: '',
		}
	}),
	actions: {
		async fetchMedicalRecords() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();
				const response = await axios.get(`/api/getMedicalRecord?search=${this.filter.search}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						Accept: "application/json",
					},
				});
				this.medicalRecords = response.data.data;
			} catch (error) {
			}
		},

	}
})