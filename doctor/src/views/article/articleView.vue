<template>
  <main class="bg-main article-page">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid p-0">
      <div class="row position-relative g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />

          <div class="row g-0 p-0 ps-4 row-gap-4">
            <div class="col-12">
              <div class="card card-banner mt-4">
                <h3 class="text-gradient fw-semibold">
                  ការចែករំលែកចំណេះដឹងរបស់អ្នកគឺជាសារដ៏មានឥទ្ធិពលក្នុងការជួយ<br />លើកកម្ពស់ការយល់ដឹងអំពីវិស័យសុខាភិបាល
                </h3>
                <p class="mb-3 fw-medium">
                  តាមរយៈ​ការចែករំលែក​ចំណេះដឹង អ្នក​ជួយ​លើកកម្ពស់​ការយល់ដឹង
                  និង​ជំរុញ​វឌ្ឍនភាព​ក្នុង​វិស័យ​សុខាភិបាល
                </p>
                <div>
                  <primaryBtn
                    label="សរសេរអត្ថបទ"
                    :click-event="onClickPostArticle"
                  />
                </div>
              </div>
            </div>
            <div class="col-6 pe-2">
              <div
                class="card overview-card p-4 position-relative overflow-hidden"
              >
                <div class="cicle-radial"></div>
                <div class="card-body p-0 d-flex align-items-center">
                  <div class="col-8">
                    <h5 class="text-gradient">អត្ថបទបានចែករំលែក</h5>
                    <p class="text-grey mb-2">
                      <i class="fs-5 bi bi-text-paragraph"></i> សរុប
                      {{ storePostArticle.author.totalContent }} អត្ថបទ
                    </p>
                    <div class="d-flex align-items-center column-gap-1 mb-2">
                      <span class="col-4">ចំណេះដឹងសុខភាព</span>
                      <div
                        class="progress-container"
                        :style="{
                          width:
                            Math.max(
                              Math.min(
                                storePostArticle.author.wroteArticle,
                                100
                              ),
                              storePostArticle.author.minArticle
                            ) + '%',
                        }"
                      >
                        <div class="progress-bar"></div>
                      </div>
                      <span class="text-color-900 fw-medium">
                        {{ storePostArticle.author.wroteArticle }} អត្ថបទ</span
                      >
                    </div>
                    <div class="d-flex align-items-center column-gap-1">
                      <span class="col-4">អត្ថបទជំងឺ</span>
                      <div
                        class="progress-container"
                        :style="{
                          width:
                            Math.max(
                              Math.min(
                                storePostArticle.author.wroteDisease,
                                100
                              ),
                              storePostArticle.author.minArticle
                            ) + '%',
                        }"
                      >
                        <div class="progress-bar"></div>
                      </div>
                      <span class="text-color-900 fw-medium">
                        {{ storePostArticle.author.wroteDisease }} អត្ថបទ</span
                      >
                    </div>
                    <hr class="cus-hr" />
                    <p class="m-0">
                      ចំនូនអ្នកមើលសរុប​
                      <span class="text-color-600 fw-medium">{{
                        storePostArticle.author.viewArticle
                      }}</span>
                      នៃអត្ថបទសរុប
                    </p>
                  </div>
                  <div class="col-4 ps-3 position-relative z-2">
                    <div class="card-img overflow-hidden">
                      <img
                        src="./../../assets/image/total.jpg"
                        class="h-100 object-fit-cover"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 ps-2">
              <div
                class="card overview-card p-4 position-relative overflow-hidden h-100"
              >
                <div class="cicle-radial"></div>
                <div class="card-body p-0 d-flex align-items-center h-100">
                  <div
                    class="col-8 d-flex align-items-center justify-content-between flex-column h-100"
                  >
                    <div class="w-100">
                      <h5 class="text-gradient">អត្ថបទរក្សាទុក</h5>
                      <p class="text-grey mb-2">
                        <i class="fs-5 bi bi-text-paragraph"></i> សរុប
                        <span> {{ storePostArticle.author.unPublish }}</span>
                      </p>
                    </div>
                    <div class="w-100">
                      <hr class="cus-hr" />

                      <p class="m-0">សរសេរអត្ថបទបន្ថែមទៀត</p>
                    </div>
                  </div>
                  <div class="col-4 ps-3 position-relative z-2">
                    <div class="card-img overflow-hidden">
                      <img
                        src="./../../assets/image/draft.jpeg"
                        class="h-100 object-fit-cover"
                        alt=""
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 px-2">
              <h4 class="fw-medium text-color-800 mb-3">អត្ថបទសំណេរ</h4>
              <div
                class="d-flex justify-content-between align-items-center column-gap-2"
              >
                <div class="d-flex align-items-center column-gap-2">
                  <div class="d-flex column-gap-3">
                    <div class="group-radio d-flex">
                      <div class="">
                        <input
                          type="radio"
                          name="content"
                          class="d-none"
                          id="allContent"
                          value=""
                          v-model="storePostArticle.filter.contentType"
                          @change="storePostArticle.getArticle()"
                        />
                        <label for="allContent">ទាំងអស់</label>
                      </div>
                      <div>
                        <input
                          type="radio"
                          class="d-none"
                          name="content"
                          id="article"
                          value="1"
                          v-model="storePostArticle.filter.contentType"
                          @change="storePostArticle.getArticle()"
                        />
                        <label for="article">អត្ថបទព័ត៌មាន</label>
                      </div>
                      <div>
                        <input
                          type="radio"
                          class="d-none"
                          name="content"
                          id="disease"
                          value="2"
                          v-model="storePostArticle.filter.contentType"
                          @change="storePostArticle.getArticle()"
                        />
                        <label for="disease">ជំងឺអត្ថបទ</label>
                      </div>
                    </div>
                    <div class="group-radio d-flex">
                      <div class="">
                        <input
                          type="radio"
                          name="publish_type"
                          class="d-none"
                          id="published"
                          value="1"
                          v-model="storePostArticle.filter.published"
                          @change="storePostArticle.getArticle()"
                        />
                        <label for="published">ចែករំលែក</label>
                      </div>
                      <div>
                        <input
                          type="radio"
                          class="d-none"
                          name="publish_type"
                          id="draft"
                          value="0"
                          v-model="storePostArticle.filter.published"
                          @change="storePostArticle.getArticle()"
                        />
                        <label for="draft">រក្សាទុក</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center column-gap-2">
                  <a role="button" @click="storePostArticle.onClickOrder()">
                    <span class="fs-5">
                      <i
                        class="bi"
                        :class="
                          storePostArticle.filter.sdir === 'desc'
                            ? 'bi-sort-down-alt'
                            : 'bi-sort-up'
                        "
                      ></i>
                    </span>
                  </a>
                  <div
                    class="select-filter position-relative"
                    style="width: 200px"
                  >
                    <select
                      id="selectFilter"
                      placeholder="ប្រភេទអត្ថបទ"
                      ref="selectFilter"
                      v-model="storePostArticle.filter.scol"
                      @change="storePostArticle.getArticle()"
                    >
                      <option
                        v-for="cate in storePostArticle.ArrFilter"
                        :key="cate.id"
                        :value="cate.value"
                      >
                        {{ cate.name }}
                      </option>
                    </select>
                    <i
                      class="fa-light fa-angle-down icon-control"
                      :class="{ rotated: isFilterOpen }"
                    ></i>
                  </div>
                  <div>
                    <select
                      class="form-select"
                      v-model="storePostArticle.filter.per_page"
                      @change="storePostArticle.getArticle()"
                    >
                      <option value="10">10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                    </select>
                  </div>
                  <div>
                    <input
                      type="search"
                      class="form-control-global"
                      style="width: 300px"
                      v-model="storePostArticle.filter.searchArticle"
                      @input="storePostArticle.getArticle()"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 position-relative">
              <div
                class="overlay-card py-2 px-4 fs-6"
                :class="{ 'd-block': !!isSelecting }"
              >
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-red fw-medium"
                    >{{ selected.length }} ជ្រើសរើស</span
                  >
                  <a role="button" @click="openModal()">
                    <span>ធ្វើការដកចេញ <i class="bi bi-trash"></i></span>
                  </a>
                  <a role="button" @click="onClickClear()">
                    <span class="fs-4"><i class="bi bi-x"></i></span>
                  </a>
                </div>
              </div>
              <div class="row p-0 pb-5 g-0 row-gap-3 column-gap-2">
                <div
                  class="card-article p-0"
                  v-for="card in storePostArticle.cards"
                  :key="card.id"
                >
                  <div class="card bg-transparent p-0">
                    <label
                      :for="`checkbox${card.id}`"
                      class="d-block position-relative z-2"
                      @mouseenter="hover = card.id"
                      @mouseleave="hover = null"
                      @click="onClickDetail(card.id)"
                    >
                      <div
                        class="card-img position-relative"
                        :class="{ 'border-select': selected.includes(card.id) }"
                      >
                        <img :src="card.thumbnail" />
                        <div
                          v-if="hover === card.id || isSelecting"
                          class="overlay-wrapper"
                          :class="{ 'down-overlay': !!card.id }"
                        >
                          <input
                            type="checkbox"
                            :id="`checkbox${card.id}`"
                            :value="card.id"
                            v-model="selected"
                            class="cus-checkbox"
                            @click.stop
                          />
                          <div>
                            <a
                              @click.stop
                              @click="cardDropdownControl(card.id)"
                              role="button"
                              class="cus-dropdown"
                              data-bs-toggle="dropdown"
                            >
                              <i class="bi bi-three-dots"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                <button
                                  class="dropdown-item"
                                  type="button"
                                  @click="onClickDetail(card.id)"
                                  @click.stop
                                >
                                  ធ្វើបច្ចុប្បន្នភាព
                                </button>
                              </li>
                              <li>
                                <button
                                  class="dropdown-item"
                                  type="button"
                                  @click.stop
                                  @click="openModalDel(card.id)"
                                >
                                  ដកចេញ
                                </button>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="px-2">
                        <h6 class="text-color-950 limit-line-2 mt-2">
                          {{ card.title || "..." }}
                        </h6>
                        <small class="text-grey-small fw-medium">{{
                          card.lastUpdate
                        }}</small>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <mdlConfirm
    ref="modalRef"
    message="តើអ្នកប្រាកដក្នុងការលុប? អត្ថបទរបស់អ្នកមិនអាចទាញយកវាមកវិញបានទេ​!"
    @confirm="confirmDelete"
  />
  <mdlConfirm
    ref="modalDelRef"
    message="តើអ្នកប្រាកដក្នុងការលុប? អត្ថបទរបស់អ្នកមិនអាចទាញយកវាមកវិញបានទេ​!"
    @confirm="confirmDeleteArticle"
  />
