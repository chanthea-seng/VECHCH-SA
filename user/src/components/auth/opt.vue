<template>
  <div class="col-12 col-lg-4 p-5 shadow border-0 rounded-4">
    <div class="card bg-transparent border-0">
      <div class="sec-title text-center">
        <h3 class="fw-bold section-title">កំណត់ពាក្យសម្ងាត់</h3>
        <p class="text-gradient fs-6">
          យើງបានផ្ញើលេខកូដទៅកាន់ {{ state.forgetpassfrm.email }}
        </p>
      </div>
      <div class="mb-3 verify-code text-center" id="otp">
        <input
          v-for="(digit, index) in state.forgetpassfrm.otp"
          :key="index"
          type="text"
          class="input-otp"
          v-model="state.forgetpassfrm.otp[index]"
          @input="onInput(index, $event)"
          @keydown="onKeydown(index, $event)"
          maxlength="1"
          required
        />
        <div v-if="showError" class="invalid-feedback">
          {{ errorMessage }}
        </div>
      </div>

      <primaryBtn label="កំណត់ពាក្យសម្ងាត់" :click-event="onsubmit" />

      <div class="text-center mt-2">
        <p>
          មិនទទួលបានលេខកូដឬ?
          <a
            role="button"
            class="text-gradient"
            :class="{ 'disabled-link': isResendDisabled }"
            @click="BackToStep1"
            v-if="!isResendDisabled"
          >
            ផ្ញើរម្តងទៀត
          </a>
          <span v-else class="text-muted">({{ resendTimer }}s)</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { forgetpassword } from "@/stores/authstore";
import { useVuelidate } from "@vuelidate/core";
import { required, helpers } from "@vuelidate/validators";
import primaryBtn from "@/views/primaryBtn.vue";
import axios from "axios";
const state = forgetpassword();

const rules = {
  otp: {
    required: helpers.withMessage("សូមបញ្ចូល OTP!", required),
    minLength: helpers.withMessage(
      "OTP ត្រូវតែមាន ៤ ខ្ទង់!",
      (value) => value.length === 4
    ),
  },
};

const v$ = useVuelidate(rules, {
  otp: computed(() => state.forgetpassfrm.otp.join("")),
});

const showError = ref(false);
const errorMessage = ref("");

const onInput = (index, event) => {
  const value = event.target.value.slice(0, 1);
  state.forgetpassfrm.otp[index] = value;
  if (value && index < state.forgetpassfrm.otp.length - 1) {
    event.target.nextElementSibling?.focus();
  }

  showError.value = false;
};

const onKeydown = (index, event) => {
  if (
    event.key === "Backspace" &&
    !state.forgetpassfrm.otp[index] &&
    index > 0
  ) {
    event.target.previousElementSibling?.focus();
  }
  if (event.key === "e") {
    event.preventDefault();
  }
};

const onsubmit = async () => {
  const isValid = await v$.value.$validate();

  if (!isValid) {
    showError.value = true;
    errorMessage.value = v$.value.$errors[0].$message;
    return;
  }

  showError.value = false;

  //   const otp = state.forgetpassfrm.otp.join("");
  //   const email = state.forgetpassfrm.email;

  try {
    const frmData = new FormData();
    frmData.append("otp", state.forgetpassfrm.otp.join(""));
    frmData.append("email", state.forgetpassfrm.email);

    const response = await axios.post("/api/auth/verify-reset-code", frmData, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    console.log(response);
    // const response = await fetch('/api/auth/verify-reset-code', {
    //   method: 'POST',
    //   headers: {
    //     'Content-Type': 'application/json'
    //   },
    //   body: JSON.stringify({ otp, email })
    // });
    if (response.data.result != true) {
      throw new Error(data.message || "OTP verification failed");
    }

    if (state.getopt && state.resetnewpassword && state.forgetpass) {
      state.getopt.style.filter = "blur(1.5px)";
      state.getopt.style.left = "0%";
      state.resetnewpassword.style.left = "50%";
      state.resetnewpassword.style.filter = "blur(0px)";
      state.forgetpass.style.left = "-100%";
    }
  } catch (error) {
    showError.value = true;
    errorMessage.value = error.message;
    console.log(error);
  }
};
</script>

<style scoped>
.invalid-feedback {
  display: block;
  color: #dc3545;
  font-size: 0.875em;
  margin-top: 0.25rem;
}
</style>
