<template>
  <section class="end-booking m-0" style="padding-block: 100px">
    <div class="container py-5">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="col-12 col-lg-8">
          <div class="icon-img d-flex justify-content-center notification">
            <div class="loader"></div>

            <!-- <img src="/src//assets/img/icon/waiticon.jpg" alt="" /> -->
          </div>
          <div class="sec-title text-center">
            <h3 class="text-color-800">ពួកយើងបានទទួលសំណើររបស់លោកអ្នក</h3>
            <p class="text-muted">
              ក្រុមការងារយើងនឹងធ្វើការបញ្ជាក់ការណាត់ជួបរបស់លោកអ្នកក្នុងរយៈពេល 24
              ម៉ោង
            </p>
            <div class="mt-4">
              <RouterLink
                to="/"
                class="btn-bg-650 w-50"
                @click="resetBookingData()"
                >ត្រឡប់ទៅទំព័រដើម</RouterLink
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { appointment } from "@/stores/bookingstore";
const selete = appointment();
const resetBookingData = () => {
  selete.bookingfrm = {
    name: "",
    local_name: "",
    dob: "",
    gender: "",
    phone_number: "",
    email: "",
    description: "",
    appointment_time: "",
    doctor_id: null,
  };
  selete.service_type = null;
  selete.setConsultOption();
  selete.sub_service_id = null;
  selete.patient = [];
  selete.showhistory = false;
  selete.bookingHistory = [];
  calender.selectedDate = "";
  calender.selectedTime = "";

  selete.fileShow = {
    filename: null,
    paymentFile: null,
  };
};
</script>
