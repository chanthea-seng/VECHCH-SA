<template>
  <main class="bg-main">
    <loadingView v-if="pageLoading" />

    <div class="row justify-content-between position-relative g-0">
      <div class="col-2 p-0">
        <sidebar />
      </div>
      <div class="col-10 p-0">
        <navhead class="position-static" />
        <div class="row p-0 ps-4 g-0">
          <div class="col-12 p-0 mt-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <RouterLink to="/article">
                    <i class="fas fa-home"></i> អត្ថបទ
                  </RouterLink>
                </li>
                <li>
                  <i class="fa-light fa-angle-right fw-medium"></i>
                </li>
                <li class="breadcrumb-item">
                  <RouterLink to="/postarticle">
                    <i class="fas fa-book"></i> បង្កើតសំណេរអត្ថបទ
                  </RouterLink>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-12 p-0 mb-3">
            <div class="d-flex p-0 justify-content-between">
              <a role="button" class="showTool-btn" @click="toggleTool">
                <span><i class="bi bi-three-dots-vertical"></i> មាតិកា</span>
              </a>
              <div class="d-flex column-gap-2">
                <PrimaryBtn label="រក្សាទុក" :clickEvent="onClickDraft" />

                <PrimaryBtn
                  label="ផ្សព្វផ្សាយ"
                  v-if="articleStatus == 0"
                  :clickEvent="onClickPublish"
                />
              </div>
            </div>
          </div>
          <div class="row g-0 p-0">
            <div class="post-tool-container" :class="{ hidden: isToolHidden }">
              <div class="quill-tool-container overflow-hidden">
                <div class="card h-100 d-block p-3 border-0">
                  <div
                    class="card-header d-flex p-0 bg-transparent align-item-center justify-content-between mb-3"
                  >
                    <h4 class="text-color-900">មាតិកា</h4>
                    <a role="button" class="showTool" @click="toggleTool">
                      <span><i class="fa-light fa-xmark"></i></span>
                    </a>
                  </div>
                  <div
                    class="card-body d-flex flex-wrap row-gap-3 p-0 bg-transparent"
                  >
                    <div class="col-12">
                      <p class="mb-2 fw-medium">រូបភាព</p>
                      <input
                        type="file"
                        id="input-image"
                        class="d-none"
                        @change="handleFile"
                        accept="image/*"
                        ref="fileInput"
                      />
                      <label for="input-image" class="label-input-image">
                        <div
                          class="card p-0 bg-transparent"
                          @click.prevent="triggerFileInput"
                        >
                          <div class="col-12 text-center">
                            <img
                              v-if="!imageUrl || imageUrl === defaultImage"
                              src="@/assets/image/uploadImage.svg"
                              alt="Upload"
                              class="upload-img object-fit-cover"
                            />
                          </div>
                          <span
                            class="text-center"
                            v-if="!imageUrl || imageUrl === defaultImage"
                          >
                            ជ្រើសរើសរូបភាពដែលអ្នកចង់បាន
                          </span>
                          <img
                            v-else
                            :src="imageUrl"
                            class="preview object-fit-cover"
                          />
                        </div>
                      </label>
                    </div>
                    <div class="col-12">
                      <label for="title-input" class="mb-2 form-label"
                        >ចំណងជើង</label
                      >
                      <input
                        type="text"
                        id="title-input"
                        v-model="storePostArticle.article.title"
                        class="form-control-global"
                      />
                    </div>
                    <div class="col-12">
                      <label for="autoTextarea" class="mb-2 fw-medium"
                        >អត្ថបទសង្ខេប</label
                      >
                      <textarea
                        name=""
                        v-model="storePostArticle.article.short_description"
                        class="form-control-global"
                        id="autoTextarea"
                      ></textarea>
                    </div>
                    <div class="col-12">
                      <label for="selectCate" class="fw-medium mb-2"
                        >ប្រភេទនៃអត្ថបទ</label
                      >
                      <div class="select-wrapper">
                        <select
                          id="selectCate"
                          placeholder="ប្រភេទអត្ថបទ"
                          ref="selectCate"
                          v-model="storePostArticle.article.category_id"
                        >
                          <option
                            v-for="cate in catesStore"
                            :key="cate.id"
                            :value="cate.id"
                          >
                            {{ cate.local_name }}
                          </option>
                        </select>
                        <i
                          class="fa-light fa-angle-down icon-control"
                          :class="{ rotated: isCateOpen }"
                        ></i>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="selectTag" class="fw-medium mb-2">Tag</label>
                      <div class="select-wrapper tag">
                        <select
                          id="selectTag"
                          ref="selectTag"
                          placeholder="Select multiple"
                          multiple
                        >
                          <option
                            v-for="tag in tagsStore"
                            :key="tag.id"
                            :value="tag.id"
                          >
                            {{ tag.local_name }}
                          </option>
                        </select>
                        <button
                          v-if="
                            tomSelectInstance &&
                            tomSelectInstance.getValue().length > 0
                          "
                          @click="clearAllTags"
                          class="removeTag-btn"
                        >
                          <i class="fa-light fa-xmark"></i>
                        </button>

                        <i
                          class="fa-light fa-angle-down icon-control"
                          :class="{ rotated: isTagOpen }"
                        ></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="quill-editor-container p-3">
              <quillEditor />
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import PrimaryBtn from "@/components/global/primaryBtn.vue";
import loadingView from "@/components/global/loadingView.vue";
import TomSelect from "tom-select";
import quillEditor from "@/components/quill/quillEditor.vue";
import router from "@/router";

