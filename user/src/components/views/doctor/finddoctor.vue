<template>
  <main>
    <loadingView v-if="pageLoading" />
    <loadingView v-if="useDoctorStore.loading" />

    <section class="find-doctor">
      <div class="container">
        <div class="row g-3 list-doctor">
          <div class="col-12 py-5 d-flex flex-wrap justify-content-center">
            <div class="col-12 sec-title text-center">
              <h3 class="text-color-800 mb-4">ស្វែងរកវេជ្ជបណ្ឌិត</h3>
            </div>
            <div class="col-6 position-relative">
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
                    v-model="useDoctorStore.filter.specialist"
                    @change="useDoctorStore.getDoctor()"
                  >
                    <option value="" selected>ជ្រើសរើសឯកទេស</option>
                    <option
                      v-for="item in useDoctorStore.specialists"
                      :key="item.id"
                      :value="item.id"
                    >
                      {{ item.local_name }}
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
                  placeholder="ស្វែងរកឈ្មោះវេជ្ជបណ្ឌិត"
                  aria-label="Search"
                  @focus="showSearch = true"
                  @blur="hideSearch"
                  v-model="useDoctorStore.filter.inputSearch"
                  @input="useDoctorStore.getInput()"
                />
                <span class="search-icon position-absolute">
                  <i class="fa-regular fa-magnifying-glass"></i>
                </span>
              </form>
              <div
                class="card card-search position-absolute z-3"
                v-if="showSearch && useDoctorStore.inputDoctor.length"
                @mousedown.prevent
              >
                <ul class="list-group">
                  <li
                    class="list-group-item"
                    v-for="data in useDoctorStore.inputDoctor"
                    :key="data.id"
                  >
                    <a
                      role="button"
                      class="d-flex justify-content-between align-items-center text-decoration-none text-color-950"
                      @click="useDoctorStore.onClickToDetail(data.id)"
                    >
                      <span>{{ data.user.local_fullname }}</span>
                      <div class="dot"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div
            class="col-3 ps-0 pe-3"
            v-for="doctor in useDoctorStore.doctors"
            :key="doctor.id"
          >
            <div class="card">
              <div class="card-body p-4 mt-3 text-center">
                <div class="card-image m-auto mb-3">
                  <img :src="doctor.user.avatar" alt="" />
                </div>
                <div class="sec-title">
                  <h5 class="text-color-900 mb-4">
                    {{ doctor.user.local_fullname }}
                  </h5>
                  <span class="doc-spicalize">
                    {{ doctor.specialist.local_name }}
                  </span>
                </div>
              </div>
              <div
                class="card-footer px-4 py-0 d-flex justify-content-between mt-3"
              >
                <a
                  class="card-book d-flex align-items-center text-color-900 text-decoration-none"
                  role="button"
                  @click="useDoctorStore.onClickToBooking(doctor.id)"
                >
                  <span><i class="fa-regular fa-calendar-range"></i></span>
                  <p class="ms-2 mb-0 fs-6 fw-medium">ការណាត់ជួប</p>
                </a>
                <div class="divider"></div>
                <a
                  class="card-info d-flex align-items-center text-color-900 text-decoration-none"
                  role="button"
                  @click="useDoctorStore.onClickToDetail(doctor.id)"
                >
                  <span><i class="fa-regular fa-circle-info"></i></span>
                  <p class="ms-2 mb-0 fs-6 fw-medium">ព័ត៌មានបន្ថែម</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="mb-5 mt-0" :class="{ 'd-none': totalPage == 1 }">
      <nav aria-label="Page">
        <ul
          class="pagination page_component"
          :class="{ 'page-item unactive': currentPage === 1 }"
        >
          <li class="page-item" :class="{ unactive: currentPage === 1 }">
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
            :class="{ active: page === currentPage, unactive: page === '...' }"
          >
            <a
              v-if="loadingPagination === page"
              class="page-link"
              :class="{ loading: useDoctorStore.loadingPagination == true }"
              @click.prevent="changePage(page)"
            >
              <div class="loader"></div>
            </a>
            <a v-else class="page-link" @click.prevent="changePage(page)">
              {{ page }}
            </a>
          </li>
          <!-- ========================== -->
          <li
            class="page-item"
            :class="{ 'page-item unactive': currentPage === totalPage }"
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
  </main>
</template>

<script setup>
import { historySearch } from "@/stores/finddcotorstore";
import loadingView from "@/views/loading/loadingView.vue";
import { onMounted, ref, computed, watch, onBeforeUnmount } from "vue";
import { debounce } from "lodash";
const showSearch = ref(false);
const hideSearch = () => {
  showSearch.value = false;
};
const loadingPagination = ref(null);

const isSelectOpen = ref(false);
const pages = ref([]);
// const loading = ref(true);
const useDoctorStore = historySearch();
const currentPage = computed(() => useDoctorStore.currentPage);
const totalPage = computed(() => useDoctorStore.totalPage);

const pageLoading = ref(true);
onMounted(async () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
  try {
    await useDoctorStore.getSpecialists();
    await useDoctorStore.fetchAllData();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
  //   useDoctorStore.getDoctor(currentPage.value);
});

onBeforeUnmount(() => {
  sessionStorage.removeItem("currentPage");
  useDoctorStore.getDoctor(1);
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

const changePage = (p) => {
  if (p === "..." || p < 1 || p > totalPage.value) return;
  loadingPagination.value = p;
  useDoctorStore.getDoctor(p).finally(() => {
    loadingPagination.value = null;
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
  generatePagination();
};

// const selectArticle = async (id) => {
//   useDoctorStore.setSelectId(id);
//   window.scrollTo({top: 0, behavior: 'smooth'})
// };
// ======================================================
const onSearchSubmit = async () => {
  hideSearch();
  useDoctorStore.currentPage = 1;
  sessionStorage.setItem("currentPage", 1);
  useDoctorStore.loading = true;
  await useDoctorStore.getDoctor(1, useDoctorStore.filter.inputSearch);
};
const onSearchInput = debounce(async () => {
  showSearch.value = true;

  if (useDoctorStore.filter.inputSearch.trim() !== "") {
    await useDoctorStore.getInput();
  } else {
    useDoctorStore.doctors = [];
  }
}, 500);
// const onSearchInput = debounce(async () => {
//   showSearch.value = true;

//   if (articlestore.inputsearch.trim() !== "") {
//     await articlestore.getInput();
//   } else {
//     articlestore.inputarticle = [];
//   }
// }, 500);

// ======================================================
</script>
