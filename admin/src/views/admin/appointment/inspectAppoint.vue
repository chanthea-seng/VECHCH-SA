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
            <div class="inspect-appoint-content bg-white p-4 rounded-4 mb-4">
              <div
                class="section-title d-flex justify-content-between align-items-center w-100 mb-3"
              >
                <h5 class="text-color-900 fw-medium me-2">
                  <i class="bi bi-info-circle text-color-900"></i>
                  Inspect Appointment
                </h5>
                <a role="button" @click="onClickBack()">
                  <i class="bi bi-x fs-1"></i>
                </a>
              </div>
              <div class="inspect-user-info" v-if="appDetail">
                <div class="row">
                  <div class="col-6">
                    <div class="card border-0">
                      <div
                        class="inspect-schedule d-flex justify-content-between align-items-center p-3 rounded-4 mb-4"
                        v-if="appDetail.service_type == 0 && appDetail.doctor"
                      >
                        <div
                          class="d-flex justify-content-center align-items-center"
                        >
                          <div class="img-fluid me-2">
                            <img :src="appDetail.doctor.avatar" alt="" />
                          </div>
                          <div>
                            <h5 class="m-0 mb-2 text-color-900">
                              វេជ្ជបណ្ឌិត {{ appDetail.doctor.local_fullname }}
                            </h5>
                            <span>{{ appDetail.doctor.name }}</span>
                          </div>
                        </div>
                        <div
                          class="d-flex justify-content-center align-items-center"
                        >
                          <!-- <h5 class="text-color-900 m-0">
                            Schedule Clear <i class="bi bi-check2-circle"></i>
                          </h5> -->
                        </div>
                      </div>
                      <div class="user-info-file pb-3 mb-3">
                        <div class="col-6" v-if="appDetail.file">
                          <label>File</label>
                          <div class="file-symtom">
                            <div class="mb-4">
                              <div>
                                <a
                                  :href="appDetail.file"
                                  class="file-show border d-block p-5 rounded-4"
                                >
                                  <img
                                    src="@/assets/img/doc.png"
                                    class="img-fluid"
                                    alt=""
                                  />
                                </a>
                              </div>
                              <span
                                class="text-color-800 fw-medium"
                                style="font-style: italic"
                                >*Click file to download file</span
                              >
                            </div>
                          </div>
                        </div>
                        <div class="col-6" v-if="appDetail.paymentImage">
                          <label>Payment Image</label>
                          <div class="file-symtom mb-4">
                            <div class="">
                              <a
                                :href="appDetail.paymentImage"
                                class="file-show border d-block p-5 rounded-4"
                              >
                                <img
                                  src="@/assets/img/doc.png"
                                  class="img-fluid"
                                  alt=""
                                />
                              </a>
                            </div>
                            <span
                              class="text-color-800 fw-medium"
                              style="font-style: italic"
                              >*Click file to download file</span
                            >
                          </div>
                        </div>
                        <div class="col-12">
                          <span>Patient Description</span>
                          <h6 class="mt-3 limit-line-3">
                            {{ appDetail.description }}
                          </h6>
                        </div>
                      </div>
                      <div
                        class="inspect-protocal"
                        v-if="
                          !appDetail?.doctor?.id && appDetail.service_type == 0
                        "
                      >
                        <h5 class="text-color-900 mb-3">
                          <i class="bi bi-stack-overflow"></i> Select Doctor
                        </h5>
                        <div
                          class="doctor-select-card d-flex column-gap-2 align-items-center mb-3 px-2"
                          v-if="selectDoctor"
                        >
                          <div class="img-fluid me-2">
                            <img :src="selectDoctor.avatar" alt="" />
                          </div>
                          <div>
                            <h6 class="mb-0 text-color-900">
                              Dr. {{ selectDoctor.fullname }}
                            </h6>
                            <span>{{ selectDoctor.specialist.name }}</span>
                          </div>
                        </div>
                        <p class="mb-1">
                          Avalilable Doctor on
                          <span class="fw-medium">
                            {{ appDetail?.appointment }}
                          </span>
                        </p>
                        <input
                          type="search"
                          class="form-control mb-3"
                          placeholder="search doctor name or specialist"
                          id="inputsearchtag"
                          v-model="useAppointmenStore.filter.search"
                          @input="useAppointmenStore.getAvaliableDoctor()"
                        />
                        <div
                          class="inspect-speciality d-flex row-gap-3 flex-wrap p-3 rounded-4"
                        >
                          <div
                            class="col-12 d-flex align-items-center justify-content-between p-0"
                            v-for="doctor in doctors"
                            :key="doctor.id"
                          >
                            <div class="d-flex">
                              <div class="me-3">
                                <img :src="doctor.avatar" alt="" />
                              </div>
                              <div>
                                <h6 class="m-0 text-color-950">
                                  Dr. {{ doctor?.fullname }}
                                </h6>
                                <div>
                                  <span class="me-3">Specialist</span>
                                  <span class="fs-6 fw-medium text-color-950">
                                    {{ doctor?.specialist?.name }}
                                  </span>
                                </div>
                              </div>
                            </div>
                            <div>
                              <a
                                role="button"
                                class="btn-bg-650"
                                @click="onClickSelect(doctor)"
                              >
                                Select
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="card p-2 border-0">
                      <h6 class="">User Information</h6>
                      <div class="user-info d-flex mb-3">
                        <div class="user-info-img me-3">
                          <img :src="appDetail.user.avatar" alt="" />
                        </div>
                        <div
                          class="d-flex flex-column justify-content-center ms-3"
                        >
                          <span class="mb-2">User</span>
                          <h6 class="m-0">{{ appDetail.user.fullname }}</h6>
                        </div>
                        <div
                          class="d-flex flex-column justify-content-center ms-5"
                        >
                          <span class="mb-2">Request Date</span>
                          <h6 class="m-0">{{ appDetail.submit }}</h6>
                        </div>
                      </div>
                      <div class="user-info-service mb-3">
                        <div class="row">
                          <div class="col-4">
                            <div class="user-service">
                              <span>Service</span>
                              <h6 class="mt-3 m-0">
                                {{
                                  appDetail == 0
                                    ? "consultant"
                                    : appDetail == 1
                                    ? "check-up"
                                    : "vaccine"
                                }}
                              </h6>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="user-appoint">
                              <span>Appointment date</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.appointment }}
                              </h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="user-info-service mb-3">
                        <div class="row">
                          <div class="col-4">
                            <div class="user-service">
                              <span>Khmer Name</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.local_name }}
                              </h6>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="user-appoint">
                              <span>English Name</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.name }}
                              </h6>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="user-appoint">
                              <span>Gender</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.gender == 1 ? "Male" : "Female" }}
                              </h6>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="user-info-service mb-3">
                        <div class="row">
                          <div class="col-4">
                            <div class="user-service">
                              <span>Date of Birth</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.birth }}
                              </h6>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="user-appoint">
                              <span>Phone Number</span>
                              <h6 class="mt-3 m-0">
                                {{ appDetail.phone_number }}
                              </h6>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="user-appoint">
                              <span>Email</span>
                              <h6 class="mt-3 m-0 limit-line-1">
                                {{ appDetail.email }}
                              </h6>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div
                        class="d-flex justify-content-end"
                        v-if="
                          appDetail.service_type == 0 &&
                          appDetail.booking_status == 0
                        "
                      >
                        <a
                          role="button"
                          class="btn-ra btn-delete me-3"
                          @click="openModal(appDetail.id)"
                        >
                          Reject
                        </a>
                        <a
                          role="button"
                          class="btn-ra"
                          @click="approveBooking(appDetail.id)"
                          >Approve</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <adminFooter />
          </div>
        </div>
      </div>
    </div>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="Reject Appointment. Are you sure to reject?"
    @confirm="confirmDelete"
  />
