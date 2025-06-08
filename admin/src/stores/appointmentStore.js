import { defineStore } from "pinia";
import axios from "axios";
import { useNotyfStore } from "./notyfStore";
import { ref } from "vue";
import { useAuthStore } from "./userAuthStore";
import router from "@/router";
import { constructNow } from "date-fns";
export const appointmentStore = defineStore("view/dashboard", {
	state: () => ({
		selectedId: 0,
		appointments: null,
		doctors: null,
		formattedDate: null,
		packages: null,
		appointmentsDetail: null,
		filter: {
			booking_status: 0,
			service_type: 0,
			per_page: 10,
			search: '',
			is_complete: '',
			specialist: '',
			today: 0,
		},
		fileShow: {
			file: null,
			filePreview: null,
			filename: null,
			paymentFile: null,
		},
		adminData: null,
	}),
	actions: {
		convertDateFormat(input) {
			const [day, month, yearAndTime] = input.split('/');
			const [year, time] = yearAndTime.split(' ');
			const formattedDate = `${year}-${month}-${day} ${time}`;
			this.formattedDate = formattedDate;
		},
		async getAvaliableDoctor() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const response = await axios.put(`/api/bookings/check-doctor?search=${this.filter.search}`, {
					appointment_time: this.formattedDate
				}, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
					},
				});
				this.doctors = response.data.data;
			} catch (error) {
				// console.log(error)
			}
		},
		async getAdminData() {
			const authStore = useAuthStore();
			try {
				authStore.loadToken()
				const response = await axios.get(`/api/bookings/countTotalInformationWebsite`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.adminData = response.data.data;
				// console.log(this.adminData)
			} catch (error) {
			}
		},
		setFile(file) {
			this.fileShow.file = file.name;
			this.fileShow.filename = file;
			this.fileShow.filePreview = URL.createObjectURL(file);
		},
		async onClickApprove(id, status = 1) {
			const notfy = useNotyfStore()
			try {
				const frmData = new URLSearchParams();
				frmData.append('booking_status', status);

				const authStore = useAuthStore();
				const response = await axios.put(`/api/bookings/status/${id}`, frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "application/x-www-form-urlencoded",
					},
				});
				if (status != 1) {
					notfy.warning("Reject Booking");
				}
				else
					notfy.success("Approve Booking");
				await this.getBooking();
			} catch (error) {
				// console.error("User fetch error:", error);
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
		async onClickAssignDoctor(doctor_id, booking_id) {
			try {
				const frmData = new URLSearchParams();
				frmData.append('doctor_id', doctor_id);
				frmData.append('id', booking_id);
				const authStore = useAuthStore();
				const response = await axios.put(`/api/bookings/assign-doctor`, frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "application/x-www-form-urlencoded",
					},
				});
			} catch (error) {
				// console.error("User fetch error:", error);
			}
		},
		async getAppointmentDetail() {
			const selectId = sessionStorage.getItem("selectId");
			const authStore = useAuthStore();
			const notfy = useNotyfStore();
			if (selectId) {
				try {
					authStore.loadToken()
					const response = await axios.get(`/api/bookings/${selectId}`, {
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							"Content-Type": "multipart/form-data",
						},
					});
					this.appointmentsDetail = response.data.data;
				} catch (error) {
					// console.error("User fetch error:", error);
					if (error.response?.data) {
						const errorMessage = error.response.data.message || "Something went wrong";
						const errorDetails = error.response.data.errors;
						let detailedMessage = errorMessage;

						if (errorDetails) {
							detailedMessage += "\n" + Object.values(errorDetails)
								.map((err) => err.join(", "))
								.join("\n");
						}
						notfy.error("An unexpected error occurred.");
						// notfy.error(detailedMessage);
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
				router.push('/inspect-appointment')
			}
		},
		async getBooking() {
			const notfy = useNotyfStore()
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const response = await axios.get(`/api/bookings?today=${this.filter.today}&search=${this.filter.search}&service_type=${this.filter.service_type}&per_page=${this.filter.per_page}&booking_status=${this.filter.booking_status}&is_complete=${this.filter.is_complete}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.appointments = response.data.data;
			} catch (error) {
				// console.error("User fetch error:", error);
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
		async getPackage(service_type, per_page) {
			const notfy = useNotyfStore()
			try {
				if (Array.isArray(service_type)) {
					service_type = JSON.stringify(service_type);
				}
				const authStore = useAuthStore();
				await authStore.loadToken()
				const response = await axios.get(`/api/bookings?today=1&service_type=${service_type}&per_page=${per_page}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.packages = response.data.data;
				// console.log(this.packages)
			} catch (error) {
				// console.error("User fetch error:", error);
				if (error.response?.data) {
					const errorMessage = error.response.data.message || "Something went wrong";
					const errorDetails = error.response.data.errors;
					let detailedMessage = errorMessage;

					if (errorDetails) {
						detailedMessage += "\n" + Object.values(errorDetails)
							.map((err) => err.join(", "))
							.join("\n");
					}
					// notfy.error(detailedMessage);
					notfy.error("An unexpected error occurred.");

				} else {
					notfy.error("An unexpected error occurred.");
				}
			}
		},

	}
})