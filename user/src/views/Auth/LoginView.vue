<template>
  <main class="login-page">
    <loadingView v-if="pageLoading" />

    <div class="row g-0 vh-100 position-relative">
      <div class="col-6 end-0 position-absolute top-0 h-100">
        <swiper
          :modules="modules"
          :slides-per-view="1"
          :loop="true"
          :pagination="true"
          :autoplay="{ delay: 5000, disableOnInteraction: false }"
          class="mySwiper"
        >
          <swiper-slide>
            <div class="content-wrapper">
              <img
                src="@/assets/images/auth/homePage/heart-disease.jpg"
                class=""
                alt=""
              />
              <p class="short-desc">
                កំហុសតូចមួយចំពោះសុខភាពរបស់អ្នក អាចធ្វើឲ្យអ្នក
                ឬមនុស្សជាទីស្រលាញ់របស់អ្នកខាតបង់យ៉ាងខ្លាំង។
                កុំឲ្យអាការ:កាន់តែធ្ងន់ធ្ងរ តោះៗពិភាក្សាជាមួយពួកយើងឥឡូវនេះ
              </p>
              <div class="gredient"></div>
            </div>
          </swiper-slide>
          <swiper-slide>
            <div class="content-wrapper">
              <img
                src="@/assets/images/auth/homePage/taking-care.jpg"
                class=""
                alt=""
              />
              <p class="short-desc">
                តាមរយៈគេហទំព័រនេះ អ្នកអាចកក់ការណាត់ជួបបានយ៉ាងងាយស្រួល
                ចូលប្រើកំណត់ត្រាវេជ្ជសាស្ត្រ
                និងរក្សាទំនាក់ទំនងជាមួយអ្នកជំនាញថែទាំសុខភាពរបស់យើង។
              </p>
              <div class="gredient"></div>
            </div>
          </swiper-slide>
          <swiper-slide>
            <div class="content-wrapper">
              <img
                src="@/assets/images/auth/homePage/surgery.jpg"
                class=""
                alt=""
              />
              <p class="short-desc">
                សុខភាពគឺជាសម្បត្តិដ៏មានតម្លៃបំផុតដែលមនុស្សម្នាក់អាចកាន់កាប់បាន។
                ទោះអ្នកមានទ្រព្យសម្បត្តិ បំណងប្រាថ្នា ឬក្តីសុបិន្តដល់មិនឈប់ឈរ
                ក៏ដោយ បើគ្មានសុខភាពល្អ អ្នកមិនអាចរីករាយនឹងអ្វីទាំងអស់នោះទេ។
                ការពិនិត្យសុខភាពជាទៀងទាត់ គឺជាចំណេញរបស់ថ្ងៃស្អែក។
                កុំរង់ចាំអោយមានបញ្ហា មុននឹងចាប់ផ្ដើមថែទាំខ្លួនឯង
              </p>
              <div class="gredient"></div>
            </div>
          </swiper-slide>
        </swiper>
      </div>
      <div
        class="col-12 col-lg-6 p-3 position-relative d-flex align-items-center justify-content-center h-100"
      >
        <div class="login-hos position-absolute top-0 start-0 my-4 mx-5">
          <RouterLink to="/" class="nav-logo">
            <img
              src="@/assets/images/auth/new.png"
              alt=""
              class="w-100 h-100 image-fluid"
            />
          </RouterLink>
        </div>
        <div class="login-form w-75">
          <div class="row d-flex align-items-center">
            <h2 class="text-center mb-2">ចូលប្រើប្រាស់</h2>
            <form class="px-4 pt-2">
              <div class="col-12">
                <div class="mb-3">
                  <label for="email" class="form-label">អាស័យដ្ឋានអ៊ីមែល</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="អាស័យដ្ធានអ៊ីមែល*"
                    v-model="store.loginfrm.email"
                    :class="{
                      'is-invalid': store.validation.vvlogin.email.$error,
                    }"
                  />
                  <div
                    class="invalid-feedback"
                    v-if="store.validation.vvlogin.email.$error"
                  >
                    {{ store.validation.vvlogin.email.$errors[0].$message }}
                  </div>
                  <!-- <div class="invalid-feedback invalidemail">
                    សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលដែលត្រឹមត្រូវ
                  </div> -->
                </div>
              </div>
              <div class="col-12">
                <div class="mb-3 position-relative">
                  <label for="password" class="form-label">ពាក្យសម្ងាត់</label>
                  <div>
                    <input
                      class="form-control"
                      placeholder="ពាក្យសម្ងាត់*"
                      v-model="store.loginfrm.password"
                      :class="{
                        'is-invalid': store.validation.vvlogin.password.$error,
                      }"
                      :type="isPasswordVisible ? 'text' : 'password'"
                      id="password"
                    />

                    <i
                      @click="togglePassword"
                      :class="iconClass"
                      class="position-absolute fs-6"
                      style="top: 41px; right: 10px; cursor: pointer"
                    ></i>

                    <div
                      class="invalid-feedback"
                      v-if="store.validation.vvlogin.password.$error"
                    >
                      {{
                        store.validation.vvlogin.password.$errors[0].$message
                      }}
                    </div>
                    <div class="invalid-feedback invalidemail d-none">
                      សូមបញ្ចូលពាក្យសម្ងាត់ដែលត្រឹមត្រូវ
                    </div>
                    <!-- <div class="invalid-feedback" v-if="invalideemail == 1">
                    </div> -->
                    <!-- <i class="bi bi-eye-slash"></i> -->
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <div class="d-flex justify-content-between">
                    <div>
                      <input
                        type="checkbox"
                        class="form-check-input bg-transparent border-2 shadow-none"
                        id="exampleCheck1"
                      />
                      <label class="form-check-label" for="exampleCheck1"
                        >ខ្ញុំបានអាននិងយល់ព្រមលើ
                        <RouterLink to="/policyPrivacy"
                          >គោលការណ៏េឯកជន</RouterLink
                        ></label
                      >
                    </div>
                    <RouterLink to="/forgetpassword"
                      >ភ្លេចពាក្យសម្ងាត់?</RouterLink
                    >
                  </div>
                </div>
              </div>
              <div class="col-12">
                <primaryBtn
                  :clickEvent="btnsubmit"
                  class="w-100 my-3 fw-medium"
                  label="ចូលប្រើប្រាស់"
                />
              </div>
              <div
                class="access d-flex justify-content-center align-items-center"
              >
                <span
                  >មានគណនីរួចហើយមែនទេ​?
                  <RouterLink to="/register">ចុះឈ្មោះបង្កើតគណនី </RouterLink>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <Toastfail />
  </main>

  <svg
    style="visibility: hidden; position: absolute"
    width="0"
    height="0"
    xmlns="http://www.w3.org/2000/svg"
    version="1.1"
  >
    <defs>
      <filter id="goo">
        <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur" />
        <feColorMatrix
          in="blur"
          mode="matrix"
          values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"
          result="goo"
        />
        <feComposite in="SourceGraphic" in2="goo" operator="atop" />
      </filter>
    </defs>
  </svg>
