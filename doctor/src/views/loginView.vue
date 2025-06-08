<template>
  <main class="login-page">
    <div class="container-fluid px-5">
      <div class="row align-items-center vh-100">
        <div class="col-md-6 col-sm-12 px-5 pb-5">
          <div class="card border-0 bg-transparent pb-5">
            <div class="pt-5 d-flex justify-content-between align-items-center">
              <RouterLink to="/" class="nav-logo mb-5">
                <img
                  src="/src/assets/image/logo-vcs.png"
                  alt=""
                  class="w-100 h-100 image-fluid"
                />
              </RouterLink>
            </div>

            <form class="login-form" @submit.prevent>
              <div class="row d-flex align-items-center pe-5">
                <h2 class="text-center fw-medium text-color-700 mb-4">
                  សូមស្វាគមន៍វេជ្ជបណ្ឌិត
                </h2>

                <div class="ps-4 pe-5">
                  <!-- Email Input -->
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="email" class="form-label"
                        >អាស័យដ្ឋានអ៊ីមែល</label
                      >
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="អាស័យដ្ធានអ៊ីមែល*"
                        v-model="authStore.loginfrm.email"
                        @blur="authStore.validation.email.$touch()"
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

                  <!-- Password Input -->
                  <div class="col-12">
                    <div class="mb-3 position-relative">
                      <label for="password" class="form-label"
                        >ពាក្យសម្ងាត់</label
                      >
                      <div>
                        <input
                          class="form-control"
                          placeholder="ពាក្យសម្ងាត់*"
                          v-model="authStore.loginfrm.password"
                          @blur="authStore.validation.password.$touch()"
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

                  <!-- Login Button -->
                  <div class="col-12">
                    <span
                      >ក្នុងករណីដែលអ្នកភ្លេចគណនី សូមទាក់ទងទៅអ្នកគ្រប់គ្រង</span
                    >
                    <primaryBtn
                      :clickEvent="btnsubmit"
                      :disabled="isLoading"
                      class="w-100 my-3 fw-medium"
                      label="ចូលប្រើប្រាស់"
                    />
                  </div>

                  <!-- Error Message -->
                  <p v-if="loginError" class="text-danger text-center">
                    {{ loginError }}
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Right Side - Info Box -->
        <div class="col-md-6 col-sm-12">
          <div class="card border-0">
            <div class="login-hos-img">
              <div class="hos-img-box position-relative">
                <div
                  class="login-hos-pos p-4 position-absolute d-flex justify-content-center align-items-center"
                >
                  <p class="m-0">
                    "ការយកចិត្តទុកដាក់ចំពោះអ្នកណាម្នាក់ឱ្យបានគ្រប់គ្រាន់ដើម្បីធ្វើឱ្យបញ្ហារបស់ពួកគេដោយខ្លួនឯង
                    គឺជាការចាប់ផ្តើមនៃការអភិវឌ្ឍន៍សីលធម៌ពិតប្រាកដរបស់មនុស្សម្នាក់"
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
</template>

<script setup>
import { computed, ref, onMounted } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import router from "@/router";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import primaryBtn from "@/components/global/primaryBtn.vue";
import { useNotyfStore } from "@/stores/notfyStore";
const authStore = useAuthStore();
const notfy = useNotyfStore();

onMounted(async () => {
  if (await authStore.checkIfDoctor()) {
    router.push("/dashboard");
  }
});

const rules = computed(() => ({
  email: {
    required: helpers.withMessage("Please enter your email address", required),
    email: helpers.withMessage("Please enter a valid email address!", email),
  },
  password: {
    required: helpers.withMessage("Please enter your password", required),
  },
}));

const loginError = ref();
const isLoading = ref();

authStore.validation = useVuelidate(rules, authStore.loginfrm);

const isPasswordVisible = ref(false);
const togglePassword = () => {
  isPasswordVisible.value = !isPasswordVisible.value;
};

const iconClass = computed(() => {
  return isPasswordVisible.value ? "fa-solid fa-eye" : "fa-solid fa-eye-slash";
});

async function btnsubmit() {
  authStore.validation.$touch();
  if (authStore.validation.$invalid) {
    return;
  }

  loginError.value = null;
  isLoading.value = true;

  const formData = {
    email: authStore.loginfrm.email,
    password: authStore.loginfrm.password,
  };

  try {
    const response = await axios.post("/api/auth/login", formData, {});
    const role = response.data.user.role_id;
    if (role == 2) {
      const token = response.data.token;
      if (token) {
        authStore.setToken(token);
        authStore.loginfrm.email = "";
        authStore.loginfrm.password = "";
        router.push("/dashboard");
        notfy.success("សូមស្វាគមន៍មកកាន់ផ្ទាំងគ្រប់គ្រង");
      }
    } else {
      notfy.error("អាចប្រើបានសម្រាប់តែវេជ្ជបណ្ឌិតប៉ុណ្ណោះ");
    }
  } catch (error) {
    console.error(error);

    if (error.response) {
      //   console.error("Server Error:", error.response.data);
      loginError.value = "សូមពិនិត្យមើលអ៊ីមែល ឬពាក្យសម្ងាត់របស់អ្នកម្តងទៀត.";
    } else {
      loginError.value = "Network error. Please try again.";
    }
  } finally {
    isLoading.value = false;
  }
}
</script>
