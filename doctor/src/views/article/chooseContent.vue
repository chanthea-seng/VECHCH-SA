<template>
  <main class="bg-main">
    <loadingView v-if="pageLoading" />

    <div class="row justify-content-between position-relative g-0">
      <div class="col-2 p-0">
        <sidebar />
      </div>
      <div class="col-10 p-0">
        <navhead />
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
                  <RouterLink to="/chooseContent">
                    <i class="fas fa-book"></i> បង្កើតសំណេរអត្ថបទ
                  </RouterLink>
                </li>
              </ol>
            </nav>
          </div>
          <div class="col-12">
            <div class="card content-card">
              <div class="card-header bg-transparent border-0 text-center">
                <h4 class="text-color-900 fw-medium">ប្រភេទសំណេរអត្ថបទ</h4>
                <span>សូមធ្វើការជ្រើសរើសប្រភេទអត្ថបទដែលលោកអ្នកចង់បាន</span>
              </div>
              <div
                class="card-body d-flex flex-wrap justify-content-center gap-4"
              >
                <div class="content-type">
                  <input
                    type="radio"
                    id="contentArticle"
                    name="content"
                    class="d-none radio-content"
                    value="1"
                    v-model="storePostArticle.contentType"
                  />
                  <label class="label-content-type" for="contentArticle">
                    <div class="col-10 m-auto">
                      <img
                        src="./../../assets/image/worldwide 1.png"
                        class="img-fluid mb-3"
                        alt=""
                      />
                    </div>
                    <span class="fw-medium">អត្ថបទសុខភាព</span>
                  </label>
                </div>
                <div class="content-type">
                  <input
                    type="radio"
                    id="contentDisease"
                    name="content"
                    class="d-none radio-content"
                    value="2"
                    v-model="storePostArticle.contentType"
                  />
                  <label class="label-content-type" for="contentDisease">
                    <div class="col-10 m-auto">
                      <img
                        src="./../../assets/image/virus 1.png"
                        class="img-fluid mb-3"
                        alt=""
                      />
                    </div>
                    <span class="fw-medium">អត្ថបទជំងឺ</span>
                  </label>
                </div>
                <div class="col-12 d-flex justify-content-center">
                  <primaryBtn
                    label="ដំណើរការបន្ទាប់"
                    :click-event="onClickStartArticle"
                  />
                </div>
              </div>
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
import primaryBtn from "@/components/global/primaryBtn.vue";
import { usePostArticle } from "@/stores/postArticleStore";
import router from "@/router";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import { useNotyfStore } from "@/stores/notfyStore";
import { onMounted, ref } from "vue";
const storePostArticle = usePostArticle();
const storeAuth = useAuthStore();
const notfy = useNotyfStore();

const pageLoading = ref(true);
onMounted(async () => {
  try {
    if (await storePostArticle.isAuthor()) {
      return;
    } else return router.push("/article");
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const onClickStartArticle = () => {
  if (storePostArticle.contentType != 0) {
    CreateArticle();
  } else notfy.warning("សូមជ្រើសរើសមាតិកា");
};

const CreateArticle = () => {
  storeAuth.loadToken();
  const frmData = new FormData();
  frmData.append("type", storePostArticle.contentType);
  axios
    .post("/api/articles", frmData, {
      headers: {
        Authorization: `Bearer ${storeAuth.token}`,
        "Content-Type": "multipart/form-data",
      },
    })
    .then((res) => {
      sessionStorage.setItem("articleId", res.data.data.id);

      router.push("/postarticle");
    })
    .catch((error) => {});
};
</script>
