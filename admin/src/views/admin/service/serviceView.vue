<template>
  <div class="main">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar />
        </div>

        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="content-container bg-white p-4 rounded-4">
              <div class="section-title mb-3">
                <h5 class="text-color-900">Health Services</h5>
              </div>
              <div
                class="d-flex justify-content-between align-items-center mb-3"
              >
                <div class="group-radio mb-3 d-flex">
                  <div class="">
                    <input
                      type="radio"
                      name="service"
                      class="d-none"
                      id="general"
                      value=""
                      v-model="useServiceStore.filter.service_type"
                      @change="loadingserviceType = 'general'"
                    />
                    <label for="general">
                      <div
                        v-if="loadingserviceType === 'general'"
                        class="loader"
                      ></div>
                      <div v-else class=""></div>
                      All
                    </label>
                  </div>
                  <div>
                    <input
                      type="radio"
                      name="service"
                      class="d-none"
                      id="package"
                      v-model="useServiceStore.filter.service_type"
                      value="1"
                      @change="loadingserviceType = 'package'"
                    />
                    <label for="package">
                      <div
                        v-if="loadingserviceType === 'package'"
                        class="loader"
                      ></div>
                      <div v-else class=""></div>
                      check-up package
                    </label>
                  </div>
                  <div>
                    <input
                      type="radio"
                      name="service"
                      class="d-none"
                      id="vaccine"
                      v-model="useServiceStore.filter.service_type"
                      value="2"
                      @change="loadingserviceType = 'vaccine'"
                    />
                    <label for="vaccine">
                      <div
                        v-if="loadingserviceType === 'vaccine'"
                        class="loader"
                      ></div>
                      <div v-else class=""></div>
                      vaccine
                    </label>
                  </div>
                </div>
                <div class="d-flex align-items-center column-gap-3">
                  <div>
                    <input
                      type="search"
                      class="search-input"
                      placeholder="search service"
                      v-model="useServiceStore.filter.search"
                      @input="useServiceStore.getService(1)"
                    />
                  </div>
                  <RouterLink
                    to="/service-detail"
                    role="button"
                    class="setting-doctor"
                  >
                    <i class="bi bi-plus"></i>
                  </RouterLink>
                </div>
              </div>
              <div class="row g-4 service-card">
                <div
                  v-for="service in services"
                  :key="service.id"
                  class="col-6"
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
                      <p class="limit-line-3">
                        {{ service.local_description }}
                      </p>
                      <div class="">
                        <span
                          class="fw-medium text-color-800"
                          style="font-size: 14px"
                        >
                          <i class="bi bi-bag-plus text-color-800 fs-5"></i>
                          {{ service.sub_services_count }}
                          type
                        </span>
                        <div
                          class="group-btn d-flex column-gap-3 mt-3 align-items-center"
                        >
                          <a
                            role="button"
                            class="pending-btn rounded-3"
                            @click="openModal(service.id)"
                          >
                            Delete
                          </a>
                          <a
                            role="button"
                            class="btn-bg-650"
                            @click="useServiceStore.onClickDetail(service.id)"
                            ><span> Update </span></a
                          >
                        </div>
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
                            loading: useServiceStore.paginationLoading == true,
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
          </div>
        </div>
      </div>
    </div>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="Delete service. Are you sure to delete?"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import mdlConfirm from "@/components/layouts/mdlConfirm.vue";
import Navhead from "@/components/layouts/header.vue";
import primaryBtn from "@/components/layouts/primaryBtn.vue";
import loadingView from "@/components/loadingView.vue";
import { serviceStore } from "@/stores/serviceStore";
import { computed, onMounted, onBeforeUnmount, watch, ref } from "vue";
const useServiceStore = serviceStore();
const services = computed(() => useServiceStore.services);

const totalPage = computed(() => useServiceStore.totalPage);
const currentPage = computed(() => useServiceStore.currentPage);
const pages = ref([]);
const loadingPagination = ref(null);
const loadingserviceType = ref(null);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    await useServiceStore.getService();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
const modalRef = ref(null);

const openModal = (id) => {
  useServiceStore.selectId = id;
  modalRef.value.openModal();
};
const confirmDelete = () => {
  if (useServiceStore.selectId != 0) {
    useServiceStore.onClickDeleteService(useServiceStore.selectId);
  }
};
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
  () => useServiceStore.filter.service_type,
  async () => {
    loadingserviceType.value = true;
    await useServiceStore.getService(
      1,
      useServiceStore.filter.per_page,
      useServiceStore.filter.service_type,
      true
    );
    loadingserviceType.value = false;
  }
);

const changePage = (p) => {
  if ((p == "..." || p > totalPage.value, p < 1)) return;
  loadingPagination.value = p;
  useServiceStore.getService(p).finally(() => {
    loadingPagination.value = null;
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
  generatePagination();
};
</script>
