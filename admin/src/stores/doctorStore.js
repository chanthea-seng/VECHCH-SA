import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import { useAuthStore } from "./userAuthStore";
import { useNotyfStore } from "./notyfStore";
import router from "@/router";
import { ArcElement } from "chart.js";

export const doctorStore = defineStore("view/doctor", {
	state: () => ({
		selectId: 0,
		doctorMdl: null,
		mdlRegister: null,
		mdlCreate: null,
		mdlDCreate: null,
		mdlDSuccess: null,
		name: '',
		localName: '',
		data: ref([]),
		inputName: '',
		inputLocalName: '',
		isUpdate: 0,

		dName: '',
		dLocalName: '',
		dInputName: '',
		dInputLocalName: '',
		dIsUpdate: 0,

		arrCenter: [],

		filter: {
			specialist: '',
			inputSearch: '',
			selectId: null,
			per_page: 12,
		},
		summary: null,
		appointments: null,
		doctors: [],
		doctor: null,
		doctorAvatar: null,
		loading: ref(false),
		totalPage: 1,
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
		user: {
			fullname: "",
			local_fullname: "",
			email: "",
			phone: "",
			gender: "",
			avatar: "",
		},
	}),
	actions: {
		getDataSpacailist() {
			axios.get('/api/specialists').then(res => {
				this.data = res.data.data;
			})
		},
		async onclickDelete(id) {
			const notyf = useNotyfStore()
			const authStore = useAuthStore();
			authStore.loadToken();

			try {
				await axios.delete(`/api/specialists/${id}`, {
					headers: {
						'Authorization': `Bearer ${authStore.token}`
					}
				});
				this.getDataSpacailist();
				notyf.success('Specialist deleted successfully!')
			} catch (error) {
				notyf.error('Specialist deleted failed!')
			}
		},
		async onclickInsert() {
			const notyf = useNotyfStore()
			const authStore = useAuthStore();
			authStore.loadToken();

			const name = this.inputName.trim();
			const localName = this.inputLocalName.trim();

			if (name === '' || localName === '') {
				notyf.warn("Both fields are required!");
				return;
			}
			try {
				if (this.isUpdate === 0) {
					await axios.post('/api/specialists', {
						name: name,
						local_name: localName,
					}, {
						headers: {
							'Authorization': `Bearer ${authStore.token}`
						}
					});
					notyf.success("Specialist added successfully!");
				} else {
					await axios.put(`/api/specialists/${this.isUpdate}`, {
						name: name,
						local_name: localName,
					}, {
						headers: {
							'Authorization': `Bearer ${authStore.token}`
						}
					});
					this.isUpdate = 0;
				}

				this.getDataSpacailist();
				this.inputName = '';
				this.inputLocalName = '';
				notyf.success('Task success')
			} catch (error) {
				notyf.success('Task fail')
			}
		},
		onClickUpdate($item) {
			this.inputName = $item.name;
			this.inputLocalName = $item.local_name;
			this.isUpdate = $item.id;
		},
		getDataDepartment() {
			axios.get('/api/departments', {
			}).then(res => {
				this.data = res.data.data;
			})
		}
		,
		onclickDeleteDepartment(id) {
			const notfy = useNotyfStore();
			const authStore = useAuthStore()
			authStore.loadToken();
			try {
				axios.delete(`/api/departments/${id}`, {
					headers: {
						'Authorization': `Bearer ${authStore.token}`
					}
				})
					.then(res => {
						notfy.success('Delete success')
						this.getDataDepartment();
					})
			} catch (error) {
				notfy.error('Delete fail')

			}
		},
		onclickInsertDepartment() {
			const notfy = useNotyfStore();
			const dname = this.dInputName.trim();
			const dLocalname = this.dInputLocalName.trim();
			const selectedCenter = this.selectedCenter;
			if (!dname || !dLocalname || !selectedCenter) {
				notfy.warning("Validation failed: Name, Local Name, or Center ID is missing.");
				return;
			}
			const authStore = useAuthStore()
			authStore.loadToken();
			if (this.dIsUpdate == 0) {
				axios.post('/api/departments', {
					name: dname,
					local_name: dLocalname,
					center_id: selectedCenter,
				}, {
					headers: {
						'Authorization': `Bearer ${authStore.token}`
					}
				})
					.then(res => {
						this.getDataDepartment();
						this.dInputName = '';
						this.dInputLocalName = '';
						this.selectedCenter = ''; // Reset selection
						notfy.success("Department added successfully!");
					})
					.catch(error => {
						notfy.error("Fail to create:");
					});
			} else {
				axios.put(`/api/departments/${this.dIsUpdate}`, {
					name: dname,
					local_name: dLocalname,
					center_id: selectedCenter,
				}, {
					headers: {
						'Authorization': `Bearer ${authStore.token}`
					}
				})
					.then(res => {
						this.getDataDepartment();
						this.dInputName = '';
						this.dInputLocalName = '';
						this.selectedCenter = '';
						this.dIsUpdate = 0;
						notfy.success("Department added successfully!");
					})
					.catch(error => {
						notfy.error("Fail to create:");
					});
			}
		}
		,
		onClickUpdateDepartment($item) {
			this.dInputName = $item.name;
			this.dInputLocalName = $item.local_name;
			this.selectedCenter = $item.center_id; // Set selection to current center_id
			this.dIsUpdate = $item.id;
		},
		// Get Center
		getDataCenter() {
			axios.get('/api/centers')
				.then(res => {
					this.arrCenter = res.data.data;
				})
				.catch(error => {
					// console.error('Failed to fetch centers:', error);
				});
		},
		async getDoctor(p = 12) {
			try {
				this.loading = true
				const res = await axios.get(`/api/doctor/profiles?search=${this.filter.inputSearch}&specialist=${this.filter.specialist}`)
				this.currentPage = p;
				this.doctors = res.data.data;
				this.totalPage = res.data.paginate.total_page;
				sessionStorage.setItem('currentPage', p);
			} catch (error) {
				// console.error('Error fetching doctor:', error);
			} finally {
				this.loading = false;
			}
		},
		onClickToDetail(id) {
			if (id) {
				sessionStorage.setItem("selectId", id);
				router.push("/doctor-profile");
			}
		},
		async getDocBooking() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();
				this.selectId =
					sessionStorage.getItem("doctorId")
				if (this.selectId) {
					const res = await axios.get(`/api/bookings/doctor-booking/${this.selectId}`, {
						headers: {
							Authorization: `Bearer ${authStore.token}`,
						},
					});
					this.doctor = res.data.data.doctor;
					this.appointments = res.data.data.booking;
					this.summary = res.data.data.summary
				}
				else router.push('/doctor')
			} catch (error) {
				router.push('/doctor')
				// console.error('Error fetching service:', error);
			}
		},
		onClickDoctorDetail(id) {
			if (id) {
				sessionStorage.setItem("doctorId", id);
				router.push("/doctor-detail");
			}
		},
		async getDocDetail() {
			try {
				this.selectId =
					sessionStorage.getItem("selectId")
				if (this.selectId) {
					const res = await axios.get(`/api/doctor/profiles/${this.selectId}`);
					this.doctor = res.data.data;
					this.user = res.data.data.user;
				}
				else router.push('/doctor')
			} catch (error) {
				// console.error('Error fetching service:', error);
			}
		},
		async onClickUpdateDoctorAccount() {
			const notfy = useNotyfStore()
			try {
				const frmData = new FormData();
				if (this.doctorAvatar) {
					frmData.append('avatar', this.doctorAvatar);
				}
				frmData.append('fullname', this.doctor.user.fullname)
				frmData.append('local_fullname', this.doctor.user.local_fullname)
				frmData.append('phone_number', this.doctor.user.phone)
				frmData.append('gender', this.doctor.user.gender)
				frmData.append('email', this.doctor.user.email)
				// for (const pair of frmData.entries()) {
				// 	console.log(pair[0], pair[1]);
				// }
				const authStore = useAuthStore();
				authStore.loadToken();

				const res = await axios.post(`/api/doctor/admin/${this.selectId}`, frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
					},
				});
				notfy.success("Update account information success");
			} catch (error) {
				notfy.error("Please recheck account information");
				console.error('Error fetching service:', error);
			}
		},
		toggleVerified() {
			this.doctor.user.is_verify = this.doctor.user.is_verify === true ? false : true
		},
		toggleAuthor() {
			this.doctor.user.is_author = this.doctor.user.is_author === true ? false : true

		},
		async onClickUpdateDoctorProfile() {
			const notfy = useNotyfStore();
			try {
				const payload = {
					specialist_id: this.doctor.specialist.id,
					department_id: this.doctor.department.id,
					center_id: this.doctor.center.id,
					is_author: Boolean(this.doctor.user.is_author) ? 1 : 0, // Convert to 1 or 0
					is_verify: Boolean(this.doctor.user.is_verify) ? 1 : 0,
					spoken_languages: this.doctor.user.languages // send array directly
				};
				console.log(payload)
				const authStore = useAuthStore();
				authStore.loadToken();

				const res = await axios.put(
					`/api/doctor/profiles/${this.selectId}`,
					payload,
					{
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							'Content-Type': 'application/json',
						},
					}
				);
				// console.log(res.data.data)
				notfy.success("Update Doctor information success");
			} catch (error) {
				notfy.warning("Fail to update Doctor information");
				// console.error('Error updating doctor profile:', error);
			}
		}
	}
})