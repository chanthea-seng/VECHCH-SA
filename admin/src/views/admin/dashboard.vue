<template>
  <main>
    <div class="container-fluid bg-grey">
      <loadingView v-if="pageLoading" />

      <div class="row justify-content-between">
        <div class="sidebar-container position-relative p-0">
          <sideBar />
        </div>

        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="section-body p-0">
              <div class="row g-0 gy-4">
                <div
                  class="card-group card-display p-0 gap-4"
                  v-if="admindatas"
                >
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <span class="text-color-800 fw-medium">
                          <i class="fa-light fa-user-doctor"></i> Total Doctor
                        </span>
                        <a role="button" class="text-color-800">
                          <i class="bi bi-three-dots-vertical"></i>
                        </a>
                      </div>
                      <h1 class="mt-3 mb-4 text-color-900">
                        {{ admindatas.total_doctor }}
                      </h1>
                    </div>
                    <div class="card-footer border-0 py-1">
                      <span class="text-white fw-semibold">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                        All Department
                      </span>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <span class="text-color-800 fw-medium">
                          <i class="fa-light fa-suitcase-medical"></i>
                          Services check-up
                        </span>
                        <a role="button" class="text-color-800">
                          <i class="bi bi-three-dots-vertical"></i>
                        </a>
                      </div>
                      <h1 class="mt-3 mb-4 text-color-900">
                        {{ admindatas.total_service_checkup }}
                      </h1>
                    </div>
                    <div class="card-footer border-0 py-1">
                      <span class="text-white fw-medium">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                        Health Check-up
                      </span>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <span class="text-color-800 fw-medium">
                          <i class="fa-light fa-syringe"></i> Service Vaccine
                        </span>
                        <a role="button" class="text-color-800">
                          <i class="bi bi-three-dots-vertical"></i>
                        </a>
                      </div>
                      <h1 class="mt-3 mb-4 text-color-900">
                        {{ admindatas.total_service_vaccine }}
                      </h1>
                    </div>
                    <div class="card-footer border-0 py-1">
                      <span class="text-white fw-medium">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                        Health Vaccine
                      </span>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <span class="text-color-800 fw-medium">
                          <i class="bi bi-journal-bookmark-fill"></i> Total
                          Contact
                        </span>
                        <a role="button" class="text-color-800">
                          <i class="bi bi-three-dots-vertical"></i>
                        </a>
                      </div>
                      <h1 class="mt-3 mb-4 text-color-900">
                        {{ admindatas.total_contact }}
                      </h1>
                    </div>
                    <div class="card-footer border-0 py-1">
                      <span class="text-white fw-medium">
                        <i class="bi bi-graph-up-arrow fs-5"></i>
                        Voice From User
                      </span>
                    </div>
                  </div>
                </div>

                <div class="chart-container">
                  <div class="title-container">
                    <h5 class="text-color-900 fw-medium">Appointment Chart</h5>
                  </div>
                  <div class="bg-white shadow-customize rounded-4 p-4">
                    <lineChart />
                  </div>
                </div>

                <div class="col-9 pe-4">
                  <div
                    class="title-container d-flex justify-content-between align-item-center"
                  >
                    <h5 class="text-color-900 fw-medium">
                      Appointment Pending
                    </h5>
                    <RouterLink
                      to="/appointment"
                      role="button"
                      class="text-color-800 fw-medium d-inline"
                    >
                      <small>View All <i class="bi bi-arrow-right"></i></small>
                    </RouterLink>
                  </div>
                  <div class="data-tbl p-4 bg-white rounded-4">
                    <table class="tbl" v-if="app">
                      <thead>
                        <tr>
                          <th></th>
                          <th>User</th>
                          <th>Doctor</th>
                          <th>Appointment Date</th>
                          <th>Submit Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="app.length === 0">
                          <td colspan="6" class="text-center">
                            <p class="m-0 fw-medium text-color-900 pt-3 fs-5">
                              មិនស្នើសុំការណាត់ជួបជាមួយវេជ្ជបណ្ឌិតនៅថ្ងៃនេះ
                              <i class="fa-light fa-user-doctor-hair"></i>
                            </p>
                          </td>
                        </tr>
                        <tr v-for="data in app" :key="data.id">
                          <td>
                            <img
                              :src="data.user.avatar"
                              alt=""
                              class="avatar-control"
                            />
                          </td>
                          <td>{{ data.local_name || data.name }}</td>
                          <td>
                            <span v-if="data.doctor">
                              {{
                                data.doctor.local_fullname || data.doctor.name
                              }}
                            </span>
                            <span v-else> ....</span>
                          </td>
                          <td>
                            <span class="text-color-950 fw-medium">{{
                              data.appointment
                            }}</span>
                          </td>
                          <td>{{ data.submit }}</td>

                          <td>
                            <div class="ps-2">
                              <a
                                role="button"
                                class="detail-btn"
                                @click="
                                  useAppointmentStore.onClickDetail(data.id)
                                "
                              >
                                <i class="bi bi-info-lg"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- contact -->
                <div class="col-3 p-0">
                  <div class="card contact-card p-3">
                    <h5 class="text-color-800 mb-3">Contact From User</h5>
                    <div class="card-body p-0 bg-transparent border-0">
                      <ul class="list-group row-gap-4">
                        <li
                          class="list-group-item"
                          v-for="contact in contacts"
                          :key="contact.id"
                        >
                          <div
                            class="d-flex column-gap-3 align-item-center position-relative"
                          >
                            <img
                              :src="contact.avatar"
                              alt=""
                              class="avatar-control"
                            />
                            <div class="position-relative w-100">
                              <a
                                role="button"
                                class="reply-btn"
                                @click="
                                  useContactStore.onClickDetail(contact.id)
                                "
                              >
                                <i class="bi bi-reply"></i>
                              </a>
                              <div class="d-flex align-item-center">
                                <h6 class="m-0">{{ contact.name }}</h6>
                                <i class="bi bi-dot text-grey-small"></i>
                                <small class="text-grey">
                                  {{ contact.submit_short }}</small
                                >
                              </div>
                              <small class="limit-line-1">
                                {{ contact.message }}
                              </small>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div
                    class="title-container d-flex justify-content-between align-item-center"
                  >
                    <h5 class="text-color-900 fw-medium">
                      Package & Vaccine Appointment
                    </h5>
                    <RouterLink
                      to="/appointment"
                      role="button"
                      class="text-color-800 fw-medium d-inline"
                    >
                      <small>View All <i class="bi bi-arrow-right"></i></small>
                    </RouterLink>
                  </div>
                  <div class="data-tbl p-4 bg-white rounded-4">
                    <table class="tbl" v-if="appPackage">
                      <thead>
                        <tr>
                          <th></th>
                          <th>User</th>
                          <th>Patient</th>
                          <th>Service Type</th>
                          <th>Appointment Date</th>
                          <th>Submit Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-if="appPackage.length === 0">
                          <td colspan="6" class="text-center">
                            <p class="m-0 fw-medium text-color-900 pt-3 fs-5">
                              មិនស្នើសុំការណាត់ជួបជាមួយវេជ្ជបណ្ឌិតនៅថ្ងៃនេះ
                              <i class="fa-light fa-user-doctor-hair"></i>
                            </p>
                          </td>
                        </tr>
                        <tr v-for="data in appPackage" :key="data.id">
                          <td>
                            <img
                              :src="data.user.avatar"
                              alt=""
                              class="avatar-control"
                            />
                          </td>
                          <td>{{ data.user.fullname }}</td>
                          <td>{{ data.local_name || data.name }}</td>
                          <td>
                            <span
                              class="status"
                              :class="
                                data.service_type == 1
                                  ? 'notCompleted'
                                  : 'completed'
                              "
                            >
                              {{
                                data.service_type == 1 ? "check-up" : "vaccine"
                              }}
                            </span>
                          </td>
                          <td>{{ data.appointment }}</td>
                          <td>{{ data.submit }}</td>

                          <td>
                            <div>
                              <a
                                @click="
                                  useAppointmentStore.onClickDetail(data.id)
                                "
                                role="button"
                                class="detail-btn"
                              >
                                <i class="bi bi-info-lg"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
