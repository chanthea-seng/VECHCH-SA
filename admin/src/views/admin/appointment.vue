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
              <h5 class="text-color-900 fw-medium">Show all Appointment</h5>
            </div>
            <div class="appointment-container bg-white p-4 rounded-4">
              <div class="nav-group">
                <div class="btn-group tab-nav d-flex column-gap-3">
                  <div>
                    <input
                      type="radio"
                      class="d-none tab-nav"
                      name="service_type"
                      id="consultant"
                      value="0"
                      v-model="useAppointmenStore.filter.service_type"
                      @change="useAppointmenStore.getBooking()"
                    />
                    <label for="consultant" class="cursor-pointer">
                      consultant
                    </label>
                  </div>
                  <div>
                    <input
                      type="radio"
                      class="d-none tab-nav"
                      name="service_type"
                      id="check-up"
                      value="1"
                      v-model="useAppointmenStore.filter.service_type"
                      @change="useAppointmenStore.getBooking()"
                    />
                    <label for="check-up" class="cursor-pointer">
                      check-up
                    </label>
                  </div>
                  <div>
                    <input
                      type="radio"
                      class="d-none tab-nav"
                      name="service_type"
                      id="vaccine"
                      value="2"
                      v-model="useAppointmenStore.filter.service_type"
                      @change="useAppointmenStore.getBooking()"
                    />
                    <label for="vaccine" class="cursor-pointer">
                      vaccine
                    </label>
                  </div>
                </div>
              </div>
              <hr />
              <div class="d-flex justify-content-between mb-3">
                <div class="d-flex column-gap-3 align-item-center">
                  <input
                    type="search"
                    class="search-input"
                    placeholder="Search..."
                    v-model="useAppointmenStore.filter.search"
                    @input="useAppointmenStore.getBooking()"
                  />
                  <div class="group-radio d-flex">
                    <div
                      class=""
                      v-if="useAppointmenStore.filter.service_type == 0"
                    >
                      <input
                        type="radio"
                        name="booking_status"
                        class="d-none"
                        value="0"
                        id="pending"
                        v-model="useAppointmenStore.filter.booking_status"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="pending">
                        <span>Pending</span>
                      </label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="booking_status"
                        class="d-none"
                        value="1"
                        id="approve"
                        v-model="useAppointmenStore.filter.booking_status"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="approve">
                        <span>Approved</span>
                      </label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="booking_status"
                        class="d-none"
                        value="2"
                        id="reject"
                        v-model="useAppointmenStore.filter.booking_status"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="reject">
                        <span>rejected</span>
                      </label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="booking_status"
                        class="d-none"
                        value="3"
                        id="cancel"
                        v-model="useAppointmenStore.filter.booking_status"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="cancel">
                        <span>cancel</span>
                      </label>
                    </div>
                  </div>
                  <div class="group-radio d-flex">
                    <div class="">
                      <input
                        type="radio"
                        name="is_complete"
                        class="d-none"
                        value="1"
                        id="completed"
                        v-model="useAppointmenStore.filter.is_complete"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="completed">
                        <span>Completed</span>
                      </label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="is_complete"
                        class="d-none"
                        value="0"
                        id="upcoming"
                        v-model="useAppointmenStore.filter.is_complete"
                        @change="useAppointmenStore.getBooking()"
                      />
                      <label for="upcoming">
                        <span>Upcoming</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center column-gap-2">
                  <!-- <small class="align-content-center">show</small> -->
                  <div
                    class="position-relative bg-color-800 rounded-2 align-content-center"
                    style="height: 40px"
                  >
                    <span :class="['cus-icon z-1', { toggle: isDropdownOpen }]"
                      ><i class="fa-regular fa-angle-down"></i
                    ></span>
                    <select
                      v-model="useAppointmenStore.filter.per_page"
                      @change="
                        isDropdownOpen = true;
                        useAppointmenStore.getBooking();
                      "
                      @blur="isDropdownOpen = false"
                    >
                      <option value="10" selected>10</option>
                      <option value="20">20</option>
                      <option value="30">30</option>
                      <option value="40">40</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="full-tbl data-tbl border-0 bg-white rounded-4">
                <table class="tbl">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th>User</th>
                      <th>Patient</th>
                      <th v-if="useAppointmenStore.filter.service_type == 0">
                        Doctor
                      </th>
                      <th>Appointment Date</th>
                      <th>Submit Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- <tr>
                      <td><img src="" alt="" class="avatar-control" /></td>
                      <td>Pim Panharith</td>
                      <td>Dr. Vechch Sal</td>
                      <td>2025-01-25 8:00:00</td>
                      <td>2025-01-25 8:00:00</td>

                      <td>
                        <div class="d-flex column-gap-2">
                          <a
                            role="button"
                            class="approve-btn"
                            v-if="useAppointmenStore.filter.service_type == 0"
                          >
                            Approve
                          </a>
                          <a role="button" class="detail-btn">
                            <i class="bi bi-info-lg"></i>
                          </a>
                          <a
                            role="button"
                            class="delete-btn"
                            v-if="useAppointmenStore.filter.service_type == 0"
                          >
                            <i class="bi bi-x-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr> -->
                    <tr v-for="(data, index) in app" :key="data.id">
                      <td>{{ index + 1 }}</td>
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
                      <td v-if="useAppointmenStore.filter.service_type == 0">
                        {{ data.doctor.local_fullname || data.doctor.name }}
                      </td>
                      <td>
                        <span class="text-color-950 fw-medium">{{
                          data.appointment
                        }}</span>
                      </td>
                      <td>{{ data.submit }}</td>
                      <td>
                        <span
                          class="status"
                          :class="
                            data.booking_status == 0
                              ? 'pending'
                              : data.booking_status == 1
                              ? 'completed'
                              : data.booking_status == 2
                              ? 'cancel'
                              : 'cancel'
                          "
                        >
                          {{
                            data.booking_status == 0
                              ? "pending"
                              : data.booking_status == 1
                              ? "approve"
                              : data.booking_status == 2
                              ? "reject"
                              : "cancel"
                          }}
                        </span>
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
                            @click="useAppointmenStore.onClickDetail(data.id)"
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
const isDropdownOpen = ref(false);
const modalRef = ref(null);
const useAppointmenStore = appointmentStore();

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
const pageLoading = ref(true);
onMounted(async () => {
  try {
    useAppointmenStore.filter.booking_status = "";
    await useAppointmenStore.getBooking();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
