import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";
import router from "@/router";
import { useAuthStore } from "./authTokenStore";

export const articleStore = defineStore('articalStore', {
	state: () => ({
		filter: {
			searchArticle: '',
			contentType: '',
			per_page: 20,
			scol: '',
			sdir: "asc",
			category_id: null,
		},
		cates: ref([]),
		inputsearch: '',
		inputarticle: ref([]),
		article: ref([]),
		articlesave: [],
		bannerArticle: null,
		articaleDetails: [],
		selected_id: 0,
		page: 1,
		getpaginateArticle: [],
		totalPage: 1,
		currentPage: sessionStorage.getItem('currentPage') ? parseInt(sessionStorage.getItem('currentPage')) : 1,
		paginationLoading: ref(false),
		loading: ref(false),
		firstArticle: null,
		secondArticle: null,
		typeofCategory: sessionStorage.getItem('typeofCategory'),
		// typeofCategory: ref(sessionStorage.getItem('typeofCategory') || null), 
		selectId: sessionStorage.getItem("selectId") || null,
		dataFetched: false,
	}),
	actions: {
		async fetchAllFunctions() {
			if (this.dataFetched || this.loading) {
				return;
			}
			try {
				this.loading = true;
				this.articaleDetails = []
				this.firstArticle = await this.onloadArticleByID(4);
				this.secondArticle = await this.onloadArticleByID(5);
				// await Promise.all([
				// 	this.getCate(),
				// ])
				this.dataFetched = true;
			} catch (error) {
				// console.log("Error message: ", error)
			} finally {
				this.loading = false
			}
		},
		async onClickView() {
			try {
				const id = sessionStorage.getItem("selectId");
				const res = await axios.post(`/api/articles/view/${id}`)
			} catch (error) {
				// console.log("Error message: ", error)
			}
		},
		async setSelectId(id) {
			try {
				this.loading = true;
				if (this.selectId === id) {
					this.articaleDetails = [];
					await this.getArticleDetail(); // Reload only article details, not the full page
				} else {
					this.selectId = id;
					sessionStorage.setItem("selectId", id);
					await this.getArticleDetail();
				}
			} finally {
				this.loading = false
			}
		},
		async getArticleDetail() {
			try {
				this.loading = true;
				this.articaleDetails = [];
				const selectId = sessionStorage.getItem("selectId");
				if (selectId) {
					const res = await axios.get(`/api/articles/${selectId}`)
					this.articaleDetails = [res.data.data];
					sessionStorage.setItem('articaleDetails', JSON.stringify(this.articaleDetails));
				}
			} catch (error) {
				// console.log("Error message: ", error);
			} finally {
				this.loading = false;
			}
		},
		async onSaveArticle(id) {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();
				const frmData = new FormData();
				frmData.append('article_id', id);

				const response = await axios.post(`/api/save/articles`, frmData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data"
					}
				});

				this.getArticleDetail()

				// console.log('Success:', response.data.message);
			} catch (error) {
				// console.error('Error:', error.response?.data || error.message);
			}
		},
		async loadSaveArticle() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken();

				const response = await axios.get(`/api/save/articles`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data"
					}
				});

				this.articlesave = response.data.articles;

			} catch (error) {
				// console.error('Error:', error.response?.data || error.message);
			}
		},
		async onRemoveArticle(id) {
			try {
				const authStore = useAuthStore()
				authStore.loadToken()
				await axios.delete(`/api/save/articles/${id}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				})
					.then(res => {
						this.getArticleDetail()
						// console.log('id will remove : ', id);

					});
			} catch (error) {
				// console.log("Erro message: ", error)
			}
		},
		async onloadArticle() {
			this.loading = true
			try {

				const res = await axios.get(`/api/articles?type=1&per_page=${this.filter.per_page}`)
				this.article = res.data.data || [];
			} catch (error) {
				// console.log("Error message: ", error)
			} finally {
				this.loading = false;
			}
		},
		async onloadArticle2() {
			try {
				const res = await axios.get(`api/articles?alphabet=&newest=1&type=1&scol=id&per_page=&page=1&sdir=desc`)
				this.firstArticle = await res.data.data[4];
				this.secondArticle = await res.data.data[5];
				// return this.articleByID; 
			} catch (error) {
				// console.log("Error message: ", error)
			} finally {
				this.loading = false
			}
		},
		getInput() {
			try {
				const categoryIdParam = this.filter.category_id === null ? '' : `&category_id=${this.filter.category_id}`;
				axios.get(`/api/articles?search=${this.inputsearch}&type=1${categoryIdParam}`).then(res => {
					this.inputarticle = res.data.data;
				});
			} catch (error) {
				// console.log("Error message: ", error);
			}
		},
		async getCate() {
			try {
				this.loading = true
				const res = await axios.get('api/categories?content_type=1')
				this.cates = res.data.data;
			} catch (error) {
				// console.log('Message error: ', error);
			} finally {

				this.loading = false;
			}
		},
		async getArticle(id) {
			//use in other page for getting the article detail
			try {
				this.loading = true
				let selectId = (this.selected_id = id);
				if (selectId) {
					sessionStorage.setItem("selectId", selectId);
					router.push(`/article_detail/${selectId}`);
					await this.getArticleDetail();
				}
			} finally {
				this.loading = false
			}
		},
		async paginateArticle(p = 1, searchQuery = '') {
			try {
				if (this.currentPage !== p || this.inputsearch.trim() !== '') {
					this.paginationLoading = true;
				} else {
					this.loading = true;
				}
				// const 
				let url = `api/articles?per_page=12&type=1&page=${p}`;
				this.inputsearch = searchQuery;
				if (this.typeofCategory) {
					url += `&category_id=${this.typeofCategory}`;
				}
				if (this.inputsearch.trim() !== '') {
					url += `&search=${this.inputsearch}`;
				}
				const res = await axios.get(url);
				this.currentPage = p;
				sessionStorage.setItem('currentPage', p);
				this.getpaginateArticle = res.data.data;
				this.totalPage = res.data.paginate.total_page;
			} catch (error) {
				// console.log("Error message: ", error);
			} finally {
				this.loading = false;
				this.paginationLoading = false;
			}
		},
		async setCategoryId(id) {
			try {
				this.typeofCategory = id;
				sessionStorage.setItem('typeofCategory', id);
				await this.paginateArticle(1);
			} catch (error) {
				// console.log("Error message: ",  error);
			} finally {
				this.loading = false;
			}
		},
		async resetCategoryId() {
			if (this.loading) {
				return;
			}
			this.typeofCategory = null;
			sessionStorage.removeItem('typeofCategory');
			await this.paginateArticle(1);
		},
		onselectIdDoctor(id) {
			let selected = id;

			if (selected) {
				sessionStorage.setItem('selectId', selected);
				router.push('/book-appointment');
			}
		}
	}
})