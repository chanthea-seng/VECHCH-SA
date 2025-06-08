import { defineStore } from "pinia";
import axios from "axios";
import { useNotyfStore } from "./notyfStore";
import { ref } from "vue";
import { useAuthStore } from "./userAuthStore";
import { routeLocationKey } from "vue-router";
import router from "@/router";
export const CreateService = defineStore("CreateService", {
	state: () => ({

		maxImages: 5,
		errorMessage: "",
		selectedService: 0,
		serviceId: null,
		mdlCreateService: null,

		selectedFiles: [],
		previewImages: [],
		titleEn: "",
		titleKm: "",
		descriptionEn: "",
		descriptionKm: "",
		instruction: '',

		subService: ref([]),

		selectedId: 0,
		description: "",
		local_description: "",
		price: 0,
		is_active: 0,
	}),
	getters: {
		getServiceById: (state) => (id) => {
			return state.subService.find(service => service.id === id);
		},
	},
	actions: {
		async getServiceDetail() {
			this.clearInput();
			this.clearImage();
			this.errorMessage =
				this.titleEn =
				this.titleKm =
				this.descriptionEn =
				this.instruction =
				this.descriptionKm = '';
			this.selectedService = 0;
			this.subService = ref([]);
			try {
				this.serviceId =
					sessionStorage.getItem("serviceId")
				sessionStorage.removeItem("serviceId")
				if (this.serviceId) {
					const res = await axios.get(`/api/services/${this.serviceId}`);
					// this.service = res.data.data;
					this.titleEn = res.data.data.name;
					this.titleKm = res.data.data.local_name;
					this.descriptionEn = res.data.data.description;
					this.descriptionKm = res.data.data.local_description;
					this.selectedService = res.data.data.service_type;
					this.subService = res.data.data.sub_services;
					this.instruction = res.data.data.instruction;
					res.data.data.service_images.forEach((imgObj, index) => {
						this.previewImages[index] = imgObj.url;
					});
				}
			} catch (error) {
				// console.error('Error fetching service:', error);
			}
		},
		async updateMain() {
			const notyf = useNotyfStore();
			try {
				const frmData = new FormData();
				frmData.append("service_type", this.selectedService);
				frmData.append("name", this.titleEn);
				frmData.append("local_name", this.titleKm);
				frmData.append("description", this.descriptionEn);
				frmData.append("local_description", this.descriptionKm);
				frmData.append("instruction", this.instruction);

				if (this.selectedFiles && this.selectedFiles.length) {
					this.selectedFiles.forEach((file, index) => {
						frmData.append(`images[${index}]`, file);
					});
				}

				for (const pair of frmData.entries()) {
					console.log(pair[0], pair[1]);
				}

				const authStore = useAuthStore();
				authStore.loadToken()
				const response = await axios.post(`api/services/main/${this.serviceId}`, frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});
				notyf.success("Update Success")
			} catch (error) {
				console.log(error)
				notyf.error("Update fail")
			}
		},
		async updateSub() {
			const notyf = useNotyfStore();
			try {
				const subServiceData = this.subService.map(item => ({
					id: item.isNew ? null : item.id,
					description: item.description,
					local_description: item.local_description,
					price: Number(item.price),
					is_active: item.is_active ? 1 : 0,
					isNew: item.isNew || false
				}));
				const frmData = new FormData();
				frmData.append("sub_services", JSON.stringify(subServiceData));

				// for (const pair of frmData.entries()) {
				// 	console.log(pair[0], pair[1]);
				// }
				const authStore = useAuthStore();
				authStore.loadToken();
				const response = await axios.post(
					`api/services/sub/${this.serviceId}`,
					frmData,
					{
						headers: {
							Authorization: `Bearer ${authStore.token}`,
							"Content-Type": "multipart/form-data",
						},
					}
				);
				this.subService = this.subService.map(item => ({
					...item,
					isNew: false
				}));
				notyf.success("Update Success");
			} catch (error) {
				// console.error("Update error:", error.response?.data || error.message);
				notyf.error("Update failed");
				throw error;
			}
		},
		handleFileUpload(event) {
			const files = Array.from(event.target.files);

			if (files.length > this.maxImages) {
				this.errorMessage = `You can only upload up to ${this.maxImages} images.`;
				return;
			}
			const maxTotalSize = 1 * 1024 * 1024;
			const totalSize = files.reduce((sum, file) => sum + file.size, 0);

			if (totalSize > maxTotalSize) {
				this.errorMessage = "Total image size must not exceed 1MB.";
				return;
			}
			this.errorMessage = "";
			this.selectedFiles = files;
			this.previewImages = files.map((file) => URL.createObjectURL(file));
		},
		clearImage() {
			this.selectedFiles = [];
			this.previewImages = [];
			this.errorMessage = "";
			document.getElementById("choose-image").value = "";
		},
		highlightDropArea() {
			document.getElementById("drop-area").classList.add("border-primary");
		},
		removeHighlight() {
			document.getElementById("drop-area").classList.remove("border-primary");
		},
		handleDrop(event) {
			event.preventDefault();
			const files = event.dataTransfer.files;
			this.processFiles(files);
		},
		processFiles(files) {
			const validFormats = ["image/jpeg", "image/png", "image/jpg",];
			const maxSize = 1 * 1024;

			this.previewImages = [];
			this.errorMessage = "";

			for (let file of files) {
				if (!validFormats.includes(file.type)) {
					this.errorMessage = "Invalid file type. Please upload JPG, PNG, or PDF.";
					return;
				}

				if (file.size > maxSize) {
					this.errorMessage = "File size exceeds 3MB limit.";
					return;
				}

				const reader = new FileReader();
				reader.onload = (e) => {
					this.previewImages.push(e.target.result);
				};
				reader.readAsDataURL(file);
			}
		},
		clearInput() {
			this.description = this.local_description = this.price = this.is_active = "";
		},
		addSubService(service) {
			if (this.selectedId !== 0) {
				const serviceIndex = this.subService.findIndex(s => s.id === this.selectedId);
				if (serviceIndex !== -1) {
					this.subService[serviceIndex] = {
						...this.subService[serviceIndex],
						description: this.description,
						local_description: this.local_description,
						price: this.price,
						is_active: this.subService[serviceIndex].is_active
					};
					this.selectedId = 0;
				}
			} else {
				this.subService.push({
					id: this.subService.length + 1,
					description: this.description,
					local_description: this.local_description,
					price: this.price,
					is_active: 1,
					isNew: true
				});
			}
			this.clearInput();
			this.mdlCreateService.hide();
		},
		toggleStatus(serviceId) {
			const service = this.subService.find(s => s.id === serviceId);
			if (service) {
				service.is_active = service.is_active === 1 ? 0 : 1;
			}
		},
		checkIfUpdate() {
			if (this.selectedId !== 0) {
				const service = this.getServiceById(this.selectedId);
				if (service) {
					this.description = service.description;
					this.local_description = service.local_description;
					this.price = service.price;
				} else {
					this.selectedId = 0;
				}
			} else {
				this.selectedId = 0;
			}
		},
		RemoveSub() {
			this.subService = this.subService.filter(service => service.id !== this.selectedId);
			// console.log(this.subService);
		},
		async onClickCreateService() {
			const notyf = useNotyfStore();

			if (this.subService.length == 0) {
				notyf.warning('Please add sub service')
				return
			}
			const subServiceData = this.subService.map(({ id, ...rest }) => rest);
			const frmData = new FormData();
			frmData.append("service_type", this.selectedService);
			frmData.append("name", this.titleEn);
			frmData.append("local_name", this.titleKm);
			frmData.append("description", this.descriptionEn);
			frmData.append("local_description", this.descriptionKm);
			frmData.append("instruction", this.instruction);
			frmData.append("sub_services", JSON.stringify(subServiceData));

			if (this.selectedFiles && this.selectedFiles.length) {
				this.selectedFiles.forEach((file, index) => {
					frmData.append(`images[${index}]`, file);
				});
			} else {
				notyf.warning('Please add image')
				return
			}

			// for (const pair of frmData.entries()) {
			// 	console.log(pair[0], pair[1]);
			// }

			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const response = await axios.post("api/services", frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				});

				notyf.success("Task successfully completed!");
				// console.log(response.data.data);
				this.clearInput();
				this.clearImage();
				this.errorMessage =
					this.titleEn =
					this.titleKm =
					this.instruction =
					this.descriptionEn =
					this.descriptionKm = '';
				this.selectedService = 0;
				this.subService = ref([]);
				router.push('/service')
			} catch (error) {
				// console.log(error);
				if (error.response && error.response.data) {
					const errorMessage = error.response.data.message || "Something went wrong";
					const errorDetails = error.response.data.errors;
					let detailedMessage = errorMessage;

					if (errorDetails) {
						detailedMessage += "\n" + Object.values(errorDetails)
							.map((err) => err.join(", "))
							.join("\n");
					}
					// console.log(detailedMessage);
					notyf.error("Fail to create service.");

				} else {
					notyf.error("An unexpected error occurred.");
				}
			}
		}

	},
});
