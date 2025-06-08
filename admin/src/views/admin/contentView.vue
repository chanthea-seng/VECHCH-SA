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

            <div class="col-6 p-0 pe-2">
              <div class="card card-tag p-4 border-0 rounded-4">
                <div class="card-header p-0 bg-transparent border-0 mb-2">
                  <p class="m-0 text-color-950 fw-medium">Content Category</p>
                </div>
                <div
                  class="card-body p-0 mb-3 d-flex flex-wrap justify-content-between"
                >
                  <div class="d-flex w-100 justify-content-between">
                    <div class="col-3">
                      <select
                        name=""
                        id=""
                        class="form-select"
                        v-model="useContentStore.selectCateType"
                        @change="useContentStore.getCate()"
                      >
                        <option value="1">Article</option>
                        <option value="2">Disease</option>
                      </select>
                    </div>
                    <div class="col-7">
                      <input
                        type="search"
                        class="form-control"
                        placeholder="search tag"
                        id="inputsearchtag"
                        v-model="useContentStore.cateInput"
                        @input="useContentStore.searchCate()"
                      />
                    </div>
                    <primaryBtn
                      label="Add"
                      class="px-3"
                      :click-event="OnClickToggleCatCollapse"
                    />
                  </div>
                  <div class="col-12">
                    <div class="collapse" id="collapseCate">
                      <div class="d-flex column-gap-3">
                        <input
                          type="search"
                          class="form-control"
                          placeholder="English Cate"
                          v-model="useContentStore.inputNameCate"
                        />
                        <input
                          type="search"
                          class="form-control"
                          placeholder="Khmer Cate"
                          v-model="useContentStore.inputLocalNameCate"
                        />
                        <div class="d-flex">
                          <a
                            role="button"
                            class="text-danger"
                            @click="useContentStore.onClickClearTask(2)"
                          >
                            <span>
                              <i class="fa-regular fa-xmark-large"></i>
                            </span>
                          </a>
                          <a
                            role="button"
                            class="text-color-600"
                            @click="onClickCreateCate()"
                          >
                            <span>
                              <i class="fa-regular fa-plus-large"></i>
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer p-0 border-0 bg-transparent">
                  <ul class="list-group" v-if="cates">
                    <li
                      class="list-group-item"
                      v-for="cate in cates"
                      :key="cate.id"
                    >
                      <div class="d-flex align-items-center">
                        <div class="col-1 text-center">
                          <span>{{ cate.id }}</span>
                        </div>
                        <div class="col-5">
                          <p class="m-0 limit-line-1">
                            {{ cate.name }}
                          </p>
                        </div>
                        <div class="col-5">
                          <p class="m-0 limit-line-1">
                            {{ cate.local_name }}
                          </p>
                        </div>
                        <div class="col-1 d-flex justify-content-between fs-5">
                          <a
                            @click="onClickEditCate(cate)"
                            class="text-warning cursor-pointer"
                          >
                            <span>
                              <i class="fa-light fa-pen-to-square"></i>
                            </span>
                          </a>
                          <a
                            @click="openModalDelTagCate(2, cate.id)"
                            class="text-danger cursor-pointer"
                          >
                            <span>
                              <i class="fa-light fa-trash"></i>
                            </span>
                          </a>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- tag -->
            <div class="col-6 p-0 ps-2 mb-3">
              <div class="card card-tag p-4 border-0 rounded-4">
                <div class="card-header p-0 bg-transparent border-0 mb-2">
                  <p class="m-0 text-color-950 fw-medium">Content tag</p>
                </div>
                <div
                  class="card-body p-0 mb-3 d-flex flex-wrap justify-content-between"
                >
                  <div class="d-flex justify-content-between w-100">
                    <div class="col-3">
                      <select
                        name=""
                        id=""
                        class="form-select"
                        v-model="useContentStore.selectTagType"
                        @change="useContentStore.getTag()"
                      >
                        <option value="1">Article</option>
                        <option value="2">Disease</option>
                      </select>
                    </div>
                    <div class="col-7">
                      <input
                        type="search"
                        class="form-control"
                        placeholder="search tag"
                        id="inputsearchtag"
                        v-model="useContentStore.tagInput"
                        @input="useContentStore.searchTag()"
                      />
                    </div>
                    <primaryBtn
                      class="px-3"
                      label="Add"
                      :click-event="OnClickToggleTagCollapse"
                    />
                  </div>
                  <div class="col-12">
                    <div class="collapse" id="collapseTag">
                      <div class="d-flex column-gap-3">
                        <input
                          type="search"
                          class="form-control"
                          placeholder="English tag"
                          v-model="useContentStore.inputNameTag"
                        />
                        <input
                          type="search"
                          class="form-control"
                          placeholder="Khmer tag"
                          v-model="useContentStore.inputLocalNameTag"
                        />
                        <div class="d-flex">
                          <a
                            role="button"
                            class="text-danger"
                            @click="useContentStore.onClickClearTask(1)"
                          >
                            <span>
                              <i class="fa-regular fa-xmark-large"></i>
                            </span>
                          </a>
                          <a
                            role="button"
                            class="text-color-600"
                            @click="onClickCreateTag()"
                          >
                            <span>
                              <i class="fa-regular fa-plus-large"></i>
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer p-0 border-0 bg-transparent">
                  <ul class="list-group" v-if="tags">
                    <li
                      class="list-group-item"
                      v-for="tag in tags"
                      :key="tag.id"
                    >
                      <div class="d-flex align-items-center">
                        <div class="col-1 text-center">
                          <span>{{ tag.id }}</span>
                        </div>
                        <div class="col-5">
                          <p class="m-0 limit-line-1">
                            {{ tag.name }}
                          </p>
                        </div>
                        <div class="col-5">
                          <p class="m-0 limit-line-1">
                            {{ tag.local_name }}
                          </p>
                        </div>
                        <div class="col-1 d-flex justify-content-between fs-5">
                          <a
                            @click="onClickEditTag(tag)"
                            class="text-warning cursor-pointer"
                          >
                            <span>
                              <i class="fa-light fa-pen-to-square"></i>
                            </span>
                          </a>
                          <a
                            @click="openModalDelTagCate(1, tag.id)"
                            class="text-danger cursor-pointer"
                          >
                            <span>
                              <i class="fa-light fa-trash"></i>
                            </span>
                          </a>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="content-container bg-white p-4 rounded-4">
              <div class="section-title mb-4">
                <h5 class="text-color-900">Content</h5>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <div class="d-flex column-gap-3 align-item-center">
                  <input
                    type="search"
                    class="search-input"
                    placeholder="Search..."
                    v-model="useContentStore.filter.search"
                    @input="useContentStore.getContent()"
                  />
                  <div class="group-radio d-flex">
                    <div class="">
                      <input
                        type="radio"
                        name="content"
                        class="d-none"
                        value="1"
                        checked
                        id="article"
                        v-model="useContentStore.filter.type"
                        @change="useContentStore.getContent()"
                      />
                      <label for="article">
                        <span>Article</span>
                      </label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="content"
                        class="d-none"
                        value="2"
                        id="disease"
                        v-model="useContentStore.filter.type"
                        @change="useContentStore.getContent()"
                      />
                      <label for="disease">
                        <span>Article Disease</span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 position-relative p-0ា">
                <div
                  class="overlay-card py-2 px-4 fs-6"
                  :class="{ 'd-block': !!isSelecting }"
                >
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <span class="text-red fw-medium"
                      >{{ selected.length }} Choose</span
                    >
                    <a role="button" @click="openModal()">
                      <span>Delete <i class="bi bi-trash"></i></span>
                    </a>
                    <a role="button" @click="onClickClear()">
                      <span class="fs-4"><i class="bi bi-x"></i></span>
                    </a>
                  </div>
                </div>

                <div class="row p-0 g-0 row-gap-3 justify-content-between">
                  <div
                    class="card-article p-0"
                    v-for="card in contents"
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
                          :class="{
                            'border-select': selected.includes(card.id),
                          }"
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
                            {{ card.title }}
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
    </div>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="Reminder? Are you sure to delete articles!"
    @confirm="confirmDelete"
  />
  <mdlConfirm
    ref="modalDelRef"
    message="Reminder? Are you sure to delete article!"
    @confirm="confirmDeleteArticle"
  />
  <mdlConfirm
    ref="modalRefTagCate"
    message="Reminder! Are you sure to delete it?"
    @confirm="onClickDeleteTagCate"
  />
