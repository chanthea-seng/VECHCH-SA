<template>
  <main class="bg-main patient">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />
          <div class="row p-4 g-0">
            <div class="col-12">
              <div class="row g-0 mb-4 total-info-wrapper">
                <!-- Appointment Count Card -->
                <div class="col me-4">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-sharp-duotone fa-solid fa-receipt"></i>
                        </div>
                        <span class="title">ចំនួនសរុបនៃការណាត់ជួប</span>
                      </div>
                      <span class="value-data">
                        {{ appointmentCount }}
                      </span>
                      <!-- <span class="small-detail">
                        ចំនួនការណាត់ជួបកើនឡើង 
                        <span class="fw-medium">{{ appointment_today || 0 }}</span> ថ្ងៃនេះ
                      </span> -->
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>

                <!-- Completed Appointments Card -->
                <div class="col me-4">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-solid fa-pen-nib"></i>
                        </div>
                        <span class="title">ចំនួនការណាត់ជួបដែលបានបំពេញ</span>
                      </div>
                      <span class="value-data">
                        {{ completedAppointments || 0 }}
                      </span>
                      <!-- <span class="small-detail">
                        អ្នកបានបំពេញកិច្ចការ 
                        <span class="fw-medium">{{ completed_today || 0 }}</span> ថ្ងៃនេះ
                      </span> -->
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>

                <!-- Cancelled Appointments Card -->
                <div class="col">
                  <div class="total-wrapper">
                    <div class="z-3 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <div class="icon-sign">
                          <i class="fa-solid fa-eye"></i>
                        </div>
                        <span class="title">ចំនួនការណាត់ជួបដែលបោះបង់</span>
                      </div>
                      <span class="value-data">
                        {{ notCompletedAppointments || 0 }}
                      </span>
                      <!-- <span class="small-detail">
                        អ្នកបានអានអត្ថបទកើនឡើង 
                        <span class="fw-medium">{{ patient_today || 0 }}</span> ថ្ងៃនេះ
                      </span> -->
                    </div>
                    <div class="pattern-style">
                      <div class="square r-45"></div>
                      <div class="square r-60"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="patient-appointment doctor-wrapper-card">
              <span class="title">ទិន្នន័យអ្នកជំងឺដែលត្រូវជួបថ្ងៃនេះ</span>
              <table
                class="table align-middle table-striped table-borderless"
                v-if="bookings"
              >
                <thead>
                  <tr class="table-light">
                    <th></th>
                    <th>ឈ្មោះអ្នកជំងឺ</th>
                    <th>ឈ្មោះឡាតាំង</th>
                    <th>ភេទ</th>
                    <th>ម៉ោងណាត់ជួប</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>ស្ថានភាព</th>
                    <th>សកម្មភាព</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(booking, index) in bookings" :key="booking.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ booking.local_name }}</td>
                    <td>{{ booking.name }}</td>
                    <td>{{ booking.gender == 1 ? "ប្រុស" : "ស្រី" }}</td>
                    <td>{{ booking.appointment_time }}</td>
                    <td>{{ booking.phone_number }}</td>
                    <td class="status">
                      <span
                        :class="
                          booking.is_complete ? 'completed' : 'notCompleted'
                        "
                      >
                        {{ booking.is_complete ? "បានបំពេញ" : "មិនបានបំពេញ" }}
                      </span>
                    </td>
                    <td class="btn-action">
                      <a
                        @click="
                          useDashBoardStore.onClickDetailBooking(booking.id)
                        "
                      >
                        <i class="fa-light fa-eye"></i>
                      </a>
                      <a @click="onClickConversation(booking.user.id)">
                        <i class="fa-light fa-comment"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import loadingView from "@/components/global/loadingView.vue";
import { useRouter } from "vue-router";
import { useAppointmentStore } from "@/stores/appointmentStore";
import { dashboardGeneralStore } from "@/stores/dashboardStore";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const useDashBoardStore = dashboardGeneralStore();
const useAppStore = useAppointmentStore();
const bookings = computed(() => useAppStore.patients);
const appointmentCount = ref(0);
const completedAppointments = ref(0);
const notCompletedAppointments = ref(0);

const fetchDashboardStats = async () => {
  try {
    const token = localStorage.getItem("token");
    const response = await axios.get("/api/bookings/count-info", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    if (response.data.result) {
      appointmentCount.value = response.data.data.total_all_appointment;
      completedAppointments.value = response.data.data.total_complete;
      notCompletedAppointments.value = response.data.data.total_uncomplete;
    }
  } catch (error) {
    // console.error("Error fetching count info:", error);
  }
};

const onClickConversation = async (id) => {
  try {
    const token = localStorage.getItem("token");
    const response = await axios.post(
      "/api/chat/find-conversation",
      { receiver_id: id },
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );
    if (response.data.data) {
      sessionStorage.setItem("conversation_id", response.data.data);
      router.push("/chat");
    }
  } catch (error) {
    // console.error("Error fetching count info:", error);
  }
};
const pageLoading = ref(true);
onMounted(async () => {
  try {
    await fetchDashboardStats();
    await useAppStore.onLoadPatient();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const router = useRouter();
</script>
