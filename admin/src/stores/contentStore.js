import { defineStore } from "pinia";
import axios from "axios";
import { useNotyfStore } from "./notyfStore";
import { ref } from "vue";
import { useAuthStore } from "./userAuthStore";

export const contentStore = defineStore("view/content", {
	state: () => ({
		selectedId: 0,
		selectType: null,

		collapseTag: null,
		collapseCate: null,

		selectTagType: 1,
		selectCateType: 1,

		inputNameTag: '',
		inputLocalNameTag: '',

		inputNameCate: '',
		inputLocalNameCate: '',

		selectTagId: 0,
		tags: null,
		tagInput: '',

		selectCateId: 0,
		cates: null,
		cateInput: '',

		// contents:ref([]),
		contents: [],
		filter: {
			type: '',
			search: '',
			selectId: null,
			per_page: 12,
		},
		totalPage: 1,
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
	}),
	actions: {
		onClickClearTask(id) {
			if (id == 1) {
				this.inputNameTag = this.inputLocalNameTag = "";
				this.selectTagId = 0;
				this.collapseTag.toggle();
			}
			else {
				this.inputNameCate = this.inputLocalNameCate = "";
				this.selectCateId = 0;
				this.collapseCate.toggle();
			}
		},
		async getTag() {
			try {
				let response = null;
				if (this.selectTagType == 1) {
					response = await axios.get(`/api/tags?content_type=${this.selectTagType}`, {
						headers: { Accept: 'application/json' }
					});
				} else {
					response = await axios.get(`/api/tags?content_type=${this.selectTagType}`, {
						headers: { Accept: 'application/json' }
					});
				}
				this.tags = response.data.data;
			} catch (error) {
				// console.error('Failed to fetch tags:', error);
			}
		},
		async getCate() {
			try {
				let response = null;
				if (this.selectCateType == 1) {
					response = await axios.get(`/api/categories?content_type=${this.selectCateType}`, {
						headers: { Accept: 'application/json' }
					});
				} else {
					response = await axios.get(`/api/categories?content_type=${this.selectCateType}`, {
						headers: { Accept: 'application/json' }
					});
				}
				this.cates = response.data.data;
			} catch (error) {
				// console.error('Failed to fetch tags:', error);
			}
		},
		async getCreate(type) {
			const notyf = useNotyfStore();
			const authStore = useAuthStore();
			authStore.loadToken()
			try {
				if (type == 1) {
					if (this.inputLocalNameTag == '' && this.inputNameTag == '') {
						notyf.warning("Please Input First");
						return
					}

					const frmData = new FormData();
					frmData.append("name", this.inputNameTag);
					frmData.append("local_name", this.inputLocalNameTag);

					if (this.selectTagId != 0) {
						await axios.post(`/api/tags/${this.selectTagId}`, frmData, {
							headers: {
								Accept: 'application/json',
								Authorization: `Bearer ${authStore.token}`,
							}
						});
						this.selectTagId = 0;
					} else {
						frmData.append("content_type", this.selectTagType);
						await axios.post(`/api/tags`, frmData, {
							headers: {
								Accept: 'application/json',
								Authorization: `Bearer ${authStore.token}`,
							}
						});
					}
					this.onClickClearTask(type);
					await this.getTag();
					this.collapseTag.toggle();
				}
				else {
					if (this.inputNameCate == '' && this.inputLocalNameCate == '') {
						notyf.warning("Please Input First");
						return
					}
					const frmData = new FormData();
					frmData.append("name", this.inputNameCate);
					frmData.append("local_name", this.inputLocalNameCate);

					if (this.selectCateId != 0) {
						await axios.post(`/api/categories/${this.selectCateId}`, frmData, {
							headers: {
								Accept: 'application/json',
								Authorization: `Bearer ${authStore.token}`,
							}
						});
						this.selectCateId = 0;
					} else {
						frmData.append("content_type", this.selectCateType);
						await axios.post(`/api/categories`, frmData, {
							headers: {
								Accept: 'application/json',
								Authorization: `Bearer ${authStore.token}`,
							}
						});
					}
					this.onClickClearTask(type);
					await this.getCate();
					this.collapseCate.toggle();
				}
				notyf.success("Task successfully completed!");
			} catch (error) {
				if (error.response && error.response.data) {
					// const errorMessage = error.response.data.message || "Something went wrong";
					// const errorDetails = error.response.data.errors;
					// let detailedMessage = errorMessage;

					// if (errorDetails) {
					// 	detailedMessage += "\n" + Object.values(errorDetails)
					// 		.map((err) => err.join(", "))
					// 		.join("\n");
					// }
					notyf.error(error);
				} else {
					notyf.error("An unexpected error occurred.");
				}
			}
		},
		async deleteItem(type, id) {
			const notyf = useNotyfStore();
			const authStore = useAuthStore()
			authStore.loadToken()
			try {
				let response = null;
				if (type == 1) {
					response = await axios.delete(`/api/tags/${id}`, {
						headers: {
							Accept: 'application/json',
							Authorization: `Bearer ${authStore.token}`,
						}
					});
					this.selectTagType = this.selectType
					this.tags = await this.getTag()
				} else {
					response = await axios.delete(`/api/categories/${id}`, {
						headers: {
							Accept: 'application/json',
							Authorization: `Bearer ${authStore.token}`,
						}
					});
					this.selectCateType = this.selectType
					this.cates = await this.getCate()
				}
				this.selectType = null;
				this.selectedId = 0;
				notyf.success("Task successfully completed!");

			} catch (error) {
				// console.error('Failed to fetch tags:', error);
				notyf.error("An unexpected error occurred.");
			}
		},
		async searchTag() {
			try {
				const response = await axios.get(`/api/tags?search=${this.tagInput}&content_type=${this.selectTagType}`, {
					headers: { Accept: 'application/json' }
				});
				this.tags = response.data.data;
			} catch (error) {
				// console.error('Failed to fetch tags:', error);
			}
		},
		async searchCate() {
			try {
				const response = await axios.get(`/api/categories?search=${this.cateInput}&content_type=${this.selectCateType}`, {
					headers: { Accept: 'application/json' }
				});
				this.cates = response.data.data;
			} catch (error) {
				// console.error('Failed to fetch tags:', error);
			}
		},
		async getContent() {
			try {
				const res = await axios.get(`/api/articles?search=${this.filter.search}&type=${this.filter.type}`);
				this.contents = res.data.data;
			} catch (error) {
				// console.error('Error fetching articles:', error);
			}
		},
	}
})