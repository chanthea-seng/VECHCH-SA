<template>
  <main class="bg-main dashboard">
    <loadingView v-if="pageLoading" />
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />
          <div class="row g-0 p-4 pt-2">
            <div class="col-12 welcome d-flex align-items-center mb-2">
              <div class="d-flex flex-column">
                <span class="w-name"
                  >សូមស្វាគមន៍ <span class="name">{{ doctorName }} </span></span
                >
                <span class="info-appointment"
                  >ថ្ងៃនេះអ្នកមានអ្នកជំងឺដែលត្រូវជួបចំនួន
                  <span class="value">{{ appointmentCount }} នាក់</span></span
                >
              </div>
              <img src="../assets/image/dashboard.png" alt="" />
            </div>
            <div class="col-12">
              <div class="row g-0 mb-4 total-info-wrapper">
                <div class="col">
                  <div class="total-wrapper main">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-sharp-duotone fa-solid fa-receipt"></i>
                        </div>
                        <span class="text-white title"
                          >ចំនួនសរុបនៃការណាត់ជួប</span
                        >
                      </div>
                      <span class="value-data text-white">{{
                        appointmentCount
                      }}</span>
                      <span class="text-white"
                        >ចំនួនការណាត់ជួប
                        <span class="fw-medium">{{ appointmentCount }}</span>
                        នៅក្នុងថ្ងៃនេះ</span
                      >
                    </div>
                    <div class="position-absolute pattern-ab">
                      <div class="style-pattern">
                        <img src="../assets/image/heartrate.png" alt="" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col mx-4">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-solid fa-users-medical"></i>
                        </div>
                        <span class="title">ចំនួនសរុបនៃអ្នកជំងឺ</span>
                      </div>
                      <span class="value-data">{{ patientCount }}</span>
                      <span class="small-detail"
                        >ចំនួនអ្នកជំងឺណាត់ជួប
                        <span class="fw-medium">{{ appointmentCount }}</span
                        >នាក់​ ក្នុងថ្ងៃនេះ</span
                      >
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>
                <div class="col me-4">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <span class="title">ចំនួនអត្ថបទចែករំលែក</span>
                      </div>
                      <span class="value-data"> {{ articleCount }} </span>
                      <span class="small-detail"
                        >ចំនួនអត្ថបទថ្មីកើនឡើង
                        <span class="fw-medium">{{ todayArticle }}</span
                        >អត្ថបទ​ ថ្ងៃនេះ</span
                      >
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-solid fa-eye"></i>
                        </div>
                        <span class="title">ចំនួនអ្នកអានអត្ថបទ</span>
                      </div>
                      <span class="value-data"> {{ readerCount }} </span>
                      <span class="small-detail"
                        >អ្នកបានអានអត្ថបទកើនឡើង
                        <span class="fw-medium">{{ todayView }}</span>
                        ថ្ងៃនេះ</span
                      >
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <DashboardChart />
            <TodayAppointmentList />
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import loadingView from "@/components/global/loadingView.vue";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import DashboardChart from "@/components/dashboard/DashboardChart.vue";
import TodayAppointmentList from "@/components/dashboard/TodayAppointmentList.vue";
import router from "@/router";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
const authStore = useAuthStore();
const appointmentCount = ref(0);
const patientCount = ref(0);
const articleCount = ref(0);
const todayArticle = ref(0);
const readerCount = ref(0);
const todayView = ref(0);
// const appointment_today = ref(0);
// const patient_today = ref(0);
let doctorName = ref("");

const fetchDashboardStats = async () => {
  try {
    const response = await axios.get("/api/bookings/count-info", {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
      },
    });
    if (response.data.result) {
      appointmentCount.value = response.data.data.total_appointment;
      patientCount.value = response.data.data.total_patient;
      articleCount.value = response.data.data.total_article;
      todayArticle.value = response.data.data.total_published_today;
      readerCount.value = response.data.data.total_reader;
      todayView.value = response.data.data.total_views;
    }
  } catch (error) {
    // console.error("Error fetching count info:", error);
  }
};
const pageLoading = ref();
onMounted(async () => {
  try {
    pageLoading.value = true;
    authStore.loadToken();
    if (!(await authStore.checkIfDoctor())) {
      window.location.reload();
      router.push("/");
      return;
    }
    doctorName.value = authStore?.userData?.local_fullname;
    await fetchDashboardStats();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