import { onMounted, ref, nextTick, watch, computed } from "vue";
import { usePostArticle } from "@/stores/postArticleStore";
import { useNotyfStore } from "@/stores/notfyStore";
const storePostArticle = usePostArticle();
const notyf = useNotyfStore();

const fileInput = ref(null);
const imageUrl = ref("");
const selectedFile = ref(null);

const props = defineProps({
  storePostArticle: Object,
});
const defaultImage = "@/assets/image/uploadImage.svg";
const noThumbnailPattern = /no_thumbnail\.jpg$/i;
const MAX_FILE_SIZE = 1 * 1024 * 1024;

watch(
  () => props.storePostArticle?.article?.thumbnail,
  (newThumbnail) => {
    if (newThumbnail) {
      imageUrl.value = newThumbnail;
    }
  },
  { immediate: true }
);

const triggerFileInput = () => {
  fileInput.value.click();
};

const handleFile = (event) => {
  const file = event.target.files[0];
  if (!file) return;

  if (file.size > MAX_FILE_SIZE) {
    notyf.warning("ទំហំរូបភាពធំពេក។ ត្រូវតែតិចជាង 1mb");
    selectedFile.value = null;
    return;
  }

  selectedFile.value = file;
  storePostArticle.article.thumbnail = file;
  const reader = new FileReader();

  reader.onload = (e) => {
    // console.log("File loaded:", e.target.result);
    imageUrl.value = e.target.result;
  };

  reader.onerror = (error) => {
    // console.error("Error reading file:", error);
  };

  reader.readAsDataURL(file);
};

const isToolHidden = ref(false);
const toggleTool = () => {
  let button = document.querySelector(".showTool-btn");
  isToolHidden.value = !isToolHidden.value;

  if (isToolHidden.value) {
    button.classList.add("hide");
  } else {
    button.classList.remove("hide");
  }
};

// TOm select
const selectCate = ref(null);
const selectTag = ref(null);
const isCateOpen = ref(false);
const isTagOpen = ref(false);
let tomSelectInstance = null;
let tomSelectCateInstance = null;

