<template>
  <section class="news-know knowledge article mb-4">
    <div class="container position-relative">
      <div class="row g-3">
        <div class="col-12 m-auto p-0 my-3 row g-0 align-items-center">
          <div class="col position-relative">
            <form
              @submit.prevent="onSearchSubmit"
              class="search-container d-flex align-items-center"
            >
              <div class="select-wrapper col-3">
                <select
                  name="cate"
                  id="cate"
                  class="form-select form-select-global"
                  placeholder="ជ្រើសរើសប្រភេទ"
                  @focus="isSelectOpen = true"
                  @blur="isSelectOpen = false"
                  v-model="articlestore.filter.category_id"
                  @change="
                    articlestore.setCategoryId(articlestore.filter.category_id)
                  "
                >
                  <option :value="null">ទាំងអស់</option>
                  <option
                    v-for="cate in articlestore.cates"
                    :key="cate.id"
                    :value="cate.id"
                  >
                    {{ cate.local_name }}
                  </option>
                </select>
                <i
                  :class="[
                    'bi',
                    'bi-chevron-down',
                    'select-icon',
                    { rotate: isSelectOpen },
                  ]"
                ></i>
              </div>

              <!-- v-model="articlestore.inputsearch" @keydown.enter="onSearchSubmit"  @focus="showSearch = true" -->
              <input
                type="text"
                class="form-control bg-transparent"
                placeholder="ស្វែងរកអត្ថបទ"
                aria-label="Search"
                v-model="articlestore.inputsearch"
                @input="onSearchInput"
                @focus="showSearch = true"
                @blur="hideSearchHistory"
              />
              <span class="search-icon position-absolute">
                <i class="fa-regular fa-magnifying-glass"></i>
              </span>
            </form>
            <div
              class="card card-search position-absolute z-3"
              v-if="showSearch && articlestore.inputarticle.length"
              @mousedown.prevent
            >
              <ul class="list-group">
                <li
                  class="list-group-item"
                  v-for="data in articlestore.inputarticle"
                  :key="data.id"
                >
                  <a
                    role="button"
                    class="d-flex justify-content-between align-items-center text-decoration-none text-color-950"
                    @click="articlestore.getArticle(data.id)"
                  >
                    <span>{{ data.title }}</span>
                    <div class="dot"></div>
                  </a>
                </li>
              </ul>
            </div>
            <!-- <div class="card card-search position-absolute z-3" v-if="true" @mousedown.prevent> -->
            <!-- <div class="card card-search" v-if="showSearch">
              <div class="card-body h-100">
                <div class="d-flex flex-wrap gap-3">
                  <div class="p-2 border rounded-3" v-for="data in articlestore.inputarticle.slice(0, 6)" :key="data.id">
                    <a role="button" @click="onClickToDetail(data.id)">
                      <span>{{ data.title }}</span>
                    </a>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
          <!-- <div class="col-1">
            <div class="d-flex align-items-center column-gap-2">
              <a role="button" @click="articleStore.onClickOrder()">
              <span class="fs-5">
                <i
                  class="bi"
                  :class="
                    articleStore.filter.sdir === 'desc'
                      ? 'bi-sort-down-alt'
                      : 'bi-sort-up'
                  "
                ></i>
              </span>
            </a>
              <div class="ms-3 w-100">
                <select class="form-select" v-model="articlestore.filter.per_page"
                  @change="articlestore.onloadArticle()">
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="30">30</option>
                </select>
              </div>
            </div>
          </div> -->
        </div>

        <div
          v-for="article in articlestore.getpaginateArticle"
          :key="article.id"
          class="col-3"
        >
          <a
            role="button"
            @click="articlestore.getArticle(article.id)"
            class="card border-0 news box-shadow text-decoration-none overflow-hidden h-100"
          >
            <div class="img rounded-3 overflow-hidden position-relative">
              <img
                :src="article.thumbnail"
                class="w-100 h-100 object-fit-cover"
                alt=""
              />
              <div class="tag">
                {{ article.category?.local_name }}
              </div>
            </div>
            <div
              class="card-body pt-2 position-relative d-flex flex-column flex-wrap justify-content-between"
            >
              <div>
                <h5 class="mb-0 pb-0 limit-line-2">{{ article.title }} </h5>
                <p
                  class="my-2 text-color-gray limit-line-2"
                  style="font-size: 15px"
                >
                  {{ article.short_description }}
                </p>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div
                  class="txt-small text-color-text fw-medium"
                  style="font-size: 14px"
                >
                  <i class="bi bi-clock"></i> {{ article.updated_at }}
                </div>
                <div class="text-color-gray d-flex align-items-center">
                  <i class="bi bi-eye me-1"></i>
                  <span class="fw-medium" style="font-size: 14px">{{
                    article.view
                  }}</span>
                </div>
                <!-- <a v-show="!article.is_save" @click.stop.prevent="onSavearticle(article.id)" role="button"
                  class="position-absolute save">
                  <i class="bi bi-bookmarks-fill text-color-warning"></i>
                </a>
                <a v-show="article.is_save" @click.stop.prevent="onResetSavearticle(article.id)" role="button"
                  class="position-absolute save">
                  <i class="bi bi-bookmarks text-color-gray"></i>
                </a> -->
              </div>
            </div>
          </a>
        </div>
        <backToTop />
      </div>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { articleStore } from "@/stores/articalStore";
import { ref, onMounted, onBeforeUnmount, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { debounce } from "lodash";
const articlestore = articleStore();
const showSearch = ref(false);

const hideSearchHistory = () => {
  showSearch.value = false;
};
const isSelectOpen = ref(false);
const selectFilter = ref(null);
onMounted(async () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
  await articlestore.getCate();
  await articlestore.onloadArticle();
  articlestore.getInput();
  window.addEventListener("beforeunload", () => {
    articleStore.typeofCategory = null;
    sessionStorage.removeItem("typeofCategory");
  });
});

const onSearchSubmit = async () => {
  hideSearchHistory();
  articlestore.currentPage = 1;
  sessionStorage.setItem("currentPage", 1);
  articlestore.loading = true;
  await articlestore.paginateArticle(1, articlestore.inputsearch);
};
const onSearchInput = debounce(async () => {
  showSearch.value = true;

  if (articlestore.inputsearch.trim() !== "") {
    articlestore.getInput();
  } else {
    articlestore.inputarticle = [];
  }
}, 500);
</script>
