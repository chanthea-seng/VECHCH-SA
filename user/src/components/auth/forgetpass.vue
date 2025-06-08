<template>
  <div class="col-12 col-lg-4 p-5 shadow border-0 rounded-4">
    <div class="card bg-transparent border-0">
      <div class="sec-title text-center">
        <h3 class="fw-bold section-title">ភ្លេចពាក្យសម្ងាត់</h3>
        <p class="text-gradient" style="font-size: 15px">
          សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលដើម្បីកំណត់ពាក្យសម្ងាត់ឡើងវិញ
        </p>
      </div>
      <div class="mb-3">
        <input
          class="form-control rounded-3"
          id=""
          type="email"
          placeholder="អាស័យដ្ឋានអ៊ីម៉ែល*"
          aria-label=""
          v-model="state.forgetpassfrm.email"
          :class="{ 'is-invalid': state.validation.vvforgetpass.email.$error }"
        />
        <div
          class="invalid-feedback"
          v-if="state.validation.vvforgetpass.email.$error"
        >
          {{ state.validation.vvforgetpass.email.$errors[0].$message }}
        </div>
      </div>
      <primaryBtn label="កំណត់ពាក្យសម្ងាត់" :click-event="onsubmit" />
      <!-- 
      <button type="button" class="btn btn-global" @click="onsubmit()">
        កំណត់ពាក្យសម្ងាត់
      </button> -->
      <p class="mt-3">
        ប្រសិនបើអ្នកចងចាំពាក្យសម្ងាត់របស់អ្នក
        <a role="button" class="text-gradient" @click="backToLog()"
          >ចុចនៅទីនេះ</a
        >
      </p>
    </div>
  </div>
</template>
<script setup>
import { forgetpassword } from "@/stores/authstore";
import primaryBtn from "@/views/primaryBtn.vue";
import { computed } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers, email } from "@vuelidate/validators";
import router from "@/router";
import axios from "axios";

const state = forgetpassword();

const rules = computed(() => ({
  email: {
    required: helpers.withMessage("Please enter your email address!", required),
    email: helpers.withMessage("'Please enter a valid email address!", email),
  },
}));

state.validation.vvforgetpass = useVuelidate(rules, state.forgetpassfrm);

const onsubmit = async () => {
  state.validation.vvforgetpass.$touch();

  if (state.validation.vvforgetpass.$invalid) {
    return;
  }

  try {
    const frmData = new FormData();
    frmData.append("email", state.forgetpassfrm.email);

    const response = await axios.post("/api/auth/forgot-password", frmData, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    console.log(response);
    state.forgetpass.style.filter = "blur(1.5px)";
    state.resetnewpassword.style.filter = "blur(1.5px)";
    state.getopt.style.filter = "blur(0px)";
    state.forgetpass.style.left = "0%";
    state.getopt.style.left = "50%";
    state.resetnewpassword.style.left = "100%";
    if (!response.ok) {
      throw new Error("Failed to send password reset request");
    }
    console.log(response);

    const data = await response.json();
  } catch (error) {}
};

const backToLog = () => {
  router.push({ name: "login" });
};
</script>
