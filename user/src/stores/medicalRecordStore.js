import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import router from "@/router";
import { useAuthStore } from "./authTokenStore";

export const medicalRecordStore = defineStore("view/medical-record", {
	state: () => ({
		// user: {
		// 	name: "ប៉ិម បញ្ញារិទ្ធ",
		// 	englishName: "PIM PANHARITH",
		// 	gender: 1,
		// 	age: 22,
		// 	phone: "098 765 4321 / 012 345 678",
		// 	email: "nhatrith@gmail.com",
		// },
		user: null,
		recodedetail: null,
		tbl_datas: ref([
			{ id: 1, type: 'examination', name: 'Complete Blood Count (CBC)', result: "Hemoglobin: 14.5 g/dL, WBC: 6,500 cells/µL, Platelets: 250,000/µL", status: 1 },
			{ id: 2, type: 'examination', name: 'Complete Blood Count (CBC)', result: "Hemoglobin: 14.5 g/dL, WBC: 6,500 cells/µL, Platelets: 250,000/µL", status: 0 },
			{ id: 3, type: 'examination', name: 'Complete Blood Count (CBC)', result: "Hemoglobin: 14.5 g/dL, WBC: 6,500 cells/µL, Platelets: 250,000/µL", status: 0 },
			{ id: 4, type: 'examination', name: 'Complete Blood Count (CBC)', result: "Hemoglobin: 14.5 g/dL, WBC: 6,500 cells/µL, Platelets: 250,000/µL", status: 1 },
		]),



	}),
	actions: {
		async getInput() {
			try {
				axios.get(`/api/articles?search=${this.inputsearch}&type=2&category_id=${this.filter.category_id}`)
					.then(res => {
						this.cardFrm = res.data.data
					})
			} catch (error) {
				// console.log("Error: ", error)
			}
		},
		async onloadArticle() {
			try {
				axios.get('api/articles?type=2')
					.then(res => {
						this.cardFrm = res.data.data
					})
			} catch (error) {
				// console.log("Error: ", error)
			}
		},
		async onloadByAlphabet() {
			try {
				axios.get('api/articles?alphabet=a&type=2')
			} catch (error) {
				// console.log("Error message: ", error)
			}
		},
		async getmedicalRecord() {
			try {
				const authStore = useAuthStore();
				const res = await axios.get(`/api/medical-records`, {
					headers: {
						Authorization: 'Bearer ' + authStore.token
					}
				});
				this.medaicalrecods = await res.data.data;

				// this.totalcommplete = await res.data.paginate.total;

			} catch (error) {
				// console.log('error  get appointment data', error);
			}
		},

		getMedicalrecordDetailId(id) {
			let selected = id;

			if (selected) {
				sessionStorage.setItem('selectId', selected);
				router.push('/medical-record');
			}

		},
		async getMedicalRecordDetail() {
			const authStore = useAuthStore();
			authStore.loadToken();
			try {
				this.loading = true;
				const selectId = sessionStorage.getItem('selectId');

				if (selectId) {

					const res = await axios.get(`/api/medical-records/${selectId}`, {
						headers: {
							Authorization: 'Bearer ' + authStore.token
						}
					})
					this.recodedetail = await res.data.data;
				}
				else {
					router.push('/account');
				}

			} catch (error) {
				// console.log('get medicalrecod detail fail'.error);
				router.push('/')

			} finally {
				this.loading = false
			}
		}






	}
})