import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import router from "@/router";
import Contact from "@/views/contact.vue";
import { useAuthStore } from "./authTokenStore";

export const pagekageStore = defineStore('store/package', {
	state: () => ({
		filter: {
			service_type: sessionStorage.getItem("serviceType") || '',
			search: '',
		},
		service: ref([]),
		selectId: null,
		tabServiceCheck: null,
		tabServiceVaccine: null,
		taballServices: null,
		services: ref([]),
		allServices: ref([]),
		totalPage: 1,
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
		loading: ref(false),
		paginationLoading: ref(false),
		inputService: ref([]),
		inputsearch: '',
		// serviceType: ref(null),
	}),
	actions: {
		async getTabService(type, per_page) {
			try {
				const api = `/api/services?per_page=${per_page}&service_type=${type}`;
				const res = await axios.get(api);
				this.services = res.data.data;
				if (type == 1) {
					this.tabServiceCheck = res.data.data
				} else {
					this.tabServiceVaccine = res.data.data
				}
			} catch (error) {
				console.log(error)
				// console.error('Error fetching service:', error);
			}
		},
		getInput() {
			try {
				// api/services?per_page=2&page=5&search=
				// const serviceType = this.filter.service_type === null ? '' : `&service_type=${this.filter.service_type}`;
				axios.get(`/api/services?per_page=5&search=${this.inputsearch}`).then(res => {
					this.inputService = res.data.data;
					// console.log(this.inputService)
				});
			} catch (error) {
				console.log("Error message: ", error);
			}
		},
		async getService(p, serviceType = this.filter.service_type, skipGlobalLoading = false, search = '') {
			try {
				if (!skipGlobalLoading) {
					if (this.currentPage !== p) {
						this.paginationLoading = true;
					} else {
						this.loading = true;
					}
				}
				let url = `/api/services?per_page=5&page=${p}`;
				this.inputsearch = search;
				if (this.inputsearch.trim() !== '') {
					url += `&search=${this.inputsearch}`;
				}
				this.filter.service_type = serviceType;
				if (this.filter.service_type) {
					url += `&service_type=${this.filter.service_type}`;
				}
				const res = await axios.get(url);
				this.services = res.data.data;
				this.currentPage = p;
				sessionStorage.setItem('currentPage', p);
				sessionStorage.setItem('serviceType', serviceType);
				this.totalPage = res.data.paginate.total_page;
			} catch (error) {
				console.error('Error fetching service:', error);
			} finally {
				this.loading = false;
				this.paginationLoading = false;
			}
		},
		async getAllService(p, serviceType = this.filter.service_type, skipGlobalLoading = false) {
			try {
				if (!skipGlobalLoading) {
					if (this.currentPage !== p) {
						this.paginationLoading = true;
					} else {
						this.loading = true;
					}
				}
				const res = await axios.get(`/api/services?&page=${p}&service_type=${serviceType}`);
				this.allServices = res.data.data;
				this.filter.service_type = serviceType;
				this.currentPage = p;
				sessionStorage.setItem('currentPage', p);
				sessionStorage.setItem('serviceType', serviceType);
				this.totalPage = res.data.paginate.total_page;
			} catch (error) {
				console.error('Error fetching service:', error);
			} finally {
				this.loading = false;
				this.paginationLoading = false;
			}
		},
		async onClickDetail(id) {
			try {
				if (id) {
					this.loading = true
					sessionStorage.setItem("serviceId", id);
					this.getServiceDetail();
					router.push("/packagedetail");
				}
			} finally {
				this.loading = false
			}
		},
		async onClickDetailSameRoute(id) {
			this.loading = true
			try {
				if (id) {
					sessionStorage.setItem("serviceId", id);
					await this.getServiceDetail();
				}
			} catch (error) {
				console.log("Error message: ", error);
			} finally {
				this.loading = false
			}
		},
		async getServiceDetail() {
			this.loading = true;
			this.service = [];
			try {
				this.selectId = sessionStorage.getItem("serviceId")
				const res = await axios.get(`/api/services/${this.selectId}`);
				this.service = res.data.data;
			} catch (error) {
				console.error('Error fetching service:', error);
			} finally {
				this.loading = false;
			}
		},
		onClickBook(id) {
			const authStore = useAuthStore()
			authStore.loadData();

			if (!authStore.token) {
				router.push('/login')
				return
			}
			if (id) {
				sessionStorage.setItem("serviceId", id);
				router.push("/book-appointment");
			}
		}


	}
})