import loadingView from "@/components/loadingView.vue";
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import lineChart from "@/components/layouts/chart/lineChart.vue";
import { onMounted, computed, onUnmounted, ref } from "vue";
import { appointmentStore } from "@/stores/appointmentStore";
import { contactStore } from "@/stores/contactStore";
import { useAuthStore } from "@/stores/userAuthStore";
import router from "@/router";
const useContactStore = contactStore();
const useAppointmentStore = appointmentStore();
const app = computed(() => useAppointmentStore.appointments);
const admindatas = computed(() => useAppointmentStore.adminData);
const appPackage = computed(() => useAppointmentStore.packages);
const contacts = computed(() => useContactStore.contacts);
const authStore = useAuthStore();
const pageLoading = ref();
onMounted(async () => {
  try {
    pageLoading.value = true;

    authStore.loadToken();
    useAppointmentStore.filter.service_type = 0;
    useAppointmentStore.filter.per_page = 6;
    useAppointmentStore.appointments = null;
    await useAppointmentStore.getAdminData();
    useAppointmentStore.filter.today = 1;
    await useAppointmentStore.getBooking();
    await useAppointmentStore.getPackage([1, 2], 10);
    useContactStore.filter.per_page = 3;
    await useContactStore.getContact();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
onUnmounted(() => {
  useAppointmentStore.filter.today = 0;
  useAppointmentStore.appointments =
    useAppointmentStore.packages =
    useContactStore.contacts =
    useAppointmentStore.adminData =
      null;
});
</script>
