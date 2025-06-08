<template>
  <main class="register-page login-page">
    <loadingView v-if="pageLoading" />

    <div class="row g-0 position-relative vh-100">
      <div class="col-6 end-0 position-absolute top-0">
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
        class="col-12 col-lg-6 p-3 position-relative d-flex align-items-center justify-content-center vh-100"
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
        <div class="login-form w-75 mt-5">
          <form class="row d-flex needs-validation" novalidate>
            <h2 class="text-center mb-2">ចុះឈ្មោះបង្កើតគណនី</h2>
            <div class="px-4 pt-2">
              <div class="col-12">
                <div class="mb-3">
                  <label for="firstname" class="form-label">ឈ្មោះពេញ</label>
                  <input
                    type="text"
                    class="form-control form-control"
                    id="firstname"
                    placeholder="ឈ្មោះពេញ*"
                    v-model="store.registerfrm.fullname"
                    :class="{
                      'is-invalid': store.validation.vvregister.fullname.$error,
                    }"
                  />
                  <div
                    class="invalid-feedback"
                    v-if="store.validation.vvregister.fullname.$error"
                  >
                    {{
                      store.validation.vvregister.fullname.$errors[0].$message
                    }}
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="mb-3">
                  <label for="email" class="form-label">អាស័យដ្ឋានអ៊ីមែល</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="អាស័យដ្ធានអ៊ីមែល*"
                    v-model="store.registerfrm.email"
                    :class="{
                      'is-invalid': store.validation.vvregister.email.$error,
                    }"
                  />
                  <div
                    class="invalid-feedback"
                    v-if="store.validation.vvregister.email.$error"
                  >
                    {{ store.validation.vvregister.email.$errors[0].$message }}
                  </div>
                </div>
              </div>
              <div class="d-flex">
                <div class="col-6 pe-2">
                  <div class="mb-3 position-relative">
                    <label for="password" class="form-label"
                      >ពាក្យសម្ងាត់</label
                    >
                    <input
                      class="form-control"
                      :type="isPasswordVisible ? 'text' : 'password'"
                      id="password"
                      placeholder="ពាក្យសម្ងាត់*"
                      v-model="store.registerfrm.password"
                      :class="{
                        'is-invalid':
                          store.validation.vvregister.password.$error,
                      }"
                    />
                    <i
                      @click="togglePassword"
                      :class="iconClass"
                      class="position-absolute fs-6"
                      style="top: 41px; right: 10px; cursor: pointer"
                    ></i>
                    <div
                      class="invalid-feedback"
                      v-if="store.validation.vvregister.password.$error"
                    >
                      {{
                        store.validation.vvregister.password.$errors[0].$message
                      }}
                    </div>
                  </div>
                </div>
                <div class="col-6 ps-2">
                  <div class="mb-3 position-relative">
                    <label for="confirmpassword" class="form-label"
                      >ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់</label
                    >
                    <input
                      class="form-control"
                      :type="isPasswordChecked ? 'text' : 'password'"
                      id="confirmpassword"
                      placeholder="ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់*"
                      v-model="store.registerfrm.confirm_password"
                      :class="{
                        'is-invalid':
                          store.validation.vvregister.confirm_password.$error,
                      }"
                    />
                    <i
                      @click="toggleConfirmPassword"
                      :class="confirmIconClass"
                      class="position-absolute fs-6"
                      style="top: 41px; right: 10px; cursor: pointer"
                    ></i>
                    <div
                      class="invalid-feedback"
                      v-if="store.validation.vvregister.confirm_password.$error"
                    >
                      {{
                        store.validation.vvregister.confirm_password.$errors[0]
                          .$message
                      }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-check">
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
              </div>
              <div class="col-12">
                <primaryBtn
                  :clickEvent="btnSubmit"
                  class="btn-register w-100 fw-medium my-3"
                  label="ចុះឈ្មោះ"
                />
              </div>
              <div
                class="access d-flex justify-content-center align-items-center"
              >
                <span class="form-check-label fs-6"
                  >មានគណនីរួចហើយមែនទេ​?
                  <RouterLink to="/login">ចូលប្រើប្រាស់</RouterLink>
                </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Toastfail />
    <ToastSuccsess />
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
import {
  required,
  helpers,
  email,
  minLength,
  sameAs,
} from "@vuelidate/validators";
import axios from "axios";
import primaryBtn from "../primaryBtn.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import Toastfail from "@/components/layouts/Toastfail.vue";
import ToastSuccsess from "@/components/layouts/ToastSuccsess.vue";
import loadingView from "../loading/loadingView.vue";

import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { useAuthStore } from "@/stores/authTokenStore";

import { Navigation, Autoplay, Pagination } from "swiper/modules";
const modules = [Autoplay, Pagination];
import router from "@/router";

const store = forgetpassword();
const authStore = useAuthStore();
const nameRegex = /^[\p{L}\s]+$/u;

const alphaOnly = (value) => nameRegex.test(value);
const verifypassword = computed(() => store.registerfrm.password);

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
  fullname: {
    required: helpers.withMessage("សូមបញ្ចូលឈ្មោះរបស់អ្នក", required),
    alphaOnly: helpers.withMessage("ឈ្មោះត្រូវមានតែអក្សរប៉ុណ្ណោះ", alphaOnly),
  },
  // last_name: {
  //     required: helpers.withMessage("Please enter your last name", required)
  // },
  email: {
    required: helpers.withMessage(
      "សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលរបស់អ្នក!",
      required
    ),
    email: helpers.withMessage("សូមបញ្ចូលអ៊ីមែលដែលមាន @ និង .com", email),
  },
  password: {
    required: helpers.withMessage("សូមបញ្ចូលពាក្យសម្ងាត់", required),
    minLength: helpers.withMessage(
      "ពាក្យសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 8 តួអក្សរ",
      minLength(8)
    ),
  },
  confirm_password: {
    required: helpers.withMessage("សូមបញ្ចូលផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់", required),
    sameAs: helpers.withMessage(
      "ពាក្យសម្ងាត់មិនដូចគ្នាទៅនឹងការផ្ទៀងផ្ទាត់",
      sameAs(verifypassword)
    ),
  },
}));

