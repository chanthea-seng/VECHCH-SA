<template>
  <!-- Modal Register Success -->
  <div
    class="modal fade"
    id="registerSuccessModal"
    tabindex="-1"
    aria-labelledby="registerSuccessModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="register-success text-center p-3">
            <div class="col-4 m-auto">
              <img
                src="@/assets/img/success.gif"
                class="img-fluid rounded"
                alt=""
              />
            </div>
            <h4 class="fw-semibold text-gradient my-4">
              Registration Successful
            </h4>
            <p class="mb-5 text-center">
              Would you like to edit account for doctor?
            </p>
            <div class="d-flex column-gap-3 justify-content-center">
              <a role="button" class="pending-btn" data-bs-dismiss="modal">
                Complete
              </a>
              <primaryBtn
                label="Check Profile"
                :click-event="onClickToProfile"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { doctorStore } from "@/stores/doctorStore";
import { registerStore } from "@/stores/registerStore";
import { Modal } from "bootstrap";
import { onMounted } from "vue";
import primaryBtn from "../primaryBtn.vue";
import router from "@/router";
const useDoctorStore = doctorStore();
const useRegisterStore = registerStore();
onMounted(() => {
  useDoctorStore.mdlDSuccess = Modal.getOrCreateInstance(
    document.getElementById("registerSuccessModal")
  );
});
const onClickToProfile = () => {
  sessionStorage.setItem("selectId", useRegisterStore.selectId);
  if (useRegisterStore.selectId) {
    useDoctorStore.mdlDSuccess.hide();
    router.push("/doctor-profile");
  }
};
</script>
