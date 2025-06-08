import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import { useAuthStore } from "./authTokenStore";
import router from "@/router";
export const appointmentStore = defineStore('appointmentstore', {
	state: () => ({
		appointments: [],
		appointmentdetail: null,
		appontmentAprroveds: null,
		mdl_deleteappoint: null,
		totalbooking: null,
		serviceCount: null,
		selected: null,
		selected_id: null,
		medaicalrecods: [],
		mdl_cancelappoint: null,
		loading: ref(false),
		filter: {
			service_type: 0,
			search: ''
		},
		hasAppointment: ref(true),
		hasAppointmentApprove: ref(true),
	}),
	actions: {
		async fetchAllAppointment() {
			try {
				this.loading = true;
				await Promise.all([

					this.gettotalApproveMet(),
					this.getTotalBooking(),
					this.getmedicalRecord(),
				])
			} catch (error) {
				// console.log('Error message: ', error)
			} finally {
				this.loading = false
			}
		},
		async fetchGetPateintData() {
			try {
				this.loading = true;
				await Promise.all([
					this.getTotalBooking()
				])
			} catch (error) {
				// console.log('Error message: ', error)
			} finally {
				this.loading = false
			}
		},


		async getAppointmentApprove() {
			const authStore = useAuthStore();
			try {

				const res = await axios.get(`/api/bookings?is_complete=0&is_remove=0&booking_status=1`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				});
				this.appontmentAprroveds = await res.data.data;
				this.hasAppointment = this.appontmentAprroveds && Array.isArray(this.appointments) && this.appointments.length > 0;


			}

			catch (error) {
				// console.log('error  fecht appointment dataa', error);

			}
		},

		async fetchAppointments() {
			try {
				const authStore = useAuthStore();
				const res = await axios.get(`/api/bookings?booking_status=[1,3]&is_remove=0&service_type=${this.filter.service_type}`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				});
				this.appointments = await res.data;

				this.hasAppointment = this.appointments?.data && Array.isArray(this.appointments.data) && this.appointments.data.length > 0;
				// if(this.appointments.data.length === 0){
				//   this.hasAppointment = false;
				// }
			} catch (error) {
				// console.error("Error fetching appointments:", error);
			}
		},
		// async 
		setServiceType(type) {
			this.filter.service_type = type;
			this.fetchAppointments();

			this.getbookingCheckup();
			this.gettotalcheckupapprove();

			this.getbookingTalk();
			this.gettotalTalkpapprove();

			this.getbookingVaccine();
			this.gettotalVaccinepapprove();
		},


		getBookingDetailId(id) {
			let selected = id;

			if (selected) {
				sessionStorage.setItem('selectId', selected);
				router.push('/invoice');
			}

		},

		async getDetailbookingDetail() {
			const authStore = useAuthStore();
			authStore.loadToken();
			try {
				this.loading = true;
				const selectId = sessionStorage.getItem('selectId');

				if (selectId) {

					const res = await axios.get(`/api/bookings/${selectId}`, {
						headers: {
							Authorization: 'Bearer ' + authStore.token
						}
					})
					this.appointmentdetail = await res.data.data;
				}
				else {
					router.go(-1);
				}

			} catch (error) {
				// console.log('get booking detail fail'.error);

			} finally {
				this.loading = false
			}
		},

		async getTotalBooking() {
			const authStore = useAuthStore();
			authStore.loadToken();
			try {
				const res = await axios.get(`api/bookings/count-booking`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				})
				this.totalbooking = res.data.data;
			}
			catch (error) {
				// console.log('get book count fail',error);

			}
		},
		async getBookingUserService() {
			const authStore = useAuthStore();
			authStore.loadToken();
			try {
				const res = await axios.get(`api/bookings/count-services`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				})
				this.serviceCount = res.data.data;
			}
			catch (error) {
				// console.log('get book count fail',error);

			}
		},


	},
	getters: {
		filteredAppointments(state) {
			return state.appointments.filter(appoint => appoint.service_type === state.filter.service_type);
		}
	}
})