import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";
import { useNotyfStore } from "./notfyStore";
import { useAuthStore } from "./userAuthStore";
import router from "@/router";
export const usePostArticle = defineStore('view/postArticle', {
	state: () => ({
		articleId: 0,
		contentType: 0,
		selectedId: 0,
		isPublish: 0,
		MdlPreview: null,
		imageFile: null,
		categories: [],
		tags: [],
		author: {
			minArticle: 5,
			wroteArticle: 5,
			wroteDisease: 9,
			viewArticle: 552,
			viewDisease: 1852,
			totalContent: 14,
			unPublish: 0,
		},
		articaleDetails: ref([]),
		article: {
			title: '',
			thumbnail: '',
			short_description: '',
			category_id: '',
			tag_ids: [],
			content: "",
			type: 0,
			is_published: 0,
		},
		cards: ref([]),

		selectedCards: new Set(),
		ArrFilter: [
			{ id: 1, value: 'published_at', name: 'ថ្មីបំផុត' },
			{ id: 2, value: 'title', name: 'តម្រៀបតាមចំណងជើង' },
		],
		filter: {
			searchArticle: '',
			contentType: '',
			per_page: 20,
			scol: 'id',
			sdir: "desc",
			published: '',
		},

	}),
	actions: {
		async isAuthor() {
			const authStore = useAuthStore()
			try {
				authStore.loadToken()
				const response = await axios.get("/api/author/write-article", {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
					},
				});
				return response.data.result;
			} catch (error) {
				router.push('/article')
			}
		},
		async getArticleData() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const res = await axios.get(`/api/author/article-count`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`
					}
				});
				this.author.totalContent = res.data.data.total_article;
				this.author.wroteArticle = res.data.data.total_general_article;
				this.author.wroteDisease = res.data.data.total_disease_article;
				this.author.viewArticle = res.data.data.total_views_article;
				this.author.unPublish = res.data.data.total_unpublished;
			} catch (error) {
				// console.error('Error fetching articles:', error);
			}
		},
		getCategoryLocalName(categoryId) {
			const category = this.categories.find(cat => cat.id === categoryId);
			return category ? category.local_name : null;
		},
		getTagLocalNames(tagIds) {
			return this.tags
				.filter(tag => tagIds.includes(tag.id))
				.map(tag => tag.local_name);
		},
		async getArticle() {
			try {
				const authStore = useAuthStore();
				authStore.loadToken()
				const res = await axios.get(`/api/author?search=${this.filter.searchArticle}&type=${this.filter.contentType}&per_page=${this.filter.per_page}&scol=${this.filter.scol}&sdir=${this.filter.sdir}&published=${this.filter.published}`, {
					headers: {
						Authorization: `Bearer ${authStore.token}`
					}
				});
				this.cards = res.data.data;
			} catch (error) {
				// console.error('Error fetching articles:', error);
			}
		},
		async getCategories(id) {
			try {
				const res = await axios.get(`/api/categories?content_type=${id}`);
				this.categories = res.data.data;
				// console.log(this.categories)
			} catch (error) {
				// console.error("Error fetching categories:", error.response?.data || error.message);
			}
		},
		async getTags(id) {
			try {
				const res = await axios.get(`/api/tags?content_type=${id}`);
				this.tags = res.data.data;
				// console.log(this.tags);
			} catch (error) {
				// console.error("Error fetching categories:", error.response?.data || error.message);
			}
		}
		,
		async getSingleArticle(id) {
			try {
				const res = await axios.get(`/api/articles/${id}`);
				this.article.title = res.data.data.title;
				this.article.thumbnail = res.data.data.thumbnail;
				this.article.short_description = res.data.data.short_description;
				this.article.content = res.data.data.content;
				this.article.type = res.data.data.type;
				this.article.is_published = res.data.data.is_published;
				this.article.category_id = res.data.data.category?.id ?? null;
				this.article.tag_ids = res.data.data.tags
				await this.getTags(this.article.type)
				await this.getCategories(this.article.type)
			} catch (error) {
				// console.error('Error fetching articles:', error);
				router.push('/article')
			}
		},
		clearArticle() {
			this.article = {
				title: '',
				thumbnail: '',
				short_description: '',
				category_id: '',
				tag_ids: [],
				content: '',
				type: 0,
				is_published: 0,
			};
		},
		async handleSubmit() {
			const notyf = useNotyfStore();
			const validation = this.onClickValidate();
			if (validation != null) {
				notyf.warning(validation.message);
				return;
			}
			await this.onClickSubmit();
			this.clearArticle();
			router.push('/article');

		},
		onClickValidate() {
			const noThumbnailRegex = /no_thumbnail\.jpg$/;
			if (!this.article.thumbnail || noThumbnailRegex.test(this.article.thumbnail)) {
				return { success: false, message: 'អត្ថបទរូបភាពត្រូវបានទាមទារ' };
			}
			if (!this.article.title) {
				return { success: false, message: 'ចំណងជើងត្រូវបានទាមទារ' };
			}
			if (!this.article.short_description) {
				return { success: false, message: 'ការពិពណ៌នាខ្លីត្រូវបានទាមទារ' };
			}
			if (this.article.category_id == null) {
				return { success: false, message: 'ប្រភេទអត្ថបទត្រូវបានទាមទារ' };
			}
			if (!Array.isArray(this.article.tag_ids) || this.article.tag_ids.length === 0) {
				return { success: false, message: 'Tag អត្ថបទត្រូវបានទាមទារ' };
			}
			if (!this.article.content) {
				return { success: false, message: 'មាតិកាត្រូវបានទាមទារ' };
			}

			return null
		},
		async onClickSubmit() {
			const notyf = useNotyfStore();
			let message = 'អត្ថបទរបស់អ្នកត្រូវបានរក្សាទុក';
			if (this.isPublish === 1) {
				message = 'អត្ថបទរបស់អ្នកត្រូវបានផ្សព្វផ្សាយ';
			}

			const formData = new FormData();

			if (this.article.thumbnail && this.article.thumbnail instanceof File) {
				formData.append("thumbnail", this.article.thumbnail);
			}
			formData.append("type", this.article.type);

			formData.append("content", this.article.content);
			if (this.article.title != null) {
				formData.append("title", this.article.title);
			}
			if (this.article.short_description != null) {
				formData.append("short_description", this.article.short_description);
			}
			if (this.article.category_id != null) {
				formData.append("category_id", this.article.category_id);
			}
			if (this.article.tag_ids != null) {
				formData.append("tag_ids", JSON.stringify(this.article.tag_ids));
			}
			if (this.isPublish != 0) {
				formData.append("is_published", this.isPublish);
			}
			// formData.forEach((value, key) => {
			// 	console.log(`${key}: ${value}`);
			// });
			try {
				const authStore = useAuthStore();
				authStore.loadToken();
				await axios.post(`/api/articles/${this.articleId}`, formData, {
					headers: {
						Authorization: `Bearer ${authStore.token}`,
						"Content-Type": "multipart/form-data",
					},
				}).then(res => {
					// console.log(res);
				});

				notyf.success(message);
			} catch (error) {
				// console.log(error);
				// if (error.response && error.response.data) {
				// 	const errorMessage = error.response.data.message || "Something went wrong";
				// 	const errorDetails = error.response.data.errors;
				// 	let detailedMessage = errorMessage;

				// 	if (errorDetails) {
				// 		detailedMessage += "\n" + Object.values(errorDetails)
				// 			.map((err) => err.join(", "))
				// 			.join("\n");
				// 	}
				// console.log(error)
				notyf.error('មានបញ្ហា');

			}
		},

		async onClickOrder() {
			this.filter.sdir = this.filter.sdir === "desc" ? "asc" : "desc";
			this.getArticle();
		}
	}
})