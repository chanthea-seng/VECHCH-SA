import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import { useAuthStore } from "./authTokenStore";
// import socket from "@/utils/socket";

export const notificationStore = defineStore('storenotification', {
	state: () => ({
		mdl_add_patient: null,
		ocv_notification: null,
		notification: ref([]),
		unread: null,
		filter: {
			type: '',
		}
	}),
	actions: {
		async getNotification() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				if (!authStore.token) {
					return
				}
				const res = await axios.get(`/api/notifications?type=${this.filter.type}`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				});
				this.notification = res.data.data.data
				this.unread = res.data.data.unread
			} catch (error) {
				// console.log('Error message: ', error);
			} finally {

			}
		},
		async onClickRead(id) {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const res = await axios.put(`/api/notifications/${id}/read`, null, {
					headers: {
						Authorization: 'Bearer ' + authStore.token,
					}
				});
			} catch (error) {
				// console.log('Error message: ', error);
			} finally {

			}
		},
		// listenToNotifications() {
		//     socket.on('new_notification', (notification) => {
		//       this.notifications.unshift(notification); // Add the new notification
		// });
		// },
		// async addNotification (notification) {
		//     this.notifications.unshift(notification); // Prepend the notification
		// }

	}
})