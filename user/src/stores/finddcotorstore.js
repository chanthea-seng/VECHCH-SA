import { defineStore } from "pinia";
import { ref } from "vue";
import router from "@/router";
import axios from "axios";
import { useAuthStore } from "./authTokenStore";
export const historySearch = defineStore('finddoctorstore', {
	state: () => ({
		doctors: ref([]),
		doctor: null,
		DoctorId: null,
		is_save: ref(null),
		filter: {
			specialist: null,
			inputSearch: '',
			selectId: null,
		},
		experience: [],
		specialists: ref([]),
		inputDoctor: ref([]),
		totalPage: 1,
		doctorSave: ref([]),
		SaveDoctorData: ref([]),
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
		loading: ref(false),
		loadingPagination: ref(false),
		selectId: sessionStorage.getItem("selectId") || null,
		dataFetched: false,
	}),
	getters: {
		is_save: (state) => (doctorId) => {
			const normalizedId = Number(doctorId);
			const isSaved = state.doctorSave.includes(normalizedId);
			return isSaved ? 1 : 0;
		},
	},
	actions: {
		isSaved() {
			const saved = this.doctorSave.some(
				(d) => d.id == this.DoctorId
			);
			this.is_save = saved ? 1 : 0;
		},
		async fetchAllData() {
			try {
				this.loading = true
				await Promise.all([
					this.getDoctor(this.currentPage),
				])
			} catch (error) {
				// console.log('Error message: ', error)
			} finally {
				this.loading = false
			}
		},
		// onClickSave(id) {
		// 	const authStore = useAuthStore();
		// 	authStore.loadToken()
		// 	if (authStore.token) {
		// 		try {
		// 			let frmData = new FormData;
		// 			frmData.append('doctor_id', id)
		// 			const response = axios.post("/api/save/doctors", frmData, {
		// 				headers: {
		// 					Authorization: `Bearer ${authStore.token}`,
		// 					"Content-Type": "multipart/form-data",
		// 				},
		// 			});
		// 			// if (this.doctor && this.doctor.id === id) {
		// 			// 	this.doctor.is_save = true;
		// 			// }
		// 			// this.isSaved()
		// 		} catch (error) {
		// 			console.error("Error:", error);
		// 		}
		// 	}
		// 	else {
		// 		// authStore.mdlCheckToken.show()
		// 		router.push('/login')
		// 	}

		// },
		async onSaveDoctor(id) {
			const authStore = useAuthStore();
			authStore.loadToken();

			if (!authStore.token) {
				const router = useRouter();
				router.push('/login');
				return;
			}

			this.isLoading = true;
			try {
				const frmData = new FormData();
				frmData.append('doctor_id', id);
				const response = await axios.post('/api/save/doctors', frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						'Content-Type': 'multipart/form-data',
					},
				});
				if (!this.doctorSave.includes(id)) {
					this.doctorSave.push(id);
				}
			} catch (error) {
				console.error('Error saving doctor:', error.response?.data || error.message);
				throw error;
			} finally {
				this.isLoading = false;
			}
		},
		async onRemoveDoctor(id) {
			const authStore = useAuthStore();
			authStore.loadToken();

			if (!authStore.token) {
				const router = useRouter();
				router.push('/login');
				return;
			}

			this.isLoading = true;
			try {
				await axios.delete(`/api/save/doctors/${id}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
					},
				});
				this.doctorSave = this.doctorSave.filter((doctorId) => doctorId !== id);
				// console.log('Saved doctors:', this.doctorSave);
			} catch (error) {
				// console.error('Error removing doctor:', error.response?.data || error.message);
				throw error;
			} finally {
				this.isLoading = false;
			}
		},
		async onloadSave() {
			const authStore = useAuthStore();
			authStore.loadToken();
			if (!authStore.token) {
				return;
			}
			this.isLoading = true;
			try {
				const response = await axios.get('/api/save/doctors', {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						'Content-Type': 'multipart/form-data',
					},
				});
				this.doctorSave = response.data.doctors.map((doctor) => doctor.id);
				this.SaveDoctorData = response.data.doctors;
			} catch (error) {
				// console.error('Error loading saved doctors:', error.response?.data || error.message);
				throw error;
			} finally {
				this.isLoading = false;
			}
		},
		async getSpecialists() {
			try {
				const res = await axios.get(`/api/specialists`)
				this.specialists = res.data.data;
			} catch {
			}
		},
		async getInput() {
			try {
				// axios.get(`/api/doctor/profiles?search=${this.filter.inputSearch}&specialist=${this.filter.specialist}`)
				const specialistIdParam = this.filter.specialist === null ? '' : `&specialist=${this.filter.specialist}`;
				const res = await axios.get(`/api/doctor/profiles?search=${this.filter.inputSearch}&is_verify=1${specialistIdParam}`)
				this.inputDoctor = res.data.data;
			} catch {
			}
		},
		async getDoctor(p = 1, searchQuery = '') {
			try {
				if (this.currentPage !== p || this.filter.inputSearch.trim() !== '') {
					this.loadingPagination = true;
				} else {
					this.loading = true;
				}
				let url = `api/doctor/profiles?per_page=12&page=${p}&is_verify=1`;
				this.filter.inputSearch = searchQuery;

				if (this.filter.inputSearch.trim() !== '') {
					url += `&search=${this.filter.inputSearch}`;
				}
				if (this.filter.specialist) {
					url += `&specialist=${this.filter.specialist}`;
				}
				const res = await axios.get(url);
				this.currentPage = p;
				this.doctors = res.data.data;
				if (
					this.doctors.length == 0) {
					this.filter.specialist = null
					await this.getDoctor()
				}
				this.totalPage = res.data.paginate.total_page;
				sessionStorage.setItem('currentPage', p);

			} catch (error) {
				//   console.error('Error fetching doctor:', error); 
			} finally {
				this.loading = false;
				this.loadingPagination = false;
			}
		},
		// async getDoctor(p) {
		// 	try {
		// 		if(this.currentPage !== p || this.filter.inputSearch.trim() !== ''){
		// 			this.loadingPagination = true
		// 		}else{
		// 			this.loading = true
		// 		}
		// 		const res = await axios.get(`api/doctor/profiles?per_page=12&page=${p}`);
		// 		this.currentPage = p;
		// 		this.doctors = res.data.data;
		// 		this.totalPage = res.data.paginate.total_page;
		// 		sessionStorage.setItem('currentPage', p);
		// 	} catch (error) {
		// 		console.error('Error fetching doctor:', error);
		// 	}finally{
		// 		this.loading = false;
		// 		this.loadingPagination = false
		// 	}
		// },
		async onClickToDetail(id) {
			this.loading = true
			try {
				let selectId = (this.selected_id = id);
				if (selectId) {
					sessionStorage.setItem("selectId", selectId);
					router.push(`/doctorprofile/${selectId}`);
					await this.getDocDetail();
				}
			} finally {
				this.loading = false
			}
		},
		async getDocDetail() {
			this.loading = true;
			try {
				this.DoctorId = sessionStorage.getItem("selectId")
				if (this.DoctorId) {
					const res = await axios.get(`/api/doctor/profiles/${this.DoctorId}`);
					this.doctor = res.data.data;
				}
			} catch (error) {
				// console.error('Error fetching service:', error);
			} finally {
				this.loading = false
			}
		},
		async getDocEdu() {
			try {

				const res = await axios.get(`/api/doctor/profiles/${this.selectId}`);
				this.edus = res.data.data;

			} catch (error) {
				// console.error('Error fetching service:', error);
			}
		},
		async setSelectId(id) {
			try {
				this.loading = true;
				if (this.selectId === id) {
					this.doctor = [];
					await this.getDocDetail();
				} else {
					this.selectId = id;
					sessionStorage.setItem("selectId", id);
					await this.getDocDetail();
				}
			} finally {
				this.loading = false
			}
		},
		onClickToBooking(id) {
			const authStore = useAuthStore()
			authStore.loadToken()
			if (!authStore.token) {
				router.push('/login')
				return
			}
			let selected = id;

			if (selected) {
				sessionStorage.setItem('selectId', selected);
				router.push('/book-appointment');
			}
		}

	}

})