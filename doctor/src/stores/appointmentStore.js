import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { useAuthStore } from "./userAuthStore";
import router from "@/router";
export const useAppointmentStore = defineStore("appointment", {
	state: () => ({
		bookingDetail: ref([]),
		medicalRecords: ref([]),
		patients: null,
	}),
	actions: {
		async onLoadPatient() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();

				const response = await axios.get(`/api/bookings?is_complete=1`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.patients = response.data.data;
			} catch (error) {
				// console.error("Error fetching bookings:", error);
			}
		},
		onClickCreateMedicalRecord(bookingInfo) {
			if (bookingInfo) {
				sessionStorage.setItem("bookingInfo", JSON.stringify(bookingInfo));
				router.push("/medical-record");
			}
		},
		async fetchMedicalRecords(id) {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();
				const response = await axios.get(`/api/user-medical/${id}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						Accept: "application/json",
					},
				});

				this.medicalRecords.value = response.data.data;
			} catch (error) {
				// console.error(
				// 	"Error fetching medical records:",
				// 	error.response?.data || error.message
				// );
			}
		},
		async onClickBookingSuccess(id) {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();

				const response = await axios.put(
					`/api/medical-record/complete/${id}`,
					{},
					{
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							Accept: "application/json",
						},
					}
				);

				if (response.data.success) {
					const bookingIndex =
						this.bookingDetail.value.related_bookings.findIndex(
							(tab) => tab.id === id
						);
					if (bookingIndex !== -1) {
						this.bookingDetail.value.related_bookings[
							bookingIndex
						].is_complete = true;
					}
				}
				await this.onLoadBoookingDetail(id);
				// window.location.reload();
			} catch (error) {
				// console.error("Error updating booking status:", error);
			}
		},
		checkIfMedicalRecord() {
			const bookingInfo = sessionStorage.getItem("bookingInfo");
			if (bookingInfo) {
				this.bookingDetail.value = JSON.parse(bookingInfo);
			}
			else {
				router.go(-1)
			}
		},
		async checkIfBooking() {
			const selectId = sessionStorage.getItem("selectedId");
			if (selectId) {
				await this.onLoadBoookingDetail(selectId);
				let userId = this.bookingDetail.value.booking.user.id
				await this.fetchMedicalRecords(userId);
			} else {
				router.go(-1)
			}
		},
		async onLoadBoookingDetail(id) {
			try {
				if (id) {
					const authStore = useAuthStore();
					authStore.loadToken();
					const response = await axios.get(`/api/bookings/${id}`, {
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							"Content-Type": "multipart/form-data",
						},
					});
					this.bookingDetail.value = response.data.data;
				}
			} catch (error) {
				// console.error("Error fetching bookings:", error);
			}
		},
	},
});
