<template>
  <main class="login-page">
    <div class="container-fluid px-5">
      <div class="row align-items-center vh-100">
        <div class="col-md-6 col-sm-12 px-5 pb-5">
          <div class="card border-0 bg-transparent pb-5">
            <div class="pt-5 d-flex justify-content-between align-items-center">
              <RouterLink to="/" class="nav-logo mb-5">
                <img
                  src="/src/assets/img/logo-vcs.png"
                  alt=""
                  class="w-100 h-100 image-fluid"
                />
              </RouterLink>
            </div>
            <form class="login-form" @submit.prevent>
              <div class="row d-flex align-items-center pe-5">
                <h2 class="text-center fw-semibold text-color-700 mb-4">
                  Welcome to login page, Admin
                </h2>
                <div class="ps-4 pe-5">
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Enter email*"
                        v-model="authStore.loginfrm.email"
                        :class="{
                          'is-invalid': authStore.validation.email.$error,
                        }"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="authStore.validation.email.$error"
                      >
                        {{ authStore.validation.email.$errors[0].$message }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3 position-relative">
                      <label for="password" class="form-label">Password</label>
                      <div>
                        <input
                          class="form-control"
                          placeholder="Enter password*"
                          v-model="authStore.loginfrm.password"
                          :class="{
                            'is-invalid': authStore.validation.password.$error,
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
                          v-if="authStore.validation.password.$error"
                        >
                          {{
                            authStore.validation.password.$errors[0].$message
                          }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <primaryBtn
                      :clickEvent="btnsubmit"
                      class="w-100 my-3 fw-medium"
                      label="Login"
                    />
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="card border-0">
            <div class="login-hos-img">
              <div class="hos-img-box position-relative">
                <div
                  class="login-hos-pos p-4 position-absolute d-flex justify-content-center align-items-center"
                >
                  <p class="m-0">
                    "To care for anyone else enough to make their problems one's
                    own is ever the beginning of one's real ethical
                    development."
                    <br />
                    <span class="d-inline-block mt-2"> — Felix Adler </span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
import { computed, onMounted, ref } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import router from "@/router";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import primaryBtn from "@/components/layouts/primaryBtn.vue";
import { useNotyfStore } from "@/stores/notyfStore";
const authStore = useAuthStore();

onMounted(async () => {
  if (await authStore.checkIfAdmin()) {
    router.push("/dashboard");
  }
});
const notfy = useNotyfStore();
const rules = computed(() => ({
  email: {
    required: helpers.withMessage("Please enter your email address", required),
    email: helpers.withMessage("'Please enter a valid email address!", email),
  },
  password: {
    required: helpers.withMessage("Please enter your password", required),
  },
}));

authStore.validation = useVuelidate(rules, authStore.loginfrm);

const isPasswordVisible = ref();

const togglePassword = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const iconClass = computed(() => {
  return isPasswordVisible.value ? "fa-light fa-eye" : "fa-light fa-eye-slash";
});
async function btnsubmit() {
  authStore.validation.$touch();
  if (authStore.validation.$invalid) {
    return;
  }

  const formdata = new FormData();
  formdata.append("email", authStore.loginfrm.email);
  formdata.append("password", authStore.loginfrm.password);

  try {
    const response = await axios.post("/api/auth/login", formdata, {});
    const role = response.data.user.role_id;
    if (role == 1) {
      const token = response.data.token;
      if (token) {
        authStore.setToken(token);
        authStore.onclearLoginfrm();
        notfy.success("Welcome Admin");
        router.push("/dashboard");
      }
    } else {
      notfy.error("Avaliable Only For Admin");
    }
  } catch (error) {
    // notfy.error(error);
    notfy.error("Wrong Email or Password");
  }
}
</script>
