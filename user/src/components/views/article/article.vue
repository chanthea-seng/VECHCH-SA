<template>
  <main>
    <loadingView v-if="articlestore.loading" />
    <section class="article-normal my-0">
      <div class="container py-5">
        <div class="row g-3 mt-3">
          <div class="col-6 m-auto p-0 mt-5 position-relative">
            <div class="text-center mb-5">
              <h3 class="text-gradient">
                អត្ថបទចំណេះដឹងសុខភាពសម្រាប់ការរស់នៅក្នុងជីវិត
              </h3>
              <span>
                យើងផ្តល់ព័ត៌មានច្បាស់លាស់ ដែលអាចអនុវត្តបានអំពីសុខភាព សុខុមាលភាព
                និងរបៀបរស់នៅ ជួយអ្នកឱ្យទទួលបានព័ត៌មាន
                និងទទួលខុសត្រូវចំពោះសុខុមាលភាពរបស់អ្នក
              </span>
            </div>
            <div class="position-relative">
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
                <input
                  type="text"
                  class="form-control bg-transparent"
                  placeholder="ស្វែងរកអត្ថបទ"
                  aria-label="Search"
                  @focus="showSearch = true"
                  @blur="hideSearch"
                  v-model="articlestore.inputsearch"
                  @input="articlestore.getInput()"
                />
                <!-- @input="debouncedSearch()" /> -->
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
                    <!-- <li class="list-group-item" v-for="data in filteredArticles" :key="data.id"> -->
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
            </div>
          </div>
          <div
            class="sec-title d-flex justify-content-between align-items-center"
          >
            <h4 class="sec-title-meduim mb-0 text-color-900">
              គន្លឹះសុខភាពទូទៅ
            </h4>
            <RouterLink
              to="/findarticle"
              class="text-decoration-none text-color-800 fw-medium see-more"
              @click="articlestore.resetCategoryId()"
              >មើលទាំងអស់
              <span><i class="fa-regular fa-angle-right"></i></span>
            </RouterLink>
          </div>
          <div class="col-4">
            <a
              v-if="articlestore.firstArticle"
              class="card article-normal cursor-pointer"
              :key="articlestore.firstArticle.id"
              @click="articlestore.getArticle(articlestore.firstArticle.id)"
            >
              <div class="image">
                <img
                  :src="articlestore.firstArticle.thumbnail"
                  class="w-100 h-100 object-fit-cover"
                  alt=""
                />
              </div>
              <div class="card-body">
                <h5 class="mb-2 text-white article-title limit-line-2">
                  {{ articlestore.firstArticle.title }}
                </h5>
                <p class="mb-0 text-color-gray text-white limit-line-2">
                  {{ articlestore.firstArticle.short_description }}
                </p>
              </div>
              <div class="post_date">
                <div class="text-white txt-small me-auto">
                  ចុះផ្សាយថ្ងៃ៖ {{ articlestore.firstArticle.updated_at }}
                </div>
                <div class="pe-5">
                  <span class="text-white pe-2 txt-small">
                    <i class="bi bi-eye"></i>
                    {{ articlestore.firstArticle.view }}
                  </span>
                  <!-- <div v-if="authStore.token">
                    <a
                      @click.stop.prevent="
                        article.is_save
                          ? articlestore.onRemoveArticle(article.id)
                          : articlestore.onSaveArticle(article.id)
                      "
                      role="button"
                      class="save"
                    >
                      <i
                        class=""
                        :class="
                          article.is_save
                            ? 'bi bi-bookmarks-fill text-color-warning'
                            : 'bi bi-bookmarks text-color-gray'
                        "
                      ></i>
                    </a>
                  </div> -->
                </div>
              </div>
            </a>
            <!-- <RouterLink to="/articleDetail" class="card article-normal">
              <div class="image">
                <img src="/src/assets/images/auth/homePage/heart-disease.jpg" class="w-100 h-100 object-fit-cover"
                  alt="" />
              </div>
              <div class="card-body">
                <h5 class="mb-2 text-white article-title limit-line-2">
                </h5>
                <p class="mb-0 text-color-gray text-white limit-line-2">
                  លោកអ្នកនឹងទទួលបានការណែនាំនិងការថែទាំសុខភាពផ្ទាល់ខ្លួនពីអ្នកជំនាញថែទាំសុខភាពដែលមានបទពិសោធន៍
                </p>
              </div>
              <div class="post_date">
                <div class="text-white txt-small me-auto">
                  ចុះផ្សាយថ្ងៃ៖ 12 មករា 2025
                </div>
                <div class="pe-5">
                  <span class="text-white pe-2 txt-small">
                    <i class="bi bi-eye"></i>
                    988
                  </span>
                  <div v-if="authStore.token">
                    <a
                      @click.stop.prevent="
                        article.is_save
                          ? articlestore.onRemoveArticle(article.id)
                          : articlestore.onSaveArticle(article.id)
                      "
                      role="button"
                      class="save"
                    >
                      <i
                        class=""
                        :class="
                          article.is_save
                            ? 'bi bi-bookmarks-fill text-color-warning'
                            : 'bi bi-bookmarks text-color-gray'
                        "
                      ></i>
                    </a>
                  </div>
                </div>
              </div>
            </RouterLink> -->
          </div>
          <div class="col-8">
            <a
              class="card article-normal cursor-pointer"
              v-if="articlestore.secondArticle"
              :key="articlestore.secondArticle.id"
              @click="articlestore.getArticle(articlestore.secondArticle.id)"
            >
              <div class="image">
                <img
                  :src="articlestore.secondArticle.thumbnail"
                  class="w-100 h-100 object-fit-cover"
                  alt=""
                />
              </div>
              <div class="card-body">
                <h5 class="mb-2 text-white article-title big limit-line-2">
                  {{ articlestore.secondArticle.title }}
                </h5>
                <p class="mb-0 text-color-gray text-white limit-line-1">
                  {{ articlestore.secondArticle.short_description }}
                </p>
              </div>
              <div class="post_date">
                <div class="text-white txt-small me-auto">
                  ចុះផ្សាយថ្ងៃ៖ {{ articlestore.secondArticle.updated_at }}
                </div>
                <div class="pe-5">
                  <span class="text-white pe-2 txt-small">
                    <i class="articlestore.secondArticle bi-eye"></i>
                    {{ articlestore.secondArticle.view }}
                  </span>
                  <!-- <a role="button" class="text-white icon-save">
                    <i class="bi bi-bookmarks"></i>
                  </a> -->
                  <!-- <a role="button" class="me-1 text-white">
						<i class="bi bi-bookmarks-fill text-color-warning"></i>
					</a> -->
                </div>
              </div>
            </a>
          </div>
          <div
            v-for="article in articlestore.article.slice(0, 4)"
            :key="article.id"
            class="col-3"
          >
            <a
              role="button"
              @click="articlestore.getArticle(article.id)"
              class="card article-normal smcard"
            >
              <div class="image">
                <!-- <img
					src="/src/assets/images/auth/homePage/heart-disease.jpg"
					class="w-100 h-100 object-fit-cover"
					alt=""
					/> -->
                <img
                  :src="article.thumbnail"
                  class="w-100 h-100 object-fit-cover"
                  alt=""
                />
              </div>
              <div class="card-body">
                <h5 class="mb-2 text-white article-title limit-line-2">
                  {{ article.title }}
                </h5>
                <p class="mb-0 text-color-gray text-white limit-line-2">
                  {{ article.short_description }}
                </p>
              </div>
              <div class="post_date">
                <div class="text-white txt-small me-auto">
                  ចុះផ្សាយថ្ងៃ៖ {{ article.updated_at }}
                </div>
                <div class="pe-5 d-flex">
                  <div
                    class="text-white d-flex align-items-center pe-0 txt-small"
                  >
                    <i class="bi bi-eye me-1"></i>
                    <div>{{ article.view }}</div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section class="news-know knowledge article my-0">
      <div class="container">
        <div class="category-article">
          <h4 class="sc-title-meduim text-color-900">ប្រភេទអត្ថបទនីមួយៗ</h4>
          <ul class="nav my-4">
            <li
              class="nav-item"
              v-for="cate in articlestore.cates"
              :key="cate.id"
            >
              <RouterLink
                to="/findarticle"
                @click="setCategory(cate.id)"
                class="nav-link d-flex align-items-center justify-content-center flex-column"
              >
                <div class="icon-wrapper overflow-hidden">
                  <img :src="getImageSrc(cate.id)" class="" alt="" />
                </div>
                <p class="mb-0 fw-medium">{{ cate.local_name }}</p>
              </RouterLink>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between mb-3">
          <h4 class="sc-title-meduim m-0 text-color-900">
            ចំណេះដឹងសុខភាពថ្មីៗ
          </h4>
          <RouterLink
            to="/findarticle"
            @click="articlestore.resetCategoryId()"
            class="text-decoration-none text-color-800 fw-medium see-more"
            >មើលទាំងអស់
            <span><i class="fa-regular fa-angle-right"></i></span>
          </RouterLink>
        </div>
        <div class="row g-3">
          <div class="col-6">
            <div class="image-wrapper border-radius">
              <img
                src="/src/assets/images/auth/homePage/heart-disease.jpg"
                class="img-fluid"
                alt=""
              />
            </div>
          </div>
          <div class="col-6">
            <span class="sc-title-tag box-shadow">ចំណេះដឹងថ្មីៗ</span>
            <h5 class="my-3">
              បង្កើនចំណេះដឹងផ្នែកសុខភាព ដើម្បីកែលម្អលទ្ធផលសុខភាព
            </h5>
            <p class="mb-0">
              អក្ខរកម្មសុខភាពគឺជាកម្រិតដែលបុគ្គលមានសមត្ថភាពទទួលបានដំណើរការនិងយល់អំពីព័ត៌មាននិងសេវាសុខភាពជាមូលដ្ឋានដែលត្រូវការដើម្បីធ្វើការសម្រេចចិត្តសមស្របការសិក្សាបានបង្ហាញថាអ្នកដែលមានជំនាញអក្ខរកម្មសុខភាពនៅមានកម្រិតទំនងជាមានជំងឺរ៉ាំរ៉ៃមិនសូវមានចំណេះដឹងអំពីជំងឺរបស់ពួកគេនិងមិនសូវមានលទ្ធភាពគ្រប់គ្រងជំងឺ...
              <RouterLink
                to="/findarticle"
                class="see-all fw-medium text-decoration-none text-color-800"
              >
                <span>មើលទាំងអស់</span>
              </RouterLink>
              <!-- <a
                href=""
                class="see-all fw-medium text-decoration-none text-color-800"
                @click="articlestore.resetCategoryId()"
              >
                <span class="">មើលទាំងអស់</span>
                <i class="fa-regular fa-chevron-right ms-1 txt-small"></i
              ></a> -->
            </p>
            <!-- <div class="d-flex mt-3">
              <RouterLink to="/doctorprofile" class="profile big">
                <img
                  src="/src/assets/images/auth/homePage/heart-disease.jpg"
                  class="w-100 h-100 object-fit-cover"
                  alt="..."
                />
              </RouterLink>
              <div class="ms-3">
                <RouterLink to="/doctorprofile" class="pf-name"
                  >John Smith
                </RouterLink>
                <p class="mb-0 txt-small text-color-text fw-medium">
                  ឯកទេសទូទៅ
                </p>
              </div>
            </div> -->
          </div>
          <div
            v-for="article in articlestore.article.slice(0, 4)"
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
                  {{ article.category ? article.category.local_name : "ទូទៅ" }}
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
                    <i class="bi bi-clock"></i>
                    {{ article.local_updated_at }}
                  </div>
                  <div class="text-color-gray d-flex align-items-center">
                    <i class="bi bi-eye me-1"></i>
                    <span class="fw-medium" style="font-size: 14px">
                      {{ article.view }}
                    </span>
                  </div>
                  <!-- <div v-if="authStore.token">
                    <a
                      @click.stop.prevent="
                        article.is_save
                          ? articlestore.onRemoveArticle(article.id)
                          : articlestore.onSaveArticle(article.id)
                      "
                      role="button"
                      class="save"
                    >
                      <i
                        class=""
                        :class="
                          article.is_save
                            ? 'bi bi-bookmarks-fill text-color-warning'
                            : 'bi bi-bookmarks text-color-gray'
                        "
                      ></i>
                    </a>
                  </div> -->
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>
    <section class="search-package">
      <div class="container">
        <div class="row row-bg g-0">
          <div class="col-8">
            <div class="content mt-2">
              <h4 class="sc-title-meduim text-color-900 text-white">
                ស្វែងរកកញ្ចប់ថែទាំសុខភាពដ៏ទូលំទូលាយរបស់យើង
              </h4>
              <p class="text-white mt-3 mb-4">
                កញ្ចប់នីមួយៗត្រូវបានបង្ហាញយ៉ាងច្បាស់លាស់និងសង្ខេបដែលធ្វើឱ្យវាងាយស្រួលសម្រាប់អ្នកក្នុងការយល់ដឹងលម្អិតនិងជ្រើសរើសមួយដែលស័ក្តិសមបំផុតនឹងតម្រូវការថែទាំសុខភាពរបស់អ្នក
              </p>
              <RouterLink to="/package" class="btn-bg-800"
                >ស្វែងយល់បន្ថែម</RouterLink
              >
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="learn-more">
      <div class="container">
        <div class="row">
          <div class="col-6">
            <div class="content">
              <h4 class="sc-title-meduim text-color-900">
                អត្ថបទសុខភាពទាំងអស់ត្រូវបានរៀបរាងដោយអ្នកជំនាញឯកទេសរបស់យើង
              </h4>
              <p class="mb-3">
                ក្រុមគ្រូពេទ្យជំនាញ និង​អ្នក​ត្រួតពិនិត្យ​មាតិការាល់ការចេញផ្សាយ
                សុទ្ធតែជា​ក្រុម​គ្រូពេទ្យ​ដែល​បញ្ចប់ការសិក្សាត្រឹមត្រូវ
                និង​ទទួល​ស្គាល់​ជាផ្លូវការ​ដោយ​ក្រសួងសុខាភិបាលឬស្ថាប័ន​ពាក់ព័ន្ធ​ផ្លូវការ
                ដើម្បីលើកស្ទួយ​សហគមន៍​របស់យើង​ដោយ​មាតិកា​ចេញផ្សាយជាបន្តបន្ទាប់សម្រាប់សាធារណជន
              </p>
              <RouterLink
                to="/finddoctor"
                class="text-decoration-none text-color-800 fw-medium see-more"
              >
                <span class="">ស្វែងយល់បន្ថែមអំពីអ្នកជំនាញឯកទេសរបស់យើង</span>
                <i class="fa-regular fa-chevron-right ms-1 txt-small"></i>
              </RouterLink>
            </div>
          </div>
          <div class="col-6">
            <div class="image-wrapper border-radius">
              <img
                src="./../../../assets/img/article_banner.png"
                class="img-fluid"
                alt=""
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
<script setup>
import { onBeforeRouteLeave } from "vue-router";
import { RouterLink } from "vue-router";
import { articleStore } from "@/stores/articalStore";
import { ref, onMounted, computed } from "vue";
import { watch } from "vue";
import { onBeforeRouteUpdate } from "vue-router";
import { debounce } from "lodash";
import { useAuthStore } from "@/stores/authTokenStore";
import { useRouter } from "vue-router";
import searchBar from "@/components/layouts/searchBar.vue";
import loadingView from "@/views/loading/loadingView.vue";
const articlestore = articleStore();
const authStore = useAuthStore();
const showSearch = ref(false);
const firstArticle = ref(null);
const secondArticle = ref(null);
onMounted(async () => {
  await articlestore.getCate();
  await articlestore.fetchAllFunctions();
  await articlestore.onloadArticle();
  await articlestore.onloadArticle2();
  // firstArticle.value = await articlestore.onloadArticleByID(4);
  // secondArticle.value = await articlestore.onloadArticleByID(5);
  // const savedCategory = sessionStorage.getItem("selectedCategory");
  // if (savedCategory) {
  //   articlestore.filter.category_id = savedCategory;
  //   await articlestore.paginateArticle();
  // }
});
const images = import.meta.glob("@/assets/images/typeofArticle/*.png", {
  eager: true,
});
import defaultImage from "@/assets/images/default_cate.png";

