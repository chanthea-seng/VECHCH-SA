<template>
  <main class="package-page save">
    <section class="">
      <loadingView v-if="packagestore.loading" />
      <div class="container">
        <div class="row">
          <!-- =============================================== -->
          <div
            class="col-12 m-auto p-0 row g-0 align-items-center sec-title text-center flex-column my-4"
          >
            <h3 class="text-color-800 mb-2">
              អត្ថបទចំណេះដឹងសុខភាពសម្រាប់ការរស់នៅក្នុងជីវិត
            </h3>
            <span
              class="small-description"
              style="font-size: 14px; font-weight: 450"
              >យើងផ្តល់ព័ត៌មានច្បាស់លាស់ ដែលអាចអនុវត្តបានអំពីសុខភាព សុខុមាលភាព
              និងរបៀបរស់នៅ ជួយអ្នកឱ្យទទួលបានព័ត៌មាន
              និងទទួលខុសត្រូវចំពោះសុខុមាលភាពរបស់អ្នក</span
            >
            <div class="col position-relative">
              <form
                @submit.prevent=""
                class="search-container d-flex align-items-center w-50 justify-content-center m-auto my-3"
              >
                <input
                  type="text"
                  class="form-control bg-transparent"
                  placeholder="ស្វែងរកកញ្ចប់សេវាកម្មសុខភាព"
                  aria-label="Search"
                  @input="onSearchInput"
                  @focus="showSearch = true"
                  @blur="hideSearchHistory"
                  v-model="packagestore.inputsearch"
                />
                <span class="search-icon position-absolute">
                  <i class="fa-regular fa-magnifying-glass"></i>
                </span>
              </form>
              <!-- <div class="card card-search position-absolute z-3 h-auto d-flex align-items-center justify-content-center m-auto" v-if="true" @mousedown.prevent> -->
              <div
                class="card card-search position-absolute z-3 mt-1"
                v-if="showSearch && packagestore.inputService.length"
                @mousedown.prevent
              >
                <ul class="list-group">
                  <li
                    class="list-group-item"
                    v-for="data in packagestore.inputService.slice(0, 6)"
                    :key="data.id"
                  >
                    <a
                      role="button"
                      class="d-flex justify-content-between align-items-center text-decoration-none text-color-950"
                      @click="packagestore.onClickDetail(data.id)"
                    >
                      <span>{{ data.name }}</span>
                      <div class="dot"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- =============================================== -->
          <h4 class="text-color-950 mb-3">កញ្ចប់សេវាកម្មសុខភាព</h4>
          <div class="col-12 d-flex">
            <div class="group-radio mb-3">
              <div class="">
                <input
                  type="radio"
                  name="service"
                  class="d-none"
                  id="general"
                  value=""
                  v-model="packagestore.filter.service_type"
                  @change="loadingserviceType = 'general'"
                />
                <label for="general">
                  <div
                    v-if="loadingserviceType === 'general'"
                    class="loader"
                  ></div>
                  <div v-else class=""></div>
                  ទូទៅ
                </label>
              </div>
              <div>
                <input
                  type="radio"
                  name="service"
                  class="d-none"
                  id="package"
                  v-model="packagestore.filter.service_type"
                  value="1"
                  @change="loadingserviceType = 'package'"
                />
                <label for="package">
                  <div
                    v-if="loadingserviceType === 'package'"
                    class="loader"
                  ></div>
                  <div v-else class=""></div>
                  កញ្ចប់ពិនិត្យសុខភាព
                </label>
              </div>
              <div>
                <input
                  type="radio"
                  name="service"
                  class="d-none"
                  id="vaccine"
                  v-model="packagestore.filter.service_type"
                  value="2"
                  @change="loadingserviceType = 'vaccine'"
                />
                <label for="vaccine">
                  <div
                    v-if="loadingserviceType === 'vaccine'"
                    class="loader"
                  ></div>
                  <div v-else class=""></div>
                  កញ្ចប់វ៉ាក់សាំង
                </label>
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="row g-4">
              <div
                v-for="service in packagestore.services"
                :key="service.id"
                class="col-12"
              >
                <div
                  class="card border-radius bg-white d-flex flex-row overflow-hidden p-2 border-0 box-shadow"
                >
                  <div class="image border-radius overflow-hidden col-5">
                    <img :src="service.thumbnail" alt="" />
                  </div>
                  <div class="card-body">
                    <h5 class="limit-line-1 text-color-950">
                      {{ service.local_name }}
                    </h5>
                    <p class="limit-line-3">{{ service.local_description }}</p>
                    <div class="d-flex align-items-center">
                      <a
                        role="button"
                        @click="packagestore.onClickDetail(service.id)"
                        class="btn-bg-650 px-4"
                      >
                        <span> ព័ត៌មានបន្ថែម </span>
                      </a>
                      <i
                        class="bi ms-4 me-1 bi-bag-plus text-color-800 fs-5"
                      ></i>
                      <span
                        class="d-block fw-medium text-color-800"
                        style="font-size: 14px"
                      >
                        {{ service.sub_services_count }}
                        ប្រភេទ
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="my-5 col-12" :class="{ 'd-none': totalPage == 1 }">
                <nav aria-label="Page">
                  <ul
                    class="pagination page_component"
                    :class="{ unactive: currentPage === 1 }"
                  >
                    <li
                      class="page-item"
                      :class="{ unactive: currentPage === 1 }"
                    >
                      <a
                        class="page-link prev icon"
                        href="#"
                        aria-label="Previous"
                        @click.prevent="changePage(currentPage - 1)"
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
                        active: page === currentPage,
                        unactive: page === '...',
                      }"
                    >
                      <a
                        v-if="loadingPagination === page"
                        class="page-link"
                        :class="{
                          loading: packagestore.paginationLoading == true,
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
                      :class="{
                        'page-item unactive': currentPage === totalPage,
                      }"
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
          <div class="col-4">
            <div class="position-sticky top-0">
              <div
                class="advertise p-4 border-radius d-flex justify-content-between flex-column"
              >
                <div>
                  <h5 class="mb-3 fw-medium">
                    ជួបជាមួយវេជ្ជបណ្ឌិត និងអ្នកឯកទេសកំពូលៗ
                  </h5>
                  <p class="">
                    កុំរង់ចាំឱ្យរោគសញ្ញាកាន់តែអាក្រក់ទៅៗសូមធ្វើការចាប់ផ្ដើមពិគ្រោះជាមួយវេជ្ជបណ្ឌិតដែលមានបទពិសោធន៍របស់យើងនៅថ្ងៃនេះ
                    ដើម្បីសុខភាពរបស់លោកអ្នកនៅថ្ងៃអនាគត
                  </p>
                </div>
                <div>
                  <a @click="onClickCheck()" class="btn-bg-800 px-3"
                    >កក់ពិគ្រោះឥឡូវនេះ</a
                  >
                </div>
              </div>
              <div
                class="mt-4 contact bg-white p-3 border-radius d-flex flex-column"
              >
                <h5 class="mb-3 fw-medium text-color-1100">
                  សម្រាប់ព័ត៌មានបន្ថែម សូមទំនាក់ទំនង៖
                </h5>
                <span
                  ><i class="bi bi-telephone-inbound me-2"></i> +855 987654321
                  (សង្គ្រោះបន្ទាន់)</span
                >
                <span
                  ><i class="bi bi-telephone-inbound me-2"></i> +855 987654321
                </span>
                <span
                  ><i class="bi bi-envelope me-2"></i> vechesal@gmail.com</span
                >
                <span
                  ><i class="bi bi-geo-alt me-2"></i> 54 St 606, Phnom
                  Penh</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script setup>