</template>

<script setup>
import loadingView from "@/components/global/loadingView.vue";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import mdlConfirm from "@/components/global/mdlConfirm.vue";
import primaryBtn from "@/components/global/primaryBtn.vue";
import { ref, computed, onMounted } from "vue";
import { usePostArticle } from "@/stores/postArticleStore";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/userAuthStore";
import { useNotyfStore } from "@/stores/notfyStore";
import { Dropdown } from "bootstrap";
import TomSelect from "tom-select";
import axios from "axios";

const storePostArticle = usePostArticle();
const authStore = useAuthStore();
const notfy = useNotyfStore();
const router = useRouter();

const modalRef = ref(null);
const openModal = () => {
  modalRef.value.openModal();
};
const modalDelRef = ref(null);
const openModalDel = (id) => {
  storePostArticle.selectedId = id;
  modalDelRef.value.openModal();
};
const onClickPostArticle = async () => {
  if (await storePostArticle.isAuthor()) {
    router.push(`/chooseContent`);
  } else notfy.warning("អ្នកមិនអាចសរសេរអត្ថបទបានទេ សូមទាក់ទងទៅអ្នកគ្រប់គ្រង");
};

const onClickDetail = (id) => {
  storePostArticle.selectedId = id;
  sessionStorage.setItem("articleId", id);
  if (selected.value.length === 0) {
    router.push(`/postarticle`);
  }
};

