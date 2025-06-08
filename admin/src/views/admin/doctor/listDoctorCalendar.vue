<template>
  <main class="list-doctor-calendar">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>

        <div class="sidecontent-container pt-3 list-doctor-calendar-content">
          <div class="row">
            <Navhead />
            <hr />
            <div class="bg-white rounded-4 p-4" v-if="doctor">
              <div class="section-title mb-4">
                <h5 class="text-color-900 fw-medium m-0 mb-2">
                  Dr. {{ doctor.fullname }}
                </h5>
              </div>
              <div class="row g-0 row-gap-4">
                <div class="col-6">
                  <div class="card bg-transparent px-4 py-3">
                    <div
                      class="d-flex justify-content-center align-items-center"
                    >
                      <div
                        class="list-doc-calendar-img rounded-circle d-flex justify-content-center align-items-center me-4"
                      >
                        <img
                          :src="doctor.avatar"
                          class="img-fluid rounded-circle border-avatar"
                          alt=""
                        />
                      </div>
                      <div class="list-doc-calendar-line me-4"></div>
                      <div
                        class="d-flex justify-content-center align-items-center"
                      >
                        <ul class="list-unstyled me-5 mt-3">
                          <li class="text-grey">Name:</li>
                          <li class="text-color-950 mb-3">
                            <span class="fw-medium">
                              {{ doctor?.fullname }}
                            </span>
                          </li>
                          <li class="text-grey">Gender</li>
                          <li class="text-color-950">
                            <span class="fw-medium text-capitalize">
                              {{ doctor?.gender }}
                            </span>
                          </li>
                        </ul>
                        <ul class="list-unstyled me-5 mt-3">
                          <li class="text-grey">Specaility:</li>
                          <li class="mb-3">
                            <span class="fw-medium">
                              {{ doctor?.specialist?.name }}
                            </span>
                          </li>
                          <li class="text-grey">Department:</li>
                          <li class="">
                            <span class="fw-medium">
                              {{ doctor?.department?.name }}
                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6" v-if="summary">
                  <div class="card bg-transparent px-4 py-4 border-0">
                    <div
                      class="d-flex justify-content-center align-items-center"
                    >
                      <div class="me-5">
                        <h5
                          class="fw-semibold text-color-800 mb-4 d-flex justify-content-center align-items-center"
                        >
                          <i class="bi bi-journal-bookmark-fill fs-3 me-2"></i>
                          Total Appointment
                        </h5>
                        <h2 class="fw-semibold text-color-800">
                          {{ summary.all || 0 }}
                        </h2>
                      </div>
                      <div class="fs-5">
                        <h5
                          class="fw-semibold text-color-800 mb-4 d-flex justify-content-center align-items-center"
                        >
                          <i class="bi bi-journal-bookmark-fill fs-3 me-2"></i>
                          Appointment Success
                        </h5>
                        <h2 class="fw-semibold text-color-800">
                          {{ summary.success || 0 }}
                        </h2>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="data-tbl border-0 rounded-4">
                  <table class="tbl">
                    <thead>
                      <tr>
                        <th></th>
                        <th>User</th>
                        <th>Patient</th>
                        <th>Appointment Date</th>
                        <th>Submit Date</th>
                        <th>Description</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="data in appointments" :key="data.id">
                        <td>
                          <img
                            :src="data.user.avatar"
                            alt=""
                            class="avatar-control"
                          />
                        </td>
                        <td>
                          <span class="limit-line-1">{{
                            data.user.fullname
                          }}</span>
                        </td>
                        <td>
                          <span class="limit-line-1">{{
                            data.local_name || data.name
                          }}</span>
                        </td>
                        <td>
                          <span class="text-color-950 fw-medium">{{
                            data.appointment
                          }}</span>
                        </td>
                        <td>{{ data.submit }}</td>
                        <td>
                          <span class="limit-line-1">
                            {{ data.description }}
                          </span>
                        </td>
                        <td>
                          <div class="ps-2 d-flex column-gap-2">
                            <a
                              role="button"
                              class="detail-btn"
                              @click="useAppointmenStore.onClickDetail(data.id)"
                            >
                              <i class="bi bi-info-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <p
                    v-if="!appointments"
                    class="text-center my-2 fw-medium text-color-900"
                  >
                    No Patient Information
                    <i class="fa-light fa-square-info"></i>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import loadingView from "@/components/loadingView.vue";
import { doctorStore } from "@/stores/doctorStore";
import { appointmentStore } from "@/stores/appointmentStore";
import { computed, onMounted, ref } from "vue";
const useDoctorStore = doctorStore();
const useAppointmenStore = appointmentStore();
const doctor = computed(() => useDoctorStore.doctor);
const appointments = computed(() => useDoctorStore.appointments);
const summary = computed(() => useDoctorStore.summary);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;

    await useDoctorStore.getDocBooking();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
<style scoped>
.data-tbl th:nth-child(1),
.data-tbl td:nth-child(1) {
  padding-left: 15px;
  width: 4%;
}
.data-tbl th:nth-child(2),
.data-tbl td:nth-child(2) {
  padding-left: 15px;
  width: 15%;
}

.data-tbl th:nth-child(3),
.data-tbl td:nth-child(3) {
  width: 15%;
}
.data-tbl th:nth-child(4),
.data-tbl td:nth-child(4) {
  width: 15%;
}
.data-tbl th:nth-child(5),
.data-tbl td:nth-child(5) {
  width: 15%;
}
</style>