</template>
<script setup>
import loadingView from "@/components/loadingView.vue";
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import mdlConfirm from "@/components/layouts/mdlConfirm.vue";
import adminFooter from "@/components/layouts/adminFooter.vue";
import { appointmentStore } from "@/stores/appointmentStore";
import { useNotyfStore } from "@/stores/notyfStore";
import { computed, onMounted, ref } from "vue";

import router from "@/router";
import { isTomorrow, lastDayOfISOWeek } from "date-fns";

const useAppointmenStore = appointmentStore();
const notyf = useNotyfStore();
const appDetail = computed(() => useAppointmenStore.appointmentsDetail);
const doctors = computed(() => useAppointmenStore.doctors || null);
const selectDoctor = ref(null);

const onClickSelect = (doctor) => {
  selectDoctor.value = doctor;
};

const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;

    await useAppointmenStore.getAppointmentDetail();

    if (!appDetail.doctor) {
      useAppointmenStore.convertDateFormat(
        useAppointmenStore.appointmentsDetail.appointment
      );
      useAppointmenStore.getAvaliableDoctor();
    }
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
const modalRef = ref(null);

const openModal = (id) => {
  useAppointmenStore.selectedId = id;
  modalRef.value.openModal();
};
const confirmDelete = () => {
  if (useAppointmenStore.selectedId != 0) {
    useAppointmenStore.onClickApprove(useAppointmenStore.selectedId, 2);
    router.go(-1);
  }
};
const approveBooking = async (id) => {
  try {
    var error = null;
    if (selectDoctor.value && appDetail.value?.doctor?.id == null) {
      let selectId = selectDoctor.value.id;
      let booking_id = appDetail.value.id;
      await useAppointmenStore.onClickAssignDoctor(selectId, booking_id);
    } else {
      error = 1;
    }
    if (appDetail.value?.doctor?.id != null) {
      error = null;
    }
    if (error == 1) {
      notyf.warning("Please Select Doctor");
      return;
    }
    await useAppointmenStore.onClickApprove(id);
    router.go(-1);
  } catch (error) {}
};
const onClickBack = () => {
  sessionStorage.removeItem("selectId");
  router.go(-1);
};
</script>
