<template>
  <div class="col-12 col-lg-4 p-5 shadow border-0 rounded-4">
    <div class="card bg-transparent border-0 rounded-4">
      <div class="sec-title text-center">
        <h3 class="fw-bold section-title">កំណត់ពាក្យសម្ងាត់ថ្មី</h3>
        <p class="text-gradient fs-6">
          សូមបញ្ចូលពាក្យសម្ងាត់ថ្មីយ៉ាងហោចណាស់៨ខ្ធង់
        </p>
      </div>
      <div class="my-2 position-relative">
        <label for="password">ពាក្យសម្ងាត់ថ្មី</label>
        <input
          class="form-control rounded-3 w-100"
          placeholder="ពាក្យសម្ងាត់ថ្មី*"
          aria-label=""
          v-model="state.forgetpassfrm.newpass"
          :type="isPasswordVisible ? 'text' : 'password'"
          id="password"
          :class="{
            'is-invalid': state.validation.vvresetpassword.newpass.$error,
          }"
        />
        <i
          @click="togglePassword"
          :class="iconClass"
          class="position-absolute fs-6"
          style="top: 37px; right: 10px; cursor: pointer"
        ></i>
        <div
          class="invalid-feedback"
          v-if="state.validation.vvresetpassword.newpass.$error"
        >
          {{ state.validation.vvresetpassword.newpass.$errors[0].$message }}
        </div>
      </div>
      <div class="my-2 position-relative mb-3">
        <label for="newpassword">ពាក្យសម្ងាត់ថ្មី</label>
        <input
          class="form-control rounded-3 w-100"
          id="newpassword"
          :type="isPasswordChecked ? 'text' : 'password'"
          placeholder="ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់ថ្មី*"
          aria-label=""
          v-model="state.forgetpassfrm.confirm_newpass"
          :class="{
            'is-invalid':
              state.validation.vvresetpassword.confirm_newpass.$error,
          }"
        />
        <i
          @click="toggleConfirmPassword"
          :class="confirmIconClass"
          class="position-absolute fs-6"
          style="top: 37px; right: 10px; cursor: pointer"
        ></i>
        <div
          class="invalid-feedback"
          v-if="state.validation.vvresetpassword.confirm_newpass.$error"
        >
          {{
            state.validation.vvresetpassword.confirm_newpass.$errors[0].$message
          }}
        </div>
      </div>
      <primaryBtn label="កំណត់ពាក្យសម្ងាត់" :click-event="onsubmit" />
    </div>
  </div>
</template>
<script setup>
import { computed, ref } from "vue";
import primaryBtn from "@/views/primaryBtn.vue";
import router from "@/router";
import { forgetpassword } from "@/stores/authstore";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import axios from "axios";
const state = forgetpassword();

const rules = computed(() => ({
  newpass: {
    required: helpers.withMessage("Please enter your password", required),
  },
  confirm_newpass: {
    required: helpers.withMessage("Please enter your password", required),
  },
}));

state.validation.vvresetpassword = useVuelidate(rules, state.forgetpassfrm);

const onsubmit = async () => {
  state.validation.vvresetpassword.$touch();

  if (state.validation.vvresetpassword.$invalid) {
    return;
  }
  const payload = {
    email: state.forgetpassfrm.email,
    otp: state.forgetpassfrm.otp.join(""),
    newpass: state.forgetpassfrm.newpass,
    newpass_confirmation: state.forgetpassfrm.confirm_newpass,
  };
  //   for (let key in payload) {
  //     console.log(`Key: ${key}, Value: ${payload[key]}`);
  //   }
  try {
    const response = await axios.post("/api/auth/reset-password", payload, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    // console.log(response.data);
    state.clearForgetPassForm();
    router.push("/login");
  } catch (error) {
    console.error(error);
  }
};

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
</script>