let selected = ref([]);
let hover = ref(null);
const isSelecting = computed(() => selected.value.length > 0);
const onClickClear = () => {
  selected.value = [];
};
const confirmDelete = async () => {
  try {
    const frmData = new FormData();
    frmData.append("article_ids", JSON.stringify(selected.value));
    authStore.loadToken();
    const res = await axios.request({
      url: "/api/mass-delete-article",
      method: "DELETE",
      data: frmData,
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        "Content-Type": "application/json",
      },
    });
    onClickClear();
    selected.value = [];
    notfy.success("ការដកចេញជោគជ័យ");
    await storePostArticle.getArticle();
  } catch (error) {
    notfy.warning("ការដកចេញមានបញ្ហា");
  }
};
const confirmDeleteArticle = async () => {
  try {
    if (storePostArticle.selectedId != 0) {
      authStore.loadToken();
      const res = await axios.request({
        url: `/api/articles/${storePostArticle.selectedId}`,
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      });
      storePostArticle.selectedId = 0;
      notfy.success("ការដកចេញជោគជ័យ");
      await storePostArticle.getArticle();
    }
  } catch (error) {
    notfy.warning("ការដកចេញមានបញ្ហា");
  }
};

const isFilterOpen = ref(false);
const selectFilter = ref(null);
const pageLoading = ref(true);
onMounted(async () => {
  try {
    authStore.loadToken();
    await storePostArticle.getArticleData();
    new TomSelect(selectFilter.value, {
      allowEmptyOption: true,
      placeholder: "ប្រភេទអត្ថបទ",
      items: [],
      onDropdownOpen: () => (isFilterOpen.value = true),
      onDropdownClose: () => (isFilterOpen.value = false),
    });
    await storePostArticle.getArticle();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
const cardDropdownControl = (id) => {
  const dropdownElement = document
    .querySelector(`#checkbox${id}`)
    .closest(".card")
    .querySelector(".cus-dropdown");
  const dropdown = new Dropdown(dropdownElement);
  dropdown.toggle();
};
</script>
