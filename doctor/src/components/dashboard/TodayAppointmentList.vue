<template>
  <div class="col-12 patient-appointment doctor-wrapper-card mt-4">
    <span class="title">ទិន្នន័យអ្នកជំងឺដែលត្រូវជួបថ្ងៃនេះ</span>
    <table class="table align-middle table-striped table-borderless">
      <thead>
        <tr class="table-light">
          <th>អត្តលេខ</th>
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
        <tr v-for="booking in todayBookings" :key="booking.id">
          <td>{{ booking.id }}</td>
          <td>{{ booking.local_name }}</td>
          <td>{{ booking.name }}</td>
          <td>{{ booking.gender == 1 ? "ប្រុស" : "ស្រី" }}</td>
          <td>{{ booking.appointment_time }}</td>
          <td>{{ booking.phone_number }}</td>
          <td class="status">
            <span :class="booking.is_complete ? 'completed' : 'notCompleted'">
              {{ booking.is_complete ? "បានបំពេញ" : "មិនបានបំពេញ" }}
            </span>
          </td>
          <td class="btn-action">
            <a @click="useDashBoardStore.onClickDetailBooking(booking.id)">
              <i class="fa-light fa-eye"></i>
            </a>
            <a
              :class="booking.is_complete ? 'd-none' : ''"
              @click="appointmentStore.onClickCreateMedicalRecord(booking)"
              style="cursor: pointer"
            >
              <i class="fa-light fa-pen"></i>
            </a>
            <a @click="onClickConversation(booking.user.id)">
              <i class="fa-light fa-comment"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
    <p
      v-if="!todayBookings || todayBookings.length === 0"
      class="fs-5 fw-medium text-color-900 text-center m-0 py-3"
    >
      មិនមានការណាត់ជួបថ្ងៃនេះ <i class="fa-light fa-books-medical"></i>
    </p>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { dashboardGeneralStore } from "@/stores/dashboardStore";
import { useAppointmentStore } from "@/stores/appointmentStore";

const appointmentStore = useAppointmentStore();
const useDashBoardStore = dashboardGeneralStore();
// const todayBookings = computed(() => useDashBoardStore.todayBooking.value);
const todayBookings = computed(() => {
  return Array.isArray(useDashBoardStore.todayBooking.value)
    ? useDashBoardStore.todayBooking.value
    : [];
});
onMounted(async () => {
  await useDashBoardStore.onLoadBookingToday();
});

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
</script>

<style scoped>
.disabled {
  opacity: 0.5;
  cursor: not-allowed !important;
  /* pointer-events: none; */
}
</style>
