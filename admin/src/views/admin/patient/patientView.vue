<template>
  <div class="main">
    <loadingView v-if="pageLoading" />
    <div class="container-fluid bg-grey">
      <div class="row justify-content-between">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>
        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="title p-0">
              <h5 class="text-color-900 fw-medium">Medical Records</h5>
            </div>
            <div class="appointment-container bg-white p-4 rounded-4">
              <div class="d-flex justify-content-between mb-3">
                <div class="d-flex column-gap-3 align-item-center">
                  <input
                    type="search"
                    class="search-input"
                    placeholder="Search..."
                    v-model="useMedicalStore.filter.search"
                    @input="useMedicalStore.fetchMedicalRecords()"
                  />
                </div>
              </div>
              <div class="data-tbl border-0 bg-white rounded-4">
                <table class="tbl">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Patient</th>
                      <th>Doctor</th>
                      <th>Appointment Date</th>
                      <th>Created Date</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="data in medicalRecords" :key="data.id">
                      <td>{{ data.id }}</td>
                      <td>
                        <span class="limit-line-1">{{
                          data.patient_name || Date.patient_local_name
                        }}</span>
                      </td>
                      <td>
                        <span class="limit-line-1">{{ data.doctor_name }}</span>
                      </td>
                      <td>
                        <span class="text-color-950 fw-medium">{{
                          data.appointment
                        }}</span>
                      </td>
                      <td>{{ data.created_at }}</td>
                      <td>
                        <p class="m-0 limit-line-1">{{ data.description }}</p>
                      </td>
                      <td>
                        <div class="ps-2 d-flex column-gap-2">
                          <a
                            role="button"
                            class="approve-btn"
                            v-if="
                              useAppointmenStore.filter.service_type == 0 &&
                              data.is_complete == 0 &&
                              data.booking_status == 0
                            "
                            @click="useAppointmenStore.onClickApprove(data.id)"
                          >
                            Approve
                          </a>
                          <a
                            role="button"
                            class="detail-btn"
                            @click="getMedicalrecordDetailId(data.id)"
                          >
                            <i class="bi bi-info-lg"></i>
                          </a>
                          <a
                            role="button"
                            class="delete-btn"
                            v-if="
                              data.is_complete == 0 &&
                              data.booking_status == 0 &&
                              data.service_type == 0
                            "
                            @click="openModal(data.id)"
                          >
                            <i class="bi bi-x-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p
                  v-if="!medicalRecord && !medicalRecords.length"
                  class="text-center my-2 fw-medium text-color-900"
                >
                  No Patient Information <i class="fa-light fa-square-info"></i>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <button class="btn btn-warning" @click="openModal(id)">Open Modal</button> -->
  <mdlConfirm
    ref="modalRef"
    message="Reject Appointment. Are you sure to reject?"
    @confirm="confirmDelete"
  />
</template>
<script setup>
import { onMounted, ref, computed } from "vue";
import loadingView from "@/components/loadingView.vue";
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import mdlConfirm from "@/components/layouts/mdlConfirm.vue";
import { appointmentStore } from "@/stores/appointmentStore";
import { medicalRecord } from "@/stores/medicalRecordStore";
import router from "@/router";
const isDropdownOpen = ref(false);
const modalRef = ref(null);
const useAppointmenStore = appointmentStore();
const useMedicalStore = medicalRecord();
const openModal = (id) => {
  useAppointmenStore.selectedId = id;
  modalRef.value.openModal();
};
const confirmDelete = () => {
  if (useAppointmenStore.selectedId != 0) {
    useAppointmenStore.onClickApprove(useAppointmenStore.selectedId, 2);
  }
};
const app = computed(() => useAppointmenStore.appointments);

const medicalRecords = computed(() => useMedicalStore.medicalRecords);
const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;
    useAppointmenStore.filter.booking_status = "";
    useAppointmenStore.getBooking();

    await useMedicalStore.fetchMedicalRecords();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const getMedicalrecordDetailId = (id) => {
  let selected = id;
  if (selected) {
    sessionStorage.setItem("selectId", selected);
    router.push("/patient-medical-record");
  }
};
</script>

<style scoped>
.data-tbl th:nth-child(1),
.data-tbl td:nth-child(1) {
  padding-left: 15px;
  width: 4%;
}
.data-tbl th:nth-child(2),
.data-tbl td:nth-child(2) {
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
