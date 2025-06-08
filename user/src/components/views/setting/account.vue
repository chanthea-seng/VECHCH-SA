<template>
  <loadingView v-if="appointmentstore.loading" />
  <main class="account setting">
    <div class="row gy-4">
      <div class="col-4">
        <div class="card wrapper">
          <div class="d-flex card-body pb-0 justify-content-between">
            <img
              src="/src/assets/images/auth/icon/find_doctor.png"
              width="75px"
              height="75px"
              alt=""
            />
            <div class="text-end">
              <p class="fw-medium mb-0 text-color-900">សរុបចំនួនការណាត់ជួប</p>
              <h1 class="fw-medium my-2 text-color-900" style="font-size: 48px">
                {{ appointmentstore.serviceCount?.meetingdoctor || 0 }}
              </h1>
            </div>
          </div>
          <div class="d-flex p-3 py-2 border-top justify-content-between">
            <span class="text-color-gray fs-small">ក្នុងរយៈពេល1ខែ</span>
            <RouterLink
              to="/appointment"
              class="see-all fw-medium text-decoration-none text-color-800"
            >
              <span class="">មើលទាំងអស់</span>
              <i class="fa-regular fa-chevron-right ms-1 txt-small"></i>
            </RouterLink>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card wrapper">
          <div class="d-flex card-body pb-0 justify-content-between">
            <img
              src="/src/assets/images/auth/icon/check-up.png"
              width="75px"
              height="75px"
              alt=""
            />
            <div class="text-end">
              <p class="fw-medium mb-0 text-color-900">សរុបការពិនិត្យសុខភាព</p>
              <h1
                v-if="appointmentstore.totalbooking"
                class="fw-medium my-2 text-color-900"
                style="font-size: 48px"
              >
                <!-- {{ appointmentstore.serviceCount}} -->

                {{ appointmentstore.serviceCount?.vaccine || 0 }}
              </h1>
            </div>
          </div>
          <div class="d-flex p-3 py-2 border-top justify-content-between">
            <span class="text-color-gray fs-small">ក្នុងរយៈពេល1ខែ</span>
            <RouterLink
              to="/appointment"
              class="see-all fw-medium text-decoration-none text-color-800"
            >
              <span class="">មើលទាំងអស់</span>
              <i class="fa-regular fa-chevron-right ms-1 txt-small"></i>
            </RouterLink>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card wrapper">
          <div class="d-flex card-body pb-0 justify-content-between">
            <img
              src="/src/assets/images/auth/icon/vaccination.png"
              width="75px"
              height="75px"
              alt=""
            />
            <div class="text-end">
              <p class="fw-medium mb-0 text-color-900">
                សរុបចំនួនទទួបវ៉ាក់សាំង
              </p>
              <h1
                v-if="appointmentstore.totalbooking"
                class="fw-medium my-2 text-color-900"
                style="font-size: 48px"
              >
                {{ appointmentstore.totalbooking[2].total }}
              </h1>
            </div>
          </div>
          <div class="d-flex p-3 py-2 border-top justify-content-between">
            <span class="text-color-gray fs-small">ក្នុងរយៈពេល1ខែ</span>
            <RouterLink
              to="/appointment"
              class="see-all fw-medium text-decoration-none text-color-800"
            >
              <span class="">មើលទាំងអស់</span>
              <i class="fa-regular fa-chevron-right ms-1 txt-small"></i>
            </RouterLink>
          </div>
        </div>
      </div>
      <div class="col-8">
        <div class="history bg-white wrapper p-3">
          <div class="pb-3 d-flex justify-content-between">
            <p class="mb-0">កាលវិភាគណាត់ជួប</p>
            <a
              href=""
              class="see-all fw-medium text-decoration-none text-color-800"
            >
              <span class="">មើលទាំងអស់</span>
              <i class="fa-regular fa-chevron-right ms-1 txt-small"></i
            ></a>
          </div>

          <div class="list-patient">
            <!-- <div class="d-flex patient justify-content-center bg-transparent">
              <div class=" d-flex align-items-center justify-content-center flex-column">
                <img class="empty-apppointment" src="/src/assets/images/auth/icon/empty_inbox.png" alt="">
                <span>មិនមានទីន្នន័យ</span>
              </div>
            </div> -->
            <div
              class="d-flex patient"
              v-for="appoint in appointmentstore.appontmentAprroveds"
              :key="appoint.id"
            >
              <div
                class="row list w-100 d-flex align-items-center text-decoration-none justify-content-between"
              >
                <div class="col-5">
                  <span>កាលបរិច្ឆេទ</span>
                  <p class="mb-0 mt-0 limit-line-1">
                    {{ appoint.appointment }}
                  </p>
                </div>

                <div class="col">
                  <span>ឈ្មោះអ្នកជំងឺ</span>
                  <p class="mb-0 mt-0">{{ appoint.local_name }}</p>
                </div>
                <div class="col">
                  <span>វេជ្ជបណ្ឌិត</span>
                  <p class="mb-0 mt-0">{{ appoint?.doctor?.local_fullname }}</p>
                </div>
                <!-- <div class="col-1 text-end">
                  <i class="bi ms-2 bi-three-dots-vertical" style="font-size: 17px; color: #5b5b5b"></i>
                </div> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="history bg-white wrapper p-3">
          <div class="d-flex mb-3 justify-content-between">
            <p class="mb-0">កំណត់ត្រាវេជ្ជសាស្រ្ត</p>
            <RouterLink
              to="medical-record-setting"
              class="see-all fw-medium text-decoration-none text-color-800"
            >
              <span class="">មើលទាំងអស់</span>
              <i class="fa-regular fa-chevron-right ms-1 txt-small"></i
            ></RouterLink>
          </div>

          <div class="list-patient">
            <a
              v-for="record in medStore.medaicalrecods"
              :key="record.id"
              role="button"
              @click="medStore.getMedicalrecordDetailId(record.id)"
              class="row g-2 list w-100 d-flex align-items-center text-decoration-none justify-content-between"
            >
              <div class="col-5">
                <span>កាលបរិច្ឆេទ</span>
                <p class="my-2 mt-0 limit-line-1">
                  {{ record.created_at }}
                </p>
              </div>
              <div class="col-5">
                <span>ជួបគ្រូពេទ្យ</span>
                <p class="my-2 mt-0">
                  {{ record.doctor.fullname }}
                </p>
              </div>
              <div class="col-1">
                <i
                  class="bi bi-three-dots-vertical"
                  style="font-size: 17px; color: #5b5b5b"
                ></i>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { historyStore } from "@/stores/historyStore";
import { RouterLink } from "vue-router";
import { appointmentStore } from "@/stores/appointmentstore";
import { onMounted } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/authTokenStore";
import router from "@/router";
import loadingView from "@/views/loading/loadingView.vue";
import { medicalRecordStore } from "@/stores/medicalRecordStore";

const medStore = medicalRecordStore();

const historystore = historyStore();
const appointmentstore = appointmentStore();
const authStore = useAuthStore();
onMounted(async () => {
  appointmentstore.fetchGetPateintData();
  medStore.getmedicalRecord();

  await appointmentstore.getAppointmentApprove();
  await appointmentstore.getTotalBooking();
  //    appointmentstore.gettotalcheckupapprove();
  //    appointmentstore.gettotalTalkpapprove();
  //    appointmentstore.gettotalVaccinepapprove();
  await appointmentstore.getBookingUserService();
});

// const InvoiceDetail = async (id) => {
//   const res = await axios.get(`/api/bookings/${id}`, {
//     headers: {
//       Authorization: "Bearer " + authStore.token,
//     },
//   });
//   appointmentstore.appointmentdetail = await res.data.data;

//   router.push("/invoice");
// };
</script>
