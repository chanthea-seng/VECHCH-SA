<template>
  <loadingView v-if="appointment.loading" />
  <div v-else class="appointment appointmentsetting setting pt-0 mt-0">
    <div class="wrapper package position-relative overflow-hidden">
      <div class="cicle"></div>
      <div class="cicle2"></div>
      <div
        class="row position-relative z-3 align-items-center justify-content-between"
      >
        <div class="col-8">
          <p class="mb-0 text-white advertise-text">
            កក់កញ្ចប់ពិនិត្យសុខភាពជាមួយយើងថ្ងៃនេះដើម្បីតាមដានសុខភាពរបស់អ្នកអោយកាន់តែប្រសើរនាថ្ងៃអនាគត
          </p>
        </div>
        <div class="col-3">
          <div class="ms-3">
            <a @click="onClickCheckToken()" class="btn-bg-650 mb-0">
              កក់ឥឡូវនេះ
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="w-100 my-4">
      <h5 class="setting-title mb-1 text-color-950 mb-3">កាលបរិច្ឆេទណាត់ជួប</h5>
      <ul
        class="list-group list-group-horizontal justify-content-between result-meeting"
      >
        <li class="list-group-item">
          សំណើរទាំងអស់
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[0].total }}
          </p>
        </li>

        <li class="list-group-item">
          សំណើរយល់ព្រម
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[0].confirmed }}
          </p>
        </li>
        <li class="list-group-item">
          បានបំពេញ
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[0].completed }}
          </p>
        </li>
        <li class="list-group-item px-0">
          <div
            class="line h-100"
            style="width: 2px; background-color: #dedede"
          ></div>
        </li>
        <li class="list-group-item">
          ពិនិត្យសុខភាព
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[1].confirmed }}
          </p>
        </li>
        <li class="list-group-item">
          បានបំពេញ
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[1].completed }}
          </p>
        </li>
        <li class="list-group-item px-0">
          <div
            class="line h-100"
            style="width: 2px; background-color: #dedede"
          ></div>
        </li>
        <li class="list-group-item">
          វ៉ាក់សាំង
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[2].total }}
          </p>
        </li>
        <li class="list-group-item">
          បានបំពេញ
          <p class="mb-0" v-if="appointment.totalbooking">
            {{ appointment.totalbooking[2].total }}
          </p>
        </li>
      </ul>
    </div>

    <div class="bg-white border border-radius p-3 appointmentType">
      <div class="col d-flex">
        <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
          <li class="nav-item w-auto" role="presentation">
            <button
              class="nav-link"
              :class="{ active: appointment.filter.service_type === 0 }"
              id="pills-talk-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-talk"
              type="button"
              role="tab"
              aria-controls="pills-talk"
              aria-selected="true"
              @click="setServiceType(0)"
            >
              <span v-if="loadingServiceType === 0" class="loader"></span>
              <span v-else class=""></span>
              ពិគ្រោះប្រឹក្សា
            </button>
          </li>
          <li class="nav-item w-auto" role="presentation">
            <button
              class="nav-link"
              :class="{ active: appointment.filter.service_type === 1 }"
              id="pills-healt-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-healt"
              type="button"
              role="tab"
              aria-controls="pills-healt"
              aria-selected="false"
              @click="setServiceType(1)"
            >
              <span v-if="loadingServiceType === 1" class="loader"></span>
              <span v-else class=""></span>
              ពិនិត្យសុខភាព
            </button>
          </li>
          <li class="nav-item w-auto" role="presentation">
            <button
              class="nav-link"
              :class="{ active: appointment.filter.service_type === 2 }"
              id="pills-vaccine-tab"
              data-bs-toggle="pill"
              data-bs-target="#pills-vaccine"
              type="button"
              role="tab"
              aria-controls="pills-vaccine"
              aria-selected="false"
              @click="setServiceType(2)"
            >
              <span v-if="loadingServiceType === 2" class="loader"></span>
              <span v-else class=""></span>
              វ៉ាក់សាំង
            </button>
          </li>
        </ul>
      </div>
      <div class="tab-content" id="pills-tabContent">
        <div
          class="tab-pane fade show active"
          :id="appointment.filter.service_type"
          role="tabpanel"
          aria-labelledby="pills-talk-tab"
          tabindex="0"
        >
          <div class="pateintlist patient-appointment doctor-wrapper-card">
            <table class="table align-middle table-striped table-borderless">
              <thead>
                <tr class="table-light ttitle">
                  <th>ម៉ោងណាត់ជួប</th>
                  <th>ឈ្មោះអ្នកជំងឺ</th>
                  <th>ឈ្មោះឡាតាំង</th>

                  <th v-show="appointment.filter.service_type === 0">
                    ឈ្មោះគ្រូពេទ្យ
                  </th>
                  <th v-show="appointment.filter.service_type === 1">
                    ប្រភេទសេវាកម្ម
                  </th>
                  <th v-show="appointment.filter.service_type === 2">
                    ប្រភេទសេវាកម្ម
                  </th>
                  <th>ស្ថានភាព</th>
                  <th>សកម្មភាព</th>
                </tr>
              </thead>
              <tbody class="align-middle">
                <tr v-if="!appointment.hasAppointment">
                  <td
                    class="d-flex align-items-center justify-content-center flex-column"
                  >
                    <img
                      class="empty-apppointment"
                      src="/src/assets/images/auth/icon/empty_inbox.png"
                      alt=""
                    />
                    <span>មិនមានទីន្នន័យ</span>
                  </td>
                </tr>
                <tr
                  v-for="appoint in appointment.appointments.data"
                  :key="appoint.id"
                >
                  <td class="date">{{ appoint.appointment_time }}</td>
                  <td>{{ appoint.local_name }}</td>
                  <td>{{ appoint.name }}</td>
                  <td v-show="appointment.filter.service_type === 0">
                    {{ appoint?.doctor?.name }}
                  </td>
                  <td v-show="appointment.filter.service_type !== 0">
                    {{
                      appoint.service_type == 1 ? "ពិនិត្យសុខភាព" : "វ៉ាក់សាំង"
                    }}
                  </td>
                  <td class="status">
                    <span
                      v-if="
                        appoint.booking_status == 1 && appoint.is_complete == 0
                      "
                      class="notCompleted"
                      >មិនបានបំពេញ</span
                    >
                    <span
                      v-else-if="
                        appoint.booking_status === 1 && appoint.is_complete == 1
                      "
                      class="completed"
                      >បានបំពេញ</span
                    >

                    <span v-else class="cancel">បោះបង់</span>
                  </td>
                  <td class="">
                    <div class="btn-action">
                      <a
                        v-if="
                          appointment.filter.service_type !== 0 &&
                          appoint.booking_status != 3
                        "
                        @click="appointment.getBookingDetailId(appoint.id)"
                        role="button"
                      >
                        <i class="fa-light fa-eye"></i>
                      </a>
                      <a
                        v-if="
                          appoint.booking_status != 3 &&
                          appoint.booking_status != 2 &&
                          appoint.service_type == 0
                        "
                        @click="onClickCancel(appoint.id)"
                        class="btn-delete"
                        role="button"
                      >
                        <i
                          class="fa-light fa-calendar-exclamation text-danger"
                        ></i>
                      </a>
                      <a
                        role="button"
                        @click="onOpenDelete(appoint)"
                        class="btn-delete"
                      >
                        <i class="fa-regular fa-xmark text-danger"></i>
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
</template>

