<template>
  <loadingView v-if="pageLoading" />
  <div class="finddisease">
    <section class="hero position-relative mt-0 pb-5">
      <div class="w-100 d-flex justify-content-between">
        <div class="wrapper-img" style="margin-top: 70px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/auth/homePage/Untitled-1 1.png"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/1.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/2.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img" style="margin-top: 60px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/6.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img other" style="margin-top: 10px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/4.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img" style="margin-top: 20px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/5.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img other" style="margin-top: -0px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/3.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img" style="margin-top: 50px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/7.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img" style="margin-top: 20px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/8.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/9.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
        <div class="wrapper-img" style="margin-top: 80px">
          <div class="item-img gredient"></div>
          <div class="item-img">
            <img
              src="/src/assets/images/finddisease/10.jpg"
              class="mb-3"
              style="height: 185px"
              alt=""
            />
          </div>
        </div>
      </div>
      <div class="content">
        <div class="section-title-tag mb-1" style="padding: 4px 20px">
          ចំណេះដឹង
        </div>
        <h3 style="color: #004559; line-height: 40px">
          រាល់ចំណេះដឹងអំពីជំងឺត្រូវបានសរសេរដោយ វេជ្ជបណ្ឌិតដ៏ឆ្នើមរបស់យើង
        </h3>
        <p class="text-color-text mb-0">
          រាល់ពាក្យសម្ដីត្រូវបានបង្កើតឡើងដោយអ្នកជំនាញដើម្បីចែករំលែកចំណេះដឹងជាមូលដ្ឋានទាំងអស់អំពីសុខភាពដល់អ្នកជំងឺ
        </p>
      </div>
    </section>
    <section class="article-disease" style="margin: 0 !important">
      <div class="container position-relative">
        <div class="col-6 m-auto position-absolute cus-search">
          <div class="">
            <div class="search-container d-flex align-items-center">
              <div class="select-wrapper col-3">
                <select
                  name="cate"
                  id="cate"
                  class="form-select form-select-global"
                  placeholder="ជ្រើសរើសប្រភេទ"
                  @focus="isSelectOpen = true"
                  @blur="isSelectOpen = false"
                  v-model="findDisease.filter.category_id"
                  @change="findDisease.getInput()"
                >
                  <option
                    v-for="cate in findDisease.cates"
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
                placeholder="ស្វែងរកជំងឺតាមឈ្មោះជំងឺ និងរោគសញ្ញា"
                aria-label="Search"
                @focus="showSearch = true"
                @blur="hideSearch"
                v-model="findDisease.inputsearch"
                @input="findDisease.getInput()"
              />
              <span class="search-icon position-absolute">
                <i class="fa-regular fa-magnifying-glass"></i>
              </span>
            </div>
          </div>
        </div>
        <h5 class="text-color-gray fw-medium mb-4" style="font-size: 18px">
          ការបញ្ចូលអ្នកប្រើប្រាស់:
        </h5>
        <div class="row g-4">
          <div
            v-for="disease in findDisease.cardFrm"
            :key="disease.id"
            class="col-3"
          >
            <a
              @click="store.getArticle(disease.id)"
              style="cursor: pointer"
              class="card text-decoration-none border-0 box-shadow overflow-hidden"
            >
              <div class="card-top p-1 d-flex justify-content-end flex-column">
                <div class="ms-auto d-flex gap-1">
                  <div class="ractangle"></div>
                  <div class="ractangle"></div>
                  <div class="ractangle"></div>
                </div>
                <div class="mt-2 wrapper ms-auto d-flex gap-1">
                  <div class="ractangle reverse"></div>
                  <div class="ractangle reverse"></div>
                  <div class="ractangle reverse"></div>
                </div>
              </div>
              <div
                class="card-body pt-2 d-flex flex-column align-items-start justify-content-between"
              >
                <div>
                  <h6 class="limit-line-1 mb-0 text-color-950 fw-semibold">
                    {{ disease.title }}
                  </h6>
                  <p
                    class="limit-line-2 mb-2 pt-3 position-relative"
                    style="font-size: 15px"
                  >
                    {{ disease.short_description }}
                  </p>
                </div>
                <div class="text-end w-100">
                  <span
                    class="text-end text-decoration-none text-color-700 read-more"
                  >
                    អានបន្ថែម <i class="bi bi-arrow-up-right"></i
                  ></span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-12 my-auto" :class="{ 'd-none': totalPage == 1 }">
            <div class="mt-5 mb-0">
              <nav aria-label="Page">
                <ul class="pagination page_component">
                  <li
                    class="page-item"
                    :class="{ unactive: cardFrmCurrentPage === 1 }"
                  >
                    <a
                      class="page-link prev icon"
                      href="#"
                      aria-label="Previous"
                      @click.prevent="changePage(cardFrmCurrentPage - 1)"
                    >
                      <i class="fa-solid fa-chevron-left"></i>
                    </a>
                  </li>
                  <!-- ========================== -->
                  <li
                    v-for="page in pages"
                    :key="page"
                    class="page-item"
                    :class="{
                      ' active': page === cardFrmCurrentPage,
                      unactive: page === '...',
                    }"
                  >
                    <a
                      v-if="loadingPagination === page"
                      class="page-link"
                      :class="{
                        ' loading': findDisease.paginationLoading == true,
                      }"
                      @click.prevent="changePage(page)"
                    >
                      <div class="loader"></div>
                    </a>
                    <a
                      v-else
                      class="page-link"
                      @click.prevent="changePage(page)"
                    >
                      {{ page }}
                    </a>
                  </li>
                  <!-- ========================== -->
                  <li
                    class="page-item"
                    :class="{ unactive: cardFrmCurrentPage === totalPage }"
                  >
                    <a
                      class="page-link next icon"
                      href="#"
                      aria-label="Next"
                      @click.prevent="changePage(currentPage + 1)"
                    >
                      <i class="fa-solid fa-chevron-right"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="search pb-0 mb-0 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="wrapper d-flex align-items-center ps-5">
              <div class="col-6">
                <div class="d-flex">
                  <div class="position-relative z-3">
                    <h3 class="title">ស្វែងរកតាមអក្ខរក្រម</h3>
                    <span
                      class="fw-medium"
                      style="color: #4c5e63; font-size: 15px"
                      >អ្នកអាចជ្រើសរើសអក្ខរក្រមដើម្បីស្វែងរក</span
                    >
                  </div>
                  <div
                    class="ibook ms-3 position-relative z-3 d-flex align-items-center justify-content-center"
                  >
                    <img
                      src="/src/assets/images/auth/icon/Frame 203.png"
                      width="50px"
                      class="img-fluid"
                      alt=""
                    />
                  </div>
                </div>
                <div class="position-relative z-3">
                  <input
                    v-for="letter in 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')"
                    :key="letter"
                    type="radio"
                    v-model="icharsearch"
                    class="isearch d-none"
                    :value="letter"
                    :id="letter"
                    @change="handleLetterChange(letter)"
                  />
                  <label
                    v-for="letter in 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')"
                    :key="'label-' + letter"
                    :for="letter"
                    class="isearch"
                    :class="{ active: icharsearch === letter }"
                  >
                    {{ letter }}
                  </label>
                </div>
                <div class="img-doctor position-absolute z-3 pb-5">
                  <img
                    src="/src/assets/images/auth/homePage/Untitled-1 1.png"
                    width="270px"
                    alt=""
                  />
                  <div class="icon-medicine position-absolute z-3">
                    <img
                      src="/src/assets/images/auth/icon/iconMedicine.png"
                      width="38px"
                      alt=""
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="result_search mt-5 py-0">
      <div class="container">
        <h3 class="text-color-900 text-center mb-4">
          ការស្វែងរកអក្ខរក្រម <i class="bi bi-search fs-4"></i>
        </h3>
        <div class="row g-4">
          <div
            v-for="disease in findDisease.cardByAlphabet"
            :key="disease.id"
            class="col-4"
          >
            <a
              @click="store.getArticle(disease.id)"
              class="item cursor-pointer text-decoration-none d-flex align-items-center overflow-hidden position-relative box-shadow bg-white p-3 border-radius"
            >
              <div class="charsearch mx-2 col-1">
                <span>{{ findDisease.alphabet }}</span>
              </div>
              <p
                class="mb-0 ms-2 limit-line-1 me-auto fw-medium text-color-text"
                style="width: 155px"
              >
                {{ disease.title }}
              </p>
              <span
                class="mb-0 text-color-800 fw-medium limit-line-1"
                style="font-size: 15px; width: 135px"
                >ប្រភេទ៖ {{ disease.category.local_name }}</span
              >
            </a>
          </div>
        </div>
      </div>
    </section>
    <section
      class="knowledge health pt-5 pb-5 article mb-0"
      style="background-color: #f7f7f7"
    >
      <div class="container">
        <div class="row">
          <div
            class="sec-title mb-3 align-items-end d-flex justify-content-between"
          >
            <div>
              <span class="section-title-tag" style="padding: 6px 20px"
                >ចំណេះដឹងសុខភាព</span
              >
              <h4 class="sc-title mt-3 mb-0 pb-0">
                ស្វែងយល់បន្ថែមអំពីចំណេះថែទាំសុខភាព
              </h4>
            </div>

            <div class="navigation-swiper d-flex align-items-center gap-3">
              <button class="custom-prev-btn p-0 border-0 bg-transparent">
                <i class="fa-regular fa-arrow-left fs-5 text-color-950"></i>
              </button>
              <button class="custom-next-btn p-0 border-0 bg-transparent">
                <i class="fa-regular fa-arrow-right fs-5 text-color-950"></i>
              </button>
            </div>
          </div>
          <div class="col-12">
            <div class="wrapper d-flex justify-content-between">
              <swiper
                :spaceBetween="24"
                :loop="true"
                :centeredSlides="false"
                :pagination="{
                  clickable: true,
                }"
                :navigation="{
                  prevEl: '.custom-prev-btn',
                  nextEl: '.custom-next-btn',
                }"
                :modules="[Navigation]"
                :breakpoints="{
                  640: { slidesPerView: 1 },
                  768: { slidesPerView: 2 },
                  1024: { slidesPerView: 3 },
                  1024: { slidesPerView: 4 },
                }"
                class="mySwiper"
              >
                <swiper-slide
                  v-for="article in store.article"
                  :key="article.id"
                >
                  <div class="col-12 h-100">
                    <a
                      role="button"
                      @click="store.getArticle(article.id)"
                      class="card border-0 news box-shadow text-decoration-none overflow-hidden h-100"
                    >
                      <div
                        class="img rounded-3 overflow-hidden position-relative"
                      >
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
                          <h5 class="mb-0 pb-0 limit-line-2">
                            {{ article.title }} 
                          </h5>

                          <p
                            class="my-2 text-color-gray limit-line-2"
                            style="font-size: 15px"
                          >
                            {{ article.short_description }}
                          </p>
                        </div>

                        <div
                          class="d-flex align-items-center justify-content-between"
                        >
                          <div
                            class="txt-small text-color-text fw-medium"
                            style="font-size: 14px"
                          >
                            <i class="bi bi-clock"></i> 25 មករា​ 2025
                          </div>
                          <div
                            class="text-color-gray d-flex align-items-center justify-content-end"
                          >
                            <i class="bi bi-eye me-1"></i>
                            <span class="fw-medium" style="font-size: 14px">{{
                              article.view
                            }}</span>
                            <!-- <div v-if="authStore.token">
                              <a
                                @click.stop.prevent="
                                  article.is_save
                                    ? store.onRemoveArticle(article.id)
                                    : store.onSaveArticle(article.id)
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
                      </div>
                    </a>
                  </div>
                </swiper-slide>
              </swiper>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import loadingView from "@/views/loading/loadingView.vue";