</template>

<script setup>
import loadingView from "@/components/loadingView.vue";
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import primaryBtn from "@/components/layouts/primaryBtn.vue";
import mdlConfirm from "@/components/layouts/mdlConfirm.vue";
import { useNotyfStore } from "@/stores/notyfStore";
import { contentStore } from "@/stores/contentStore";
import { useAuthStore } from "@/stores/userAuthStore";
import { Collapse } from "bootstrap";
import { ref, computed, onMounted, compile } from "vue";
import axios from "axios";

const cates = computed(() => useContentStore.cates);
const tags = computed(() => useContentStore.tags);

const useContentStore = contentStore();
const authStore = useAuthStore();
const notfy = useNotyfStore();

const modalRefTagCate = ref(null);
const openModalDelTagCate = (type, id) => {
  useContentStore.selectedId = id;
  useContentStore.selectType = type;
  modalRefTagCate.value.openModal();
};
const onClickDeleteTagCate = () => {
  useContentStore.deleteItem(
    useContentStore.selectType,
    useContentStore.selectedId
  );
};
const modalRef = ref(null);
const openModal = () => {
  modalRef.value.openModal();
};
const modalDelRef = ref(null);
const openModalDel = (id) => {
  useContentStore.selectedId = id;
  modalDelRef.value.openModal();
};