<script setup>
import axios from "axios";
import { appointmentStore } from "@/stores/appointmentstore";
import { onMounted, computed, ref } from "vue";
import { useAuthStore } from "@/stores/authTokenStore";
import router from "@/router";
import loadingView from "@/views/loading/loadingView.vue";
const loadingServiceType = ref(null);
const authStore = useAuthStore();

const onClickCheckToken = () => {
  if (!authStore.token) {
    router.push("/login");
    return;
  }
  router.push("/book-appointment");
};

const appointment = appointmentStore();
onMounted(async () => {
  authStore.loadToken();
  await appointment.fetchGetPateintData();
  await appointment.getTotalBooking();
  await appointment.fetchAppointments();
});

const onOpenDelete = (appoint) => {
  appointment.mdl_deleteappoint.show();
  appointment.appointmentdetail = appoint;
  document.getElementById("body-wrapper").style.padding = 0;
  document.getElementById("body-wrapper").style.overflow = "auto";
};

const onClickCancel = (id) => {
  appointment.mdl_cancelappoint.show();
  appointment.selected_id = id;
  document.getElementById("body-wrapper").style.padding = 0;
  document.getElementById("body-wrapper").style.overflow = "auto";
};

const setServiceType = async (type) => {
  loadingServiceType.value = type;
  try {
    appointment.filter.service_type = type;
    await appointment.fetchAppointments();
    // console.log(appointment.fetchAppointments())
  } catch (error) {
    // console.error("Error loading service type:", error);
  } finally {
    loadingServiceType.value = null;
  }
};
</script>
