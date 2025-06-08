<template>
  <main class="save setting article">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h5 class="setting-title text-color-950">ការរក្សាទុករបស់ខ្ញុំ</h5>
        <p class="mb-0" style="color: #424c4f; font-size: 15px">
          រាល់ពេលដែលលោកអ្នកធ្វើការរក្សាទុកទិន្នន័យផ្សេងៗ​
          វានឹងត្រូវបានបន្ថែមនៅទីនេះដើម្បីផ្ដល់ភាពងាយស្រួលចូលប្រើម្ដងទៀត
        </p>
      </div>
    </div>
    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button
          class="nav-link active"
          id="pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-home"
          type="button"
          role="tab"
          aria-controls="pills-home"
          aria-selected="true"
        >
          គ្រូពេទ្យ
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button
          class="nav-link"
          id="pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#pills-profile"
          type="button"
          role="tab"
          aria-controls="pills-profile"
          aria-selected="false"
        >
          ចំណេះដឹងសុខភាព
        </button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div
        class="tab-pane fade show active"
        id="pills-home"
        role="tabpanel"
        aria-labelledby="pills-home-tab"
        tabindex="0"
      >
        <div class="row g-4">
          <div
            v-for="doctor in docStore.SaveDoctorData"
            :key="doctor.id"
            class="col-6"
          >
            <div class="card doctor rounded-3 overflow-hidden">
              <div class="p-3 d-flex position-relative">
                <div
                  class="col-3 overflow-hidden"
                  style="width: 90px; height: 90px; border-radius: 100%"
                >
                  <img
                    :src="doctor.avatar"
                    class="w-100 h-100 object-fit-cover"
                    alt=""
                  />
                </div>
                <div class="ms-3">
                  <h5 class="mb-2">{{ doctor.local_fullname }}</h5>
                  <div class="d-flex">
                    <div class="spacail">
                      <p class="mb-0">ឯកទេស៖</p>
                      <p class="my-1">ភាសា៖</p>
                      <p class="mb-0">មជ្ឈមណ្ឌល៖</p>
                    </div>
                    <div>
                      <p class="mb-0 text-color-900">
                        {{ doctor?.specialist?.local_name }}
                      </p>
                      <p class="my-1 text-color-900">
                        {{ doctor?.department?.local_name }}
                      </p>
                      <p class="mb-0 text-color-900">
                        {{ doctor?.center?.local_name }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-0 d-flex justify-content-between">
                <a
                  @click="articlestore.onselectIdDoctor(doctor.id)"
                  role="button"
                  class="w-50 p-2 btn-bg-650 text-center"
                >
                  <i class="bi bi-calendar2-week"></i> កក់ឥឡូវនេះ
                </a>
                <a
                  @click="docStore.onClickToDetail(doctor.id)"
                  role="button"
                  class="w-50 p-2 btn-bg-650 read-more bg-transparent"
                  ><i class="bi bi-info-circle"></i> ព័មានបន្ថែម</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="tab-pane fade"
        id="pills-profile"
        role="tabpanel"
        aria-labelledby="pills-profile-tab"
        tabindex="0"
      >
        <div class="row g-3">
          <div
            v-for="art in articlestore.articlesave"
            :key="art.id"
            class="col-4"
          >
            <a
              @click="articlestore.getArticle(art.id)"
              role="button"
              class="card border-0 news box-shadow text-decoration-none overflow-hidden"
            >
              <div class="img rounded-3 overflow-hidden position-relative">
                <img
                  :src="art.thumbnail"
                  class="w-100 h-100 object-fit-cover"
                  alt=""
                />
                <div class="tag">
                  {{ art.category.local_name }}
                </div>
              </div>
              <div class="card-body pt-2 position-relative">
                <h5 class="mb-0 pb-0 limit-line-2">{{ art.title }} </h5>

                <p
                  class="my-2 text-color-gray limit-line-2"
                  style="font-size: 15px"
                >
                  {{ art.short_description }}
                </p>

                <div
                  class="d-flex align-items-center justify-content-between me-4"
                >
                  <div
                    class="txt-small text-color-text fw-medium"
                    style="font-size: 14px"
                  >
                    <i class="bi bi-clock"></i> {{ art.local_updated_at }}
                  </div>

                  <div class="text-color-gray d-flex align-items-center">
                    <i class="bi bi-eye me-1"></i>
                    <span class="fw-medium" style="font-size: 14px">{{
                      art.view
                    }}</span>
                  </div>
                  <a
                    v-show="!art.is_save"
                    @click.stop.prevent="onSavearticle(art.id)"
                    role="button"
                    class="position-absolute save"
                  >
                    <i class="bi bi-bookmarks-fill text-color-warning"></i>
                  </a>
                  <a
                    v-show="art.is_save"
                    @click.stop.prevent="onResetSavearticle(art.id)"
                    role="button"
                    class="position-absolute save"
                  >
                    <i class="bi bi-bookmarks text-color-gray"></i>
                  </a>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { articleStore } from "@/stores/articalStore";
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/authTokenStore";
import { historySearch } from "@/stores/finddcotorstore";
import { ref } from "vue";
import axios from "axios";
const articlestore = articleStore();

const docStore = historySearch();
const token = useAuthStore();

const expanded = ref(false);

const onSavearticle = async (id) => {
  let index = articlestore.articlesave.findIndex((item) => item.id == id);

  if (index === -1) {
    // console.error("Article not found in store");
    return;
  }

  try {
    token.loadToken();
    const response = await axios.delete(`api/save/articles/${id}`, {
      headers: {
        Authorization: `Bearer ${token.token}`,
        "Content-Type": "multipart/form-data",
      },
    });

    if (response.status === 200) {
      articlestore.articlesave = articlestore.articlesave.filter(
        (item) => item.id !== id
      );
    }

    if (typeof articlestore.onSavearticle === "function") {
      articlestore.onSavearticle();
    }
  } catch (error) {
    // console.error("Error deleting saved article:", error);
  }
};

const onResetSavearticle = (id) => {
  let index = articlestore.articlesave.findIndex((item) => item.id == id);
  articlestore.articlesave[index].is_save = false;
};

const toggleDescription = () => {
  expanded.value = !expanded.value;
};

const onSaveDoctor = async (id) => {
  //   console.log("ha", docStore.doctorSave);

  let index = docStore.doctorSave.findIndex((item) => item.id == id);
  // docStore.doctorSave[index].is_save = true;

  // let index = articlestore.articlesave.findIndex((item) => item.id == id);

  if (index === -1) {
    // console.error("Article not found in store");
    return;
  }

  try {
    token.loadToken();
    const response = await axios.delete(`/api/save/doctors/${id}`, {
      headers: {
        Authorization: `Bearer ${token.token}`,
        "Content-Type": "multipart/form-data",
      },
    });

    if (response.status === 200) {
      docStore.doctorSave = docStore.doctorSave.filter(
        (item) => item.id !== id
      );
    }

    if (typeof docStore.onSaveDoctor === "function") {
      docStore.onSaveDoctor();
    }
  } catch (error) {
    // console.error("Error deleting saved doctor:", error);
  }
};

const onResetSaveDoctor = (id) => {
  //   console.log("ha", docStore.doctorSave);

  let index = docStore.doctorSave.findIndex((item) => item.id == id);
  docStore.doctorSave[index].is_save = false;
};

// const onClickbooking = (() => {

// })

onMounted(async () => {
  await articlestore.loadSaveArticle();
  await docStore.onloadSave();

  // console.log('article save settting',articlestore.articlesave);

  // console.log();
});
</script>