</template>

<script setup>
import { forgetpassword } from "@/stores/authstore";
import { computed, onMounted, ref } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import router from "@/router";
import axios from "axios";
import setAuthHeader from "@/stores/setAuthHeader";
import { useAuthStore } from "@/stores/authTokenStore";
import { userStore } from "@/stores/userStore";
import primaryBtn from "../primaryBtn.vue";
import Toastfail from "@/components/layouts/Toastfail.vue";
import loadingView from "../loading/loadingView.vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";

import "swiper/css/pagination";
import "swiper/css/navigation";

import { Navigation, Autoplay, Pagination } from "swiper/modules";
const modules = [Pagination, Autoplay];

const userstore = userStore();
let invalideemail = 0;

const store = forgetpassword();
const authStore = useAuthStore();

const pageLoading = ref(true);
onMounted(() => {
  setTimeout(() => {
    authStore.loadToken();
    if (authStore.token) {
      router.go(-1);
    }
    pageLoading.value = false;
  }, 1500);
});

const rules = computed(() => ({
  email: {
    required: helpers.withMessage(
      "សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលរបស់អ្នក",
      required
    ),
    email: helpers.withMessage("សូមបញ្ចូលអ៊ីមែលដែលមាន @ និង .com", email),
  },
  password: {
    required: helpers.withMessage("សូមបញ្ចូលពាក្យសម្ងាត់", required),
  },
}));

store.validation.vvlogin = useVuelidate(rules, store.loginfrm);

const isPasswordVisible = ref();

const togglePassword = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const iconClass = computed(() => {
  return isPasswordVisible.value ? "fa-light fa-eye" : "fa-light fa-eye-slash";
});
async function btnsubmit() {
  store.validation.vvlogin.$touch();
  if (store.validation.vvlogin.$invalid) {
    return;
  }

  const formdata = new FormData();
  formdata.append("email", store.loginfrm.email);
  formdata.append("password", store.loginfrm.password);

  try {
    const response = await axios.post("/api/auth/login", formdata, {});
    const token = response.data.token;
    const role_id = response.data.user.role_id;
    if (role_id == 3) {
      if (token) {
        authStore.setToken(token);
        store.loginfrm.email = "";
        store.loginfrm.password = "";
        store.onclearLoginfrm();
        router.push("/");
      }
    } else authStore.toastfail.show();
  } catch (error) {
    invalideemail = 1;
    authStore.toastfail.show();
    // console.error("Error:", error);
  }
}
</script>
