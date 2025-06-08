import { defineStore } from 'pinia';
// import { computed } from 'vue';
import { useVuelidate } from '@vuelidate/core';
import { required, helpers, email } from '@vuelidate/validators';
import axios from 'axios';
import { ref } from 'vue';

export const appointment = defineStore('bookingstore', {
	state: () => ({
		bookingfrm: {
			name: '',
			local_name: '',
			dob: '',
			gender: '',
			phone_number: '',
			email: '',
			dob: '',
			gender: '',
			description: '',
			appointment_time: '',
			doctor_id: null,
			checkbox: false


		},
		filter: {
			inputSearch: '',
			category_id: 4,
			per_page: 12,
			sdir: 'asc',
		},
		fileShow: {
			file: null,
			filePreview: null,
			filename: null,
			paymentFile: null,


		},

		paymentfrm: {
			cardName: '',
			cardNumber: '',
			cardExpiry: '',
			cardCVC: '',
		},

		validation: {
			vvbooking: null,
			vvpayment: null,
		},

		patient: [],
		activeTab: 1,

		options: [
			{
				id: 1,
				title: 'ជ្រើសរើសវេជ្ជបណ្ឌិតដោយខ្លួនឯង',
				icon: '/assets/images/auth/icon/find_doctor.png'
			},
			{
				id: 2,
				title: 'ណែនាំវេជ្ជបណ្ឌិតសម្រាប់ខ្ញុំ',
				icon: '/assets/images/auth/icon/find_doctor.png'
			},

		],
		tabsOption: [
			{
				id: 1,
				title: 'ស្វែងរកវេជ្ជបណ្ឌិត',
			},
			{
				id: 2,
				title: 'រក្សាទុករបស់ខ្ញុំ'
			}
		],
		service_type: null,

		chooseoption: [
			{
				id: 0,
				value: 'consult',
				title: 'ពិគ្រោះជាមួយវេជ្ជបណ្ឌិត',
				icon: '/assets/images/auth/icon/find_doctor.png'

			},
			{
				id: 1,
				value: 'checkup',
				title: 'ពិនិត្យសុខភាព',
				icon: '/assets/images/auth/icon/check-up.png'
			},
			{
				id: 2,
				value: 'vaccine',
				title: 'វ៉ាក់សាំង',
				icon: '/assets/images/auth/icon/vaccination.png'
			},
		],
		package: [],
		mdl_packages: null,
		bookingHistory: [],
		sub_service_id: null,
		PackageName: '',
		showhistory: false,
		packageList: [],
		doctors: [],
		consult_option: null,

	}),
	actions: {
		BookItem(item) {
			const exists = this.bookingHistory.some((booking) => booking.id === item.id);
			if (!exists) {
				this.bookingHistory.push(item);
				if (this.service_type === 0) {
					this.bookingfrm.doctor_id = item.id;
				}
				else {
					this.sub_service_id = item.id;
				}
				// console.log(item);

			}
			this.showhistory = true;
			if (this.mdl_packages) {
				this.mdl_packages.hide();
			}

		},
		GoBack(clearHistory = false) {
			this.showhistory = false;
			if (clearHistory) {
				this.bookingHistory = [];
			}
		},
		changeTab(tabId) {
			this.activeTab = tabId;
		},
		setServiceType(id) {
			this.service_type = id;
		},
		setConsultOption(id) {
			this.consult_option = id;
		},
		setupValidation() {
			const minAge = (value) => {
				if (!value) return true;
				const dob = new Date(value);
				const today = new Date('2025-04-03');
				const age = today.getFullYear() - dob.getFullYear();
				const monthDiff = today.getMonth() - dob.getMonth();
				const dayDiff = today.getDate() - dob.getDate();

				// Adjust age if birthday hasn't occurred this year
				let adjustedAge = age;
				if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
					adjustedAge--;
				}

				return adjustedAge >= 1;
			};

			// const maxAge = (value) => {
			//     if (!value) return true; 
			//     const dob = new Date(value);
			//     const today = new Date('2025-04-03');
			//     const age = today.getFullYear() - dob.getFullYear();
			//     const monthDiff = today.getMonth() - dob.getMonth();
			//     const dayDiff = today.getDate() - dob.getDate();

			//     let adjustedAge = age;
			//     if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
			//         adjustedAge--;
			//     }

			//     return adjustedAge <= 120;
			// };
			const bookingRules = {
				name: {
					required: helpers.withMessage('សូមបញ្ចូលឈ្មោះរបស់អ្នក!', required)
				},
				local_name: {
					reqquired: helpers.withMessage('សូមបញ្ចូលឈ្មោះរបស់អ្នក!', required)
				},
				dob: {
					required: helpers.withMessage('សូមបញ្ចូលថ្ងៃខែឆ្នាំកំណើតរបស់អ្នក!', required),
					minAge: helpers.withMessage('អ្នកត្រូវតែមានអាយុយ៉ាងតិច ១ ឆ្នាំ!', minAge),
					// maxAge: helpers.withMessage('អ្នកមិនអាចមានអាយុលើសពី ៨០ ឆ្នាំបានទេ!', maxAge)
				},
				gender: {
					required: helpers.withMessage('សូមជ្រើសរើសភេទរបស់អ្នក!', required)
				},
				phone_number: {
					required: helpers.withMessage('សូមបញ្ចូលលេខទូរស័ព្ទរបស់អ្នក!', required),
					regex: helpers.withMessage('សូមបញ្ចូលលេខទូរស័ព្ទដែលត្រឹមត្រូវ!', helpers.regex(/^\+?[0-9]{1,3}[0-9]{3,14}$/))
				},
				email: {
					required: helpers.withMessage('សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលរបស់អ្នក!', required),
					email: helpers.withMessage('សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលដែលត្រឹមត្រូវ!', email)
				},
				checkbox: {
					checked: helpers.withMessage(
						'អ្នកត្រូវតែយល់ព្រមជាមួយលក្ខខណ្ឌ!',
						value => value === true
					)
				}
			}


			this.validation.vvbooking = useVuelidate(bookingRules, this.bookingfrm);
		},
		setFile(file) {
			if (file) {
				this.fileShow.file = file.name;
				if (this.service_type == 0) {

					this.fileShow.filename = file;

				} else {
					this.fileShow.paymentFile = file;
				}
				this.fileShow.filePreview = URL.createObjectURL(file);

			}
		},
		removeFile() {
			this.fileShow.file = null;
			this.fileShow.filePreview = null;
		},

		getAlldoctor() {
			axios.get('/api/doctor/profiles')
				.then(res => {
					// console.log(res.data.data);
					this.doctors = res.data.data;
					//console.log(this.doctors);

				});
		},
		getdoctorSearch() {
			try {
				//console.log(this.filter.inputSearch)
				// api/doctor/profiles?
				// axios.get(`/api/doctor/profiles?search=r`)
				axios.get(`/api/doctor/profiles?search=${this.filter.inputSearch}&doctor_id=${this.filter.doctor_id}`)
					.then(res => {
						this.doctors = res.data.data;
						// console.log(this.inputDoctor)
						// console.log(res.data.data)
					});
			} catch {
			}
		},
		async getServices() {
			try {
				if (this.service_type === 1) {
					const res = await axios.get('/api/services?service_type=1')
					// console.log(res.data);
					this.package = res.data.data;

				} else if (this.service_type === 2) {
					const res = await axios.get('/api/services?service_type=2')
					// console.log(res.data);
					this.package = res.data.data;
				}

			} catch (error) {
				console.error(error);
			}
		},
		async getServiceDetail(id) {
			try {
				const res = await axios.get(`/api/services/${id}`)
				// console.log(res.data);
			} catch (error) {
				// console.error(error);
			}
		}

	}
})