const articleStatus = computed(() => storePostArticle.article.is_published);
const catesStore = computed(() => storePostArticle.categories);
const tagsStore = computed(() => storePostArticle.tags);
const preSelectTags = computed(() =>
  storePostArticle.article.tag_ids
    .map((tag) => tag.id)
    .filter((id) => id !== undefined)
);
const preSelectCate = computed(() => storePostArticle.article.category_id);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    if (!(await storePostArticle.isAuthor())) {
      router.push("/article");
    }
    window.scrollTo({ top: 0, behavior: "smooth" });

    storePostArticle.articleId = sessionStorage.getItem("articleId");
    if (storePostArticle.articleId != 0) {
      await storePostArticle.getSingleArticle(storePostArticle.articleId);
      if (noThumbnailPattern.test(storePostArticle.article.thumbnail)) {
        imageUrl.value = defaultImage;
      } else {
        imageUrl.value = storePostArticle.article.thumbnail;
      }
    } else {
      router.push("/article");
    }

    const textarea = document.getElementById("autoTextarea");
    textarea.addEventListener("input", function () {
      this.style.height = "auto";
      this.style.height = this.scrollHeight + "px";
    });
    nextTick(() => {
      if (tomSelectCateInstance) {
        tomSelectCateInstance.destroy();
      }
      tomSelectCateInstance = new TomSelect(selectCate.value, {
        allowEmptyOption: true,
        placeholder: "ប្រភេទអត្ថបទ",
        onDropdownOpen: () => (isCateOpen.value = true),
        onDropdownClose: () => (isCateOpen.value = false),
        render: {
          item: (data, escape) => `
            <div class="custom-category" data-value="${escape(data.value)}">
              <span>
${escape(data.text)}
              </span>

            </div>`,
        },
      });
      tomSelectCateInstance.setValue(preSelectCate.value);
    });
    nextTick(() => {
      if (tomSelectInstance) {
        tomSelectInstance.destroy();
      }
      tomSelectInstance = new TomSelect(selectTag.value, {
        create: true,
        maxItems: 3,
        plugins: ["dropdown_input", "remove_button"],
        onDropdownOpen: () => (isTagOpen.value = true),
        onDropdownClose: () => (isTagOpen.value = false),
        sortField: { field: "text", direction: "asc" },
        render: {
          item: (data, escape) => `
            <div class="custom-tag" data-value="${escape(data.value)}">
              ${escape(data.text)}
			  </div>`,
        },
      });
      tomSelectInstance.setValue(preSelectTags.value);
      tomSelectInstance.on("item_add", () => {
        const selectedTags = tomSelectInstance.getValue();
        const tagArray =
          typeof selectedTags === "string"
            ? selectedTags.split(",").map(Number)
            : selectedTags;
        storePostArticle.article.tag_ids = tagArray;
      });
    });
  } catch (error) {
  } finally {
    window.scrollTo({ top: 0, behavior: "smooth" });
    pageLoading.value = false;
  }
});
const clearAllTags = () => {
  if (tomSelectInstance) {
    tomSelectInstance.clear();
  }
};
const onClickDraft = async () => {
  storePostArticle.isPublish = 0;
  await storePostArticle.onClickSubmit();
};

const onClickPublish = async () => {
  storePostArticle.isPublish = 1;
  await storePostArticle.handleSubmit();
};
</script>

<style scoped>
.post-tool-container {
  max-width: 28%;
  transition: 0.3s;
  transition: width 0.3s ease, opacity 0.3s ease;
  flex-shrink: 0;
  height: 100%;
  margin-right: 20px;
}
.post-tool-container .quill-tool-container {
  width: 100%;
  border: 1px solid #eceded;
  border-radius: 16px;
  height: 100%;
}

.quill-editor-container {
  width: 70%;
  border: 1px solid #eceded;
  background-color: white;
  border-radius: 16px;
  min-height: 100vh;
  transition: width 0.3s ease;
  flex-grow: 1;
}

.post-tool-container.hidden {
  width: 0%;
  opacity: 0;
  overflow: hidden;
  flex-shrink: 0;
  margin-right: 0px;
}
</style>
