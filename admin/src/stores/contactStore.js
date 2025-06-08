import { defineStore } from "pinia";
import { useNotyfStore } from "./notyfStore";
import router from "@/router";
import axios from "axios";
import { useAuthStore } from "./userAuthStore";
export const contactStore = defineStore("view/contact", {
	state: () => ({
		contactMessage: '',
		contacts: null,
		subContact: null,
		contactDetail: null,
		filter: {
			per_page: 3,
			status: '',
			search: ''
		}
	}),
	actions: {
		async getContact() {
			const notfy = useNotyfStore()
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const response = await axios.get(`/api/contacts?per_page=${this.filter.per_page}&search=${this.filter.search}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.contacts = response.data.data;
			} catch (error) {
				console.error("User fetch error:", error);
				if (error.response?.data) {
					const errorMessage = error.response.data.message || "Something went wrong";
					const errorDetails = error.response.data.errors;
					let detailedMessage = errorMessage;
					if (errorDetails) {
						detailedMessage += "\n" + Object.values(errorDetails)
							.map((err) => err.join(", "))
							.join("\n");
					}
					notfy.error(detailedMessage);
				} else {
					notfy.error("An unexpected error occurred.");
				}
			}
		},
		async getContactDetail() {
			const selectId = sessionStorage.getItem("selectId");
			const authStore = useAuthStore();
			const notfy = useNotyfStore();
			if (selectId) {
				try {
					authStore.loadToken()
					const response = await axios.get(`/api/contacts/${selectId}`, {
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							"Content-Type": "multipart/form-data",
						},
					});
					this.contactDetail = response.data.data;
				} catch (error) {
					console.error("User fetch error:", error);
					if (error.response?.data) {
						const errorMessage = error.response.data.message || "Something went wrong";
						const errorDetails = error.response.data.errors;
						let detailedMessage = errorMessage;

						if (errorDetails) {
							detailedMessage += "\n" + Object.values(errorDetails)
								.map((err) => err.join(", "))
								.join("\n");
						}
						notfy.error(detailedMessage);
					} else {
						notfy.error("An unexpected error occurred.");
					}
				}
			} else {
				router.push("/dashboard");
			}
		},
		async onClickDetail(id) {
			if (id) {
				sessionStorage.setItem('selectId', id);
				router.push('/contact-detail')
			}
		},
		async onClickSend() {
			const notyf = useNotyfStore();
			notyf.success('Send Success')
			router.push('/contact')
		}
	}
})