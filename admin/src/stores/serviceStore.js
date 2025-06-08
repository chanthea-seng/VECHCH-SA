import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import router from "@/router";
import { useAuthStore } from "./userAuthStore";
import { useNotyfStore } from "./notyfStore";
import { compileStyle } from "vue/compiler-sfc";

export const serviceStore = defineStore('view/serviceView', {
	state: () => ({
		filter: {
			service_type: sessionStorage.getItem("serviceType") || '',
			search: '',
			service_type: '',
			per_page: 6,
			page: 1,
		},
		service: null,
		subService: null,
		selectId: null,
		services: null,
		totalPage: 1,
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
		// loading: ref(false),
		// paginationLoading: ref(false),
	}),
	actions: {
		async getService(p = 1, per_page = 2, serviceType = this.filter.service_type, skipGlobalLoading = false) {
			try {
				if (!skipGlobalLoading) {
					if (this.currentPage !== p) {
						this.paginationLoading = true;
					} else {
						this.loading = true;
					}
				}
				const res = await axios.get(`/api/services?search=${this.filter.search}&per_page=${per_page}&page=${p}&service_type=${serviceType}`);
				this.services = res.data.data;
				this.filter.service_type = serviceType;
				this.currentPage = p;
				sessionStorage.setItem('currentPage', p);
				sessionStorage.setItem('serviceType', serviceType);
				this.totalPage = res.data.paginate.total_page;
			} catch (error) {
				// console.error('Error fetching service:', error);
			} finally {
				this.loading = false;
				this.paginationLoading = false;
			}
		},
		onClickDetail(id) {
			if (id) {
				sessionStorage.setItem("serviceId", id);
				router.push("/service-detail");
			}
		},
		// async getServiceDetail() {
		// 	try {
		// 		this.selectId =
		// 			sessionStorage.getItem("serviceId")
		// 		const res = await axios.get(`/api/services/${this.selectId}`);
		// 		this.service = res.data.data;
		// 		console.log(this.service);
		// 	} catch (error) {
		// 		console.error('Error fetching service:', error);
		// 	}
		// },
		onClickBook(id) {
			if (id) {
				sessionStorage.setItem("serviceId", id);
				router.push("/booking-appointment");
			}
		},
		async onClickDeleteService() {
			const notyf = useNotyfStore();
			try {
				if (this.selectId != 0) {
					const authStore = useAuthStore();
					authStore.loadToken()
					axios.delete(`/api/services/${this.selectId}`, {
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							"Content-Type": "multipart/form-data",
						},
					}).then(res => {
						console.log(res.data.data)
						this.getService()
						notyf.success('Delete Service Success')
					})
				}
			} catch (err) {
				notyf.error('Delete Service fail')
			}
		}


	}
})