import { articleStore } from "@/stores/articalStore";
import { findDiseaseStore } from "@/stores/findDiseaseStore";
import {
  reactive,
  ref,
  onMounted,
  computed,
  onBeforeUnmount,
  watch,
} from "vue";
import { Navigation } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

const showSearch = ref(false);
const isSelectOpen = ref(false);
const store = articleStore();
const findDisease = findDiseaseStore();
const hideSearch = () => {
  showSearch.value = false;
};
const cardFrmCurrentPage = computed(() => findDisease.cardFrmCurrentPage);
const totalPage = computed(() => findDisease.cardFrmTotalPage);
const pages = ref([]);
const loadingPagination = ref(null);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    window.scrollTo({ top: 0, behavior: "smooth" });
    await findDisease.fetchAllData();
    await findDisease.getCate();
    await store.onloadArticle();
    await findDisease.onloadArticle(cardFrmCurrentPage.value);
    await findDisease.onLoadArticleAlphabet(icharsearch.value);
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
onBeforeUnmount(() => {
  sessionStorage.removeItem("cardFrmCurrentPage");
  findDisease.onloadArticle(1);
});
const generatePagination = () => {
  let pagination = [];
  if (cardFrmCurrentPage.value <= 4) {
    pagination = Array.from({ length: totalPage.value }, (_, i) => i + 1);
  } else {
    if (cardFrmCurrentPage.value < 4) {
      pagination = [1, 2, 3, 4, "...", totalPage.value];
    } else if (cardFrmCurrentPage.value > totalPage.value - 3) {
      pagination = [
        1,
        "...",
        totalPage.value - 3,
        totalPage.value - 2,
        totalPage.value - 1,
        totalPage.value,
      ];
    } else {
      pagination = [
        1,
        "...",
        cardFrmCurrentPage.value - 1,
        cardFrmCurrentPage.value,
        cardFrmCurrentPage.value + 1,
        "...",
        totalPage.value,
      ];
    }
  }
  pages.value = pagination;
};
watch(
  [totalPage, cardFrmCurrentPage],
  () => {
    generatePagination();
  },
  { immediate: true }
);

watch(
  () => findDisease.cates,
  (newCate) => {
    if (newCate.length) {
      findDisease.filter.category_id = newCate[0]?.id || null;
    }
  },
  { immediate: true }
);

const changePage = (p) => {
  if (p === "..." || p < 1 || p > totalPage.value) return;
  loadingPagination.value = p;
  findDisease.onloadArticle(p).finally(() => {
    loadingPagination.value = null;
    // window.scrollTo({top: 0, behavior: 'smooth'});
  });
  generatePagination();
};
const icharsearch = ref("A");
const handleLetterChange = (letter) => {
  icharsearch.value = letter;
  findDisease.onLoadArticleAlphabet(letter);
};

const onSavearticle = (id) => {
  let index = store.article.findIndex((item) => item.id == id);
  store.article[index].is_save = true;
};
const onResetSavearticle = (id) => {
  let index = store.article.findIndex((item) => item.id == id);
  store.article[index].is_save = false;
};
</script>
