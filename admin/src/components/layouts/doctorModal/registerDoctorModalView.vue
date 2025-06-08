<template>
  <!-- Modal Register Doctor -->
  <div class="doctor-modal">
    <div
      class="modal fade"
      id="registerDoctorModal"
      tabindex="-1"
      aria-labelledby="registerDoctorModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
          <div class="modal-body">
            <div class="register-doctor-contant">
              <div class="d-flex justify-content-between">
                <div>
                  <h4 class="fw-bold text-color-800 m-0 mb-2">
                    Register Doctor Account
                  </h4>
                  <p class="m-0 mb-4">
                    Input information for register account.
                  </p>
                </div>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                  @click="store.onClearRegisterfrm()"
                ></button>
              </div>
              <form class="form-group">
                <div class="row mb-5">
                  <div class="col-6">
                    <div class="mb-3">
                      <label for="firstname" class="form-label"
                        >full Name in English</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="firstname"
                        placeholder="Name*"
                        v-model="store.registerfrm.fullname"
                        :class="{
                          'is-invalid':
                            store.validation.vvregister.fullname.$error,
                        }"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="store.validation.vvregister.fullname.$error"
                      >
                        {{
                          store.validation.vvregister.fullname.$errors[0]
                            .$message
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label for="firstname" class="form-label"
                        >full Name in Local</label
                      >
                      <input
                        type="text"
                        class="form-control"
                        id="firstname"
                        placeholder="Name*"
                        v-model="store.registerfrm.local_fullname"
                        :class="{
                          'is-invalid':
                            store.validation.vvregister.local_fullname.$error,
                        }"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="store.validation.vvregister.local_fullname.$error"
                      >
                        {{
                          store.validation.vvregister.local_fullname.$errors[0]
                            .$message
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="email" class="form-label">Email</label>
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Email*"
                        v-model="store.registerfrm.email"
                        :class="{
                          'is-invalid':
                            store.validation.vvregister.email.$error,
                        }"
                      />
                      <div
                        class="invalid-feedback"
                        v-if="store.validation.vvregister.email.$error"
                      >
                        {{
                          store.validation.vvregister.email.$errors[0].$message
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="d-flex">
                    <div class="col-6 pe-2">
                      <div class="mb-3 position-relative">
                        <label for="password" class="form-label"
                          >Password</label
                        >
                        <input
                          class="form-control"
                          :type="isPasswordVisible ? 'text' : 'password'"
                          id="password"
                          placeholder="Password*"
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
                            store.validation.vvregister.password.$errors[0]
                              .$message
                          }}
                        </div>
                      </div>
                    </div>
                    <div class="col-6 ps-2">
                      <div class="mb-3 position-relative">
                        <label for="confirmpassword" class="form-label"
                          >Confirm Password</label
                        >
                        <input
                          class="form-control"
                          :type="isPasswordChecked ? 'text' : 'password'"
                          id="confirmpassword"
                          placeholder="password*"
                          v-model="store.registerfrm.confirm_password"
                          :class="{
                            'is-invalid':
                              store.validation.vvregister.confirm_password
                                .$error,
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
                          v-if="
                            store.validation.vvregister.confirm_password.$error
                          "
                        >
                          {{
                            store.validation.vvregister.confirm_password
                              .$errors[0].$message
                          }}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-6 mb-3">
                    <label
                      for="firstname"
                      class="fw-semibold mb-2 text-color-900"
                      >First Name<span class="text-danger">*</span></label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="firstName"
                      placeholder=""
                    />
                  </div>
                  <div class="col-6 mb-3">
                    <label
                      for="lastname"
                      class="fw-semibold mb-2 text-color-900"
                      >Last Name<span class="text-danger">*</span></label
                    >
                    <input
                      type="text"
                      class="form-control"
                      id="lastName"
                      placeholder="Last Name"
                    />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email" class="fw-semibold mb-2 text-color-900"
                      >Email<span class="text-danger">*</span></label
                    >
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      placeholder="example@gmail.com"
                    />
                  </div>
                  <div class="col-6 mb-3">
                    <div class="form-group">
                      <label
                        for="gender"
                        class="fw-semibold mb-2 text-color-900"
                        >Gender<span class="text-danger">*</span></label
                      >
                      <div>
                        <div class="form-check form-check-inline me-4">
                          <input
                            type="radio"
                            class="form-check-input"
                            id="male"
                            name="gender"
                            value="male"
                          />
                          <label class="form-check-label" for="male"
                            >Male</label
                          >
                        </div>
                        <div class="form-check form-check-inline">
                          <input
                            type="radio"
                            class="form-check-input"
                            id="female"
                            name="gender"
                            value="female"
                          />
                          <label class="form-check-label" for="female"
                            >Female</label
                          >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <label
                      for="password"
                      class="fw-semibold mb-2 text-color-900"
                      >Password<span class="text-danger">*</span></label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      placeholder="Password"
                    />
                  </div>
                  <div class="col-6 mb-3">
                    <label
                      for="confirmPassword"
                      class="fw-semibold mb-2 text-color-900"
                      >Confirm Password<span class="text-danger">*</span></label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="confirmPassword"
                      placeholder="Confirm Password"
                    />
                  </div> -->
                </div>
                <h6 class="text-color-600 mb-4">
                  <i class="bi bi-info-circle"></i> Make sure note is properly
                  and give a account to individual.
                </h6>
                <div class="d-flex justify-content-end">
                  <primaryBtn label="Register" :click-event="btnSubmit" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Register Success -->
  <registerSuccessModalView />
</template>

<script setup>
import { computed, ref } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import axios from "axios";
import router from "@/router";
import primaryBtn from "../primaryBtn.vue";

import RegisterSuccessModalView from "@/components/layouts/doctorModal/registerSuccessModalView.vue";
import { doctorStore } from "@/stores/doctorStore";
import { useAuthStore } from "@/stores/userAuthStore";
import { registerStore } from "@/stores/registerStore";
import { Modal } from "bootstrap";
import { onMounted } from "vue";
const useDoctorStore = doctorStore();
const authStore = useAuthStore();
onMounted(() => {
  useDoctorStore.mdlRegister = Modal.getOrCreateInstance(
    document.getElementById("registerDoctorModal")
  );
});

const store = registerStore();
const nameRegex = /^[\p{L}\s]+$/u;

const alphaOnly = (value) => nameRegex.test(value);

const rules = computed(() => ({
  fullname: {
    required: helpers.withMessage("Please enter fullname", required),
    alphaOnly: helpers.withMessage("Only letter", alphaOnly),
  },
  local_fullname: {
    required: helpers.withMessage("Please enter fullname", required),
    // alphaOnly: helpers.withMessage("Only khmer letter", alphaOnly),
  },
  email: {
    required: helpers.withMessage("Please Enter Email!", required),
    email: helpers.withMessage("Email must contain @ and .com", email),
  },
  password: {
    required: helpers.withMessage("Please Enter Password", required),
  },
  confirm_password: {
    required: helpers.withMessage("Please Enter Confirm Password", required),
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
  formdata.append("local_fullname", store.registerfrm.local_fullname);
  formdata.append("email", store.registerfrm.email);
  formdata.append("password", store.registerfrm.password);
  formdata.append("password_confirmation", store.registerfrm.confirm_password);

  try {
    authStore.loadToken();
    const response = await axios.post("/api/doctor/admin", formdata, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        "Content-Type": "multipart/form-data",
      },
    });
    store.selectId = response.data.user.id;
    console.log(response.data.user);
    console.log("Response:", response.data.user.id);
    useDoctorStore.getDoctor();
    useDoctorStore.mdlRegister.hide();
    useDoctorStore.mdlDSuccess.show();
    store.onClearRegisterfrm();
  } catch (error) {
    console.error("Error:", error);
  }
}
</script>
