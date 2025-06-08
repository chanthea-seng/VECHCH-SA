// dashboardStore.js
import axios from "axios";
import router from "@/router";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useAuthStore } from "./userAuthStore";

export const dashboardGeneralStore = defineStore('dashboardStore', {
	state: () => ({
		frm: {
			totalAppointments: 0,
			totalPatients: 0,
			totalArticles: 0,
			totalViews: 0,
		},
		frmAppointment: {},
		todayBooking: ref([]),
		chartdata: null,
	}),
	actions: {
		onClickDetailBooking(id) {
			if (id) {
				sessionStorage.setItem('selectedId', id);
				router.push('/appointment-detail');
			}
		},
		async onLoadBookingToday() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();

				const response = await axios.get(`/api/calendars?today=1`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.todayBooking.value = response.data.data;
			} catch (error) {
				// console.error("Error fetching bookings:", error);
			}
		},
		async onLoadChartData() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();

				const response = await axios.get(`/api/bookings/chart-data`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				this.chartdata = response.data.data;
			} catch (error) {
				// console.error("Error fetching bookings:", error);
			}
		},
	},

});