const contents = computed(() => useContentStore.contents);
const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;
    useContentStore.collapseTag = Collapse.getOrCreateInstance(
      document.getElementById("collapseTag")
    );
    useContentStore.collapseCate = Collapse.getOrCreateInstance(
      document.getElementById("collapseCate")
    );
    await useContentStore.getTag();
    await useContentStore.getCate();
    await useContentStore.getContent();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const OnClickToggleCatCollapse = () => {
  if (useContentStore.collapseCate) {
    useContentStore.collapseCate.toggle();
  }
};
const OnClickToggleTagCollapse = () => {
  if (useContentStore.collapseTag) {
    useContentStore.collapseTag.toggle();
  }
};

const onClickEditTag = (tag) => {
  useContentStore.collapseTag.toggle();
  useContentStore.selectTagId = tag.id;
  useContentStore.inputNameTag = tag.name;
  useContentStore.inputLocalNameTag = tag.local_name;
};
const onClickEditCate = (cate) => {
  useContentStore.collapseCate.toggle();
  useContentStore.selectCateId = cate.id;
  useContentStore.inputNameCate = cate.name;
  useContentStore.inputLocalNameCate = cate.local_name;
};

const onClickCreateTag = () => {
  useContentStore.getCreate(1);
};
const onClickCreateCate = () => {
  useContentStore.getCreate(2);
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
    // hover = null;
    notfy.success("Delete Success");
    await useContentStore.getContent();
  } catch (error) {
    notfy.warning("Fail to delete!");
  }
};
const confirmDeleteArticle = async () => {
  try {
    if (useContentStore.selectedId != 0) {
      authStore.loadToken();
      const res = await axios.request({
        url: `/api/articles/${useContentStore.selectedId}`,
        method: "DELETE",
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      });
      useContentStore.selectedId = 0;
      notfy.success("Delete Success");
      await useContentStore.getContent();
    }
  } catch (error) {
    notfy.warning("Fail to delete!");
  }
};
const onClickDetail = (id) => {
  //   sessionStorage.setItem("articleId", id);
  //   if (selected.value.length === 0) {
  //     router.push(`/article-detail`);
  //   }
};
const cardDropdownControl = (id) => {
  const dropdownElement = document
    .querySelector(`#checkbox${id}`)
    .closest(".card")
    .querySelector(".cus-dropdown");
  const dropdown = new Dropdown(dropdownElement);
  dropdown.toggle();
};
</script>