// Create a mapping of image IDs to their module objects
const imageMap = new Map();
Object.keys(images).forEach((path) => {
  const match = path.match(/\/0?(\d+)\.png$/);
  if (match) {
    const id = parseInt(match[1], 10);
    imageMap.set(id, images[path]); // Store the module object
  }
});

const getImageSrc = (id) => {
  if (imageMap.has(id)) {
    // Return the default property, stripping /src for production
    return imageMap.get(id).default.replace(/^\/src/, "");
  }
  return defaultImage; // Fallback to defaultImage
};
onBeforeRouteLeave((to, from, next) => {
  articlestore.dataFetched = false;
  next();
});

if (!articlestore.loading) {
  window.scrollTo({ top: 0, behavior: "smooth" });
}

const hideSearch = () => {
  showSearch.value = false;
};
const isSelectOpen = ref(false);

const expanded = ref(false);
const toggleDescription = () => {
  expanded.value = !expanded.value;
};
onBeforeRouteUpdate(async (to, from, next) => {
  if (to.params.id !== from.params.id) {
    await articlestore.fetchArticleById(to.params.id);
  }
  next();
});
const setCategory = (categoryId) => {
  articlestore.typeofCategory = categoryId;
  sessionStorage.setItem("selectedCategory", categoryId);
  articlestore.paginateArticle();
};

// const debouncedSearch = debounce(() => {
//   articlestore.getInput();
// }, 300);

// watch(() => articlestore.inputsearch, () => {
//   debouncedSearch();
// });

// const onClickToDetail = (articleId) => {
//   showSearch.value = false;
//   router.push(`/article_detail/${articleId}`);
// };
const router = useRouter();
const onSearchSubmit = () => {
  router.push({
    name: "findArticle",
    query: {
      search: articlestore.inputsearch,
      category_id: articlestore.filter.category_id || "",
    },
  });
};
</script>
