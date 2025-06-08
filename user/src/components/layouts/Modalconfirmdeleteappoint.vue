<template>
  <div
    class="modal mdl-logout fade"
    id="mdl-deleteappoint"
    tabindex="-1"
    aria-labelledby="mdl-deleteappointLabel"
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
              តើអ្នកប្រាកដថាចង់លុបចោលការណាត់ជួប
            </p>
            <span
              >ប្រសិនបើអ្នកចង់លុបព័ត៌មានការណាត់ជួបរបស់អ្នក ទិន្នន័យ
              ព័ត៌មានទាំងអស់របស់អ្នកនិងត្រូវលុបជាអចិន្ត្រៃយ៌</span
            >
          </div>
          <div class="mx-auto text-center">
            <a
              role="button"
              class="btn-bg-650 btn-delete mb-0 mt-0 me-3"
              data-bs-dismiss="modal"
              >បោះបង់</a
            >
            <a
              role="button"
              @click="onDeleteAppointment"
              class="btn-bg-650 btn-logout mb-0 px-3"
            >
              លុបចោល
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Modal } from "bootstrap";
import { onMounted } from "vue";
import { appointmentStore } from "@/stores/appointmentstore";
import { useAuthStore } from "@/stores/authTokenStore";
import axios from "axios";

const appointment = appointmentStore();
const authStore = useAuthStore();
onMounted(async () => {
  appointment.mdl_deleteappoint = Modal.getOrCreateInstance(
    document.getElementById("mdl-deleteappoint")
  );
  await authStore.loadToken();
});

const onDeleteAppointment = async () => {
  const res = await axios.put(
    `api/bookings/remove/${appointment.appointmentdetail.id}`,
    {},
    {
      headers: {
        Authorization: "Bearer " + authStore.token,
      },
    }
  );
  await appointment.fetchAppointments();
  appointment.mdl_deleteappoint.hide();
};
</script>
