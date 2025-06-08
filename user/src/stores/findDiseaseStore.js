import { defineStore } from "pinia";
import axios from "axios";
import { ref } from "vue";

export const findDiseaseStore = defineStore("findDiseaseStore", {
	state: () => ({
		cardFrm: null,
		cardByAlphabet: [],
		alphabet: '',
		filter: {
			inputSearch: '',
			category_id: '',
			per_page: 12,
			sdir: 'asc',
		},
		cates: ref([]),
		cardFrmCurrentPage: sessionStorage.getItem('cardFrmCurrentPage') ? parseInt(sessionStorage.getItem('cardFrmCurrentPage')) : 1,
		cardFrmTotalPage: 1,
		loading: ref(false),
		paginationLoading: ref(false),
	}),
	actions: {
		async fetchAllData() {
			try {
				this.loading = true
				await Promise.all([
					this.getInput(),
					this.getCate(),
					this.onloadArticle(this.cardFrmCurrentPage),
				])
			} catch (error) {
				// console.log("Error message: ", error)
			} finally {
				this.loading = false;
			}
		},
		async getCate() {
			try {
				this.paginationLoading = true
				const res = await axios.get('api/categories?content_type=2');
				this.cates = res.data.data;
			} catch (error) {
				// console.log("Message: ", error);
			} finally {
				this.paginationLoading = false;
			}
		},
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
		async onloadArticle(p) {
			try {
				this.paginationLoading = true;
				const res = await axios.get(`/api/articles?type=2&per_page=8&page=${p}`)
				this.cardFrm = res.data.data;
				this.cardFrmCurrentPage = p;
				sessionStorage.setItem('cardFrmCurrentPage', p);
				this.cardFrmTotalPage = res.data.paginate.total_page;
			} catch (error) {
				// console.log("Error: ", error)
			} finally {
				this.paginationLoading = false
			}
		},
		async onLoadArticleAlphabet(value) {
			try {
				const res = await axios.get(`/api/articles?type=2&alphabet=${value}`);
				this.cardByAlphabet = res.data.data;
				this.alphabet = value;
			} catch (error) {
				// console.error("Error loading articles by alphabet:", error);
			}
		}
	}
})