store.validation.vvregister = useVuelidate(rules, store.registerfrm);

const isPasswordVisible = ref(false);
const isPasswordChecked = ref(false);

const togglePassword = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const toggleConfirmPassword = () => {
  isPasswordChecked.value = !isPasswordChecked.value;
};

const iconClass = computed(() => {
  return isPasswordVisible.value ? "fa-light fa-eye" : "fa-light fa-eye-slash";
});
const confirmIconClass = computed(() => {
  return isPasswordChecked.value ? "fa-light fa-eye" : "fa-light fa-eye-slash";
});

async function btnSubmit() {
  store.validation.vvregister.$touch();
  if (store.validation.vvregister.$invalid) {
    return;
  }

  const formdata = new FormData();

  formdata.append("fullname", store.registerfrm.fullname);
  formdata.append("email", store.registerfrm.email);
  formdata.append("password", store.registerfrm.password);
  formdata.append("password_confirmation", store.registerfrm.confirm_password);

  try {
    const response = await axios.post("/api/auth/register", formdata, {});
    await store.onClearRegisterfrm();

    router.push("/login");
  } catch (error) {
    document.getElementById("titletoast").innerHTML =
      "ចុះឈ្មោះបង្កើតគណនី បរាជ័យ";
    document.getElementById("subtitletoast").innerHTML =
      "អាស័យដ្ឋានអ៊ីមែលត្រូវបានគេប្រើប្រាស់រួចហើយ សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលផ្សេងទៀត";
    authStore.toastfail.show();
    // console.error("Error:", error);
  }
}

// const clearRegisterfrm = () => {
//     store.registerfrm.fullname.value = '';
//     store.registerfrm.email.value = '';
//     store.registerfrm.password.value = '';
//     store.registerfrm.confirm_password.value = '';
//     if(this.validation.vvregister)
//             {
//                this.validation.vvregister.$reset();

//             }
// }
</script>
