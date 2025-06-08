<template>
  <div
    class="modal mdl-logout fade"
    id="mdl-cancelappoint"
    tabindex="-1"
    aria-labelledby="mdl-cancelappointLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header d-flex text-center border-0 pt-4 px-4 pb-0"
        ></div>
        <div class="modal-body mt-0 p-4 pt-0">
          <div class="wrapper text-center my-3">
            <p class="mb-1 text-center fw-medium text-color-1000">
              លុបចោលការណាត់ជួប
            </p>
            <span> តើអ្នកប្រាកដទេថា​ ចង់លុបចោលការណាត់ជួបរបស់អ្នក? </span>
          </div>
          <div class="mx-auto text-center">
            <a
              role="button"
              class="btn-bg-650 btn-delete mb-0 mt-0 me-3"
              data-bs-dismiss="modal"
              >ទេ</a
            >
            <a
              role="button"
              @click="onCancelAppointment()"
              class="btn-bg-650 btn-logout mb-0 px-3"
            >
              បាទ/ ចាស់
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Modal } from "bootstrap";
import { appointmentStore } from "@/stores/appointmentstore";
import { onMounted, registerRuntimeCompiler } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/authTokenStore";
import { useRoute } from "vue-router";
import router from "@/router";
const appointment = appointmentStore();
const authStore = useAuthStore();
const Route = useRoute();
const currentRouteName = Route.name;
onMounted(async () => {
  authStore.loadToken();
  appointment.mdl_cancelappoint = Modal.getOrCreateInstance(
    document.getElementById("mdl-cancelappoint")
  );
});

const onCancelAppointment = async () => {
  try {
    const res = await axios.put(
      `api/bookings/statuscancel/${appointment.selected_id}`,
      {},
      {
        headers: {
          Authorization: "Bearer " + authStore.token,
        },
      }
    );
    appointment.selected_id = null;
    appointment.mdl_cancelappoint.hide();
    await appointment.fetchAppointments();

    if (currentRouteName === "invoice") {
      router.push("/");
      sessionStorage.clear();
      return;
    }
    await appointment.fetchAllAppointment();
  } catch (error) {
    // console.log('cancel booking fail',error);
  }
};
</script>