import loadingView from "@/views/loading/loadingView.vue";
import { pagekageStore } from "@/stores/packagestore";
import { onMounted, ref, computed, watch, onBeforeUnmount } from "vue";
import { debounce } from "lodash";
import router from "@/router";
import { useAuthStore } from "@/stores/authTokenStore";
const packagestore = pagekageStore();
const totalPage = computed(() => packagestore.totalPage);
const currentPage = computed(() => packagestore.currentPage);
const pages = ref([]);
const loadingPagination = ref(null);
const loadingserviceType = ref(null);
const onClickBooking = () => {
  // check token
  //   router.push("/");
};
const showSearch = ref(false);
const hideSearchHistory = () => {
  showSearch.value = false;
};

const onClickCheck = () => {
  const authStore = useAuthStore();
  authStore.loadToken();
  if (!authStore.token) {
    router.push("/login");
    return;
  }
  router.push("/book-appointment");
};
onMounted(() => {
  window.scrollTo({ top: 0, behavior: "smooth" });

  packagestore.filter.service_type = "";
  packagestore.getService(currentPage.value);
  packagestore.getInput();
});
onBeforeUnmount(() => {
  sessionStorage.removeItem("currentPage");
  sessionStorage.removeItem("serviceType");
});
const generatePagination = () => {
  let pagination = [];
  if (totalPage.value <= 4) {
    pagination = Array.from({ length: totalPage.value }, (_, i) => i + 1);
  } else {
    if (currentPage.value < 4) {
      pagination = [1, 2, 3, 4, "...", totalPage.value];
    } else if (currentPage.value > totalPage.value - 3) {
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
        currentPage.value - 1,
        currentPage.value,
        currentPage.value + 1,
        "...",
        totalPage.value,
      ];
    }
  }
  pages.value = pagination;
};

watch(
  [totalPage, currentPage],
  () => {
    generatePagination();
  },
  { immediate: true }
);

watch(
  () => packagestore.filter.service_type,
  async () => {
    loadingserviceType.value = true;
    await packagestore.getService(1, packagestore.filter.service_type, true);
    loadingserviceType.value = false;
  }
);

const changePage = (p) => {
  if ((p == "..." || p > totalPage.value, p < 1)) return;
  loadingPagination.value = p;
  packagestore.getService(p).finally(() => {
    loadingPagination.value = null;
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
  generatePagination();
};

const onSearchInput = debounce(async () => {
  showSearch.value = true;
  if (packagestore.inputsearch.trim() !== "") {
    await packagestore.getInput();
    // console.log('data',packagestore.inputService)
    // console.log(packagestore.inputsearch)
    // console.log(packagestore.getInput())
  } else {
    packagestore.inputService = [];
  }
}, 500);
const onSearchSubmit = async () => {
  hideSearchHistory();
  packagestore.currentPage = 1;
  sessionStorage.setItem("currentPage", 1);
  packagestore.loading = true;
  await packagestore.paginateArticle(1, packagestore.inputsearch);
};
</script>
