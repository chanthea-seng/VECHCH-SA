<template>
  <main class="ariticle-detailpage">
    <loadingView v-if="articlestore.loading" />
    <section class="detail-top">
      <div class="container">
        <div class="row">
          <div class="col-10 mx-auto">
            <div
              class="content"
              v-for="art in articlestore.articaleDetails"
              :key="art.id"
            >
              <div class="d-flex justify-content-between">
                <span class="sc-title-tag box-shadow">
                  {{ art.category ? art.category.local_name : "ទូទៅ" }}
                </span>
                <div v-if="authStore.token">
                  <a
                    @click.stop.prevent="
                      art.is_save
                        ? articlestore.onRemoveArticle(art.id)
                        : articlestore.onSaveArticle(art.id)
                    "
                    role="button"
                    class="save"
                  >
                    <i
                      class="fs-4"
                      :class="
                        art.is_save
                          ? 'bi bi-bookmarks-fill text-color-warning'
                          : 'bi bi-bookmarks text-color-gray'
                      "
                    ></i>
                  </a>
                </div>
              </div>
              <div class="my-2">
                <h4 class="sc-title-meduim text-color-900 mb-0 text-white w-75">
                  {{ art.title }}
                </h4>
                <p class="p-0 m-0 mt-1">
                  {{ art.short_description }}
                </p>
              </div>
              <div class="d-flex align-items-center">
                <i class="bi bi-clock-history me-2 fs-5"></i>
                <p class="mb-0 text-color-text fw-medium txt-small">
                  ចុះផ្សាយនៅថ្ងៃ៖ {{ art.local_updated_at }}
                </p>
              </div>
              <div class="d-flex column-gap-3">
                <div
                  class="section-title-tag mb-3"
                  v-for="tag in art.tags"
                  :key="tag.id"
                >
                  {{ tag.local_name }}
                </div>
              </div>
              <div class="col-12 position-relative">
                <img
                  :src="art.thumbnail"
                  class="thumbnail-img"
                  alt="thumbnail"
                />
                <img
                  src="./../../../assets/images/layout_logo/Vcs.png"
                  class="logo-icon"
                  alt=""
                />
              </div>
              <div v-html="art.content" class="mb-3 content-control"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="author mb-5">
      <div class="container">
        <div class="row">
          <div class="col-10 mx-auto">
            <h5 class="text-color-950">រៀបរៀងដោយ៖</h5>
            <div
              class="doctor-pf position-relative p-4 my-4 w-100"
              v-for="art in articlestore.articaleDetails"
              :key="art.id"
            >
              <div class="d-flex position-relative z-3 align-items-center">
                <div class="profile box-shadow border-d">
                  <img
                    :src="art.doctor.avatar"
                    class="w-100 object-fit-cover h-100"
                    alt=""
                  />
                </div>
                <div class="ms-3">
                  <h5 class="text-color-800 fw-semibold mb-2">
                    វេជ្ជបណ្ឌិត
                    {{ art.doctor.local_fullname }}
                  </h5>
                  <span class="fw-medium text-color-text">
                    <!-- {{ art.doctor.local_fullname }} -->
                  </span>
                </div>
              </div>
              <div class="d-flex position-relative z-3 align-items-center">
                <a
                  role="button"
                  class="btn-bg-800 px-4 me-2"
                  @click="finddcotorstore.onClickToBooking(art.doctor.id)"
                  ><i class="bi bi-calendar4-event"></i> កំណត់ពេលជួប</a
                >
                <a
                  role="button"
                  class="btn-bg-800 px-4"
                  @click="finddcotorstore.onClickToDetail(art.doctor.id)"
                  ><i class="bi bi-info-circle"></i> មើលប្រវត្តិរូប</a
                >
              </div>
            </div>
            <div class="contact w-75">
              <h5 class="mt-4 mb-3">សម្រាប់ព័ត៌បន្ថែម៖</h5>
              <ul class="nav">
                <li
                  class="nav-item mb-2 ts-text text-color-text me-5 fw-medium"
                >
                  <i class="bi bi-telephone-inbound fs-5 me-2"></i> +855
                  987654321 (សង្គ្រោះបន្ទាន់)
                </li>
                <li class="nav-item ts-text text-color-text fw-medium me-5">
                  <i class="bi bi-envelope fs-5 me-2"></i>
                  vechchsal@gmail.com
                </li>
                <li class="nav-item ts-text fw-medium text-color-text">
                  <i class="bi bi-telephone-inbound fs-5 me-2"></i> +855
                  987654321
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="relate pt-0 mt-0 knowledge article">
      <div class="container">
        <div class="row g-3">
          <div class="d-flex justify-content-between">
            <h4 class="mb-0">ចំណេះដឹងផ្សេងៗទាក់ទងនឹងប្រធាន៖</h4>
            <div class="navigation-swiper d-flex align-items-center gap-3">
              <button
                class="custom-prev-btn d-flex align-items-center p-0 border-0 bg-transparent"
              >
                <i class="fa-regular fa-arrow-left fs-5 text-color-950"></i>
              </button>
              <button
                class="custom-next-btn d-flex align-items-center p-0 border-0 bg-transparent"
              >
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
                  v-for="article in articlestore.article"
                  :key="article.id"
                >
                  <div class="col-12 h-100">
                    <a
                      role="button"
                      @click="selectArticle(article.id)"
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
  </main>
</template>

<script setup>
import { articleStore } from "@/stores/articalStore";
import { Swiper, SwiperSlide } from "swiper/vue";
import { onMounted, watch } from "vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Navigation } from "swiper/modules";
import { historySearch } from "@/stores/finddcotorstore";
import { useAuthStore } from "@/stores/authTokenStore";
import loadingView from "@/views/loading/loadingView.vue";
const finddcotorstore = historySearch();
const authStore = useAuthStore();
const articlestore = articleStore();
const onSavearticle = (id) => {
  let index = articlestore.article.findIndex((item) => item.id == id);
  articlestore.article[index].is_save = true;
};
const onResetSavearticle = (id) => {
  let index = articlestore.article.findIndex((item) => item.id == id);
  articlestore.article[index].is_save = false;
};
// watch(
//   () => articleStore.selectId,
//   (newVal) => {
//     if (newVal) {
//       articlestore.loading = true; // Set loading to true while fetching
//       articlestore.getArticleDetail();
//     }
//   },
//   { immediate: true } // Immediately trigger when the component is mounted if selectId already has a value
// );
onMounted(async () => {
  window.scrollTo({ top: 0, behavior: "smooth" });

  authStore.loadToken();
  articlestore.fetchAllFunctions();
  articlestore.onloadArticle();
  await articlestore.getArticleDetail();
  await articlestore.onClickView();
});
const selectArticle = async (id) => {
  articlestore.setSelectId(id);
  window.scrollTo({ top: 0, behavior: "smooth" });
};
const onClickBookDoctor = (id) => {
  alert(id);
};
watch(
  () => articlestore.selectId,
  async (newVal) => {
    if (newVal) {
      articlestore.loading = true;
      articlestore.articaleDetails = [];
      await articlestore.getArticleDetail();
    }
  },
  { immediate: true }
);
</script>
