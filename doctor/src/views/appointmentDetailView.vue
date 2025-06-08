<template>
  <main class="bg-main appointmentDetail-page">
    <loadingView v-if="pageLoading" />
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0" v-if="booking">
          <navhead />
          <div class="row g-0 p-0 ps-4 row-gap-4 mt-3">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center column-gap-4">
                  <img
                    :src="booking?.booking?.user?.avatar"
                    class="avatar-control"
                    alt=""
                  />
                  <div>
                    <h4 class="mb-1 text-color-950 fw-medium">
                      {{ booking?.booking?.user?.fullname }}
                    </h4>
                    <small
                      ><i class="bi bi-envelope-at"></i>
                      {{ booking?.booking?.user?.email }}
                    </small>
                  </div>
                </div>
                <div class="d-flex column-gap-2 align-items-center">
                  <button
                    class="secondary-btn"
                    :class="{
                      'disabled-btn': booking?.booking?.is_complete,
                      'btn-bg-650': !booking?.booking?.is_complete,
                    }"
                    :disabled="!!booking?.booking?.is_complete"
                    @click="
                      storeAppointmentDetail.onClickCreateMedicalRecord(
                        booking.booking
                      )
                    "
                  >
                    <i class="fa-light fa-file-lines"></i>
                    ចេញក្រដាសវេជ្ជបញ្ជា
                  </button>
                  <a
                    class="btn-bg-650"
                    role="button"
                    @click="onClickAddToChat(booking?.booking?.user?.id)"
                    :disabled="isChatLoading"
                  >
                    <span v-if="!isChatLoading">
                      <i class="bi bi-envelope"></i> ផ្ញើរសារ
                    </span>
                    <span v-else>
                      <i class="bi bi-hourglass-split"></i> កំពុងផ្ញើ...
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row g-0 row-gap-4">
                <div class="col-3">
                  <div class="card p-4 card-detail">
                    <div class="card-body bg-transparent border-0 p-0">
                      <h5 class="text-color-800">ព័ត៌មានទូទៅរបស់អ្នកជំងឺ</h5>
                      <ul class="list-group">
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5"
                            ><i class="bi bi-person"></i
                          ></span>
                          <div>
                            <small>ឈ្មោះសមីខ្លួន</small>
                            <p class="text-color-950 fw-medium">
                              {{ booking?.booking?.local_name }}
                            </p>
                          </div>
                        </li>
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5"
                            ><i class="bi bi-translate"></i>
                          </span>
                          <div>
                            <small>ឈ្មោះជាអក្សរឡាតាំង</small>
                            <p class="text-color-950 fw-medium">
                              {{ booking?.booking?.name }}
                            </p>
                          </div>
                        </li>
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5"
                            ><i class="bi bi-cake"></i>
                          </span>
                          <div>
                            <small>អាយុ</small>
                            <p class="text-color-950 fw-medium">
                              {{ booking?.booking?.dob }}
                            </p>
                          </div>
                        </li>
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5">
                            <i
                              class="bi"
                              :class="
                                booking?.booking?.gender == 1
                                  ? 'bi-gender-male'
                                  : 'bi-gender-female'
                              "
                            ></i>
                          </span>
                          <div>
                            <small>ភេទ</small>
                            <p class="text-color-950 fw-medium">
                              {{
                                booking?.booking?.gender == 1
                                  ? "បុរស"
                                  : "ស្ត្រី"
                              }}
                            </p>
                          </div>
                        </li>
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5"
                            ><i class="bi bi-envelope"></i>
                          </span>
                          <div>
                            <small>អាស័យដ្ធានអីម៉ែល</small>
                            <p class="text-color-950 fw-medium">
                              {{ booking?.booking?.email }}
                            </p>
                          </div>
                        </li>
                        <li class="list-group-item d-flex column-gap-3">
                          <span class="text-color-950 fs-5"
                            ><i class="bi bi-telephone"></i>
                          </span>
                          <div>
                            <small>លេខទូរស័ព្ទ</small>
                            <p class="text-color-950 fw-medium">
                              {{ booking?.booking?.phone_number }}
                            </p>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-9 ps-4">
                  <div class="card p-4 card-appointment">
                    <div class="card-body bg-transparent border-0 p-0">
                      <h5 class="text-color-800 mb-3">
                        ព័ត៌មានការណាត់ជួបរបស់អ្នកជំងឺ
                      </h5>
                      <div
                        class="row g-0 justify-content-between overflow-hidden"
                      >
                        <div class="col-6">
                          <div
                            class="nav flex-wrap row-gap-3 nav-pills me-3"
                            role="tablist"
                          >
                            <div
                              class="row g-0 p-0"
                              style="width: 85%"
                              v-for="(tab, index) in booking.related_bookings"
                              :key="tab.id"
                            >
                              <div class="col-2 position-relative">
                                <i
                                  class="bi bi-record-circle radio-control"
                                ></i>
                                <div class="date-line"></div>
                              </div>
                              <div class="col-10">
                                <button
                                  class="appointment-nav"
                                  :class="{ active: index === 0 }"
                                  data-bs-toggle="pill"
                                  :data-bs-target="`#v-pills-${tab.id}`"
                                >
                                  <div class="card p-0 bg-transparent border-0">
                                    <p
                                      class="mb-2 fs-6 fw-medium text-color-900"
                                    >
                                      <!-- {{ tab.local_name }} -->
                                      {{
                                        tab.service_type == 0
                                          ? "ពិគ្រោះប្រឹក្សាជំងឺ"
                                          : tab.service_type == 2
                                          ? "កញ្ចប់ពិនិត្យសុខភាព"
                                          : "កញ្ចប់វ៉ាក់សាំង"
                                      }}
                                      <span
                                        :class="
                                          tab.is_complete == 1
                                            ? 'came-badge'
                                            : 'not-came-badge'
                                        "
                                      >
                                        {{
                                          tab.is_complete == 1
                                            ? "បានមក"
                                            : "មិនបានមក"
                                        }}
                                      </span>
                                    </p>
                                    <small>{{ tab.appointment_time }}</small>
                                  </div>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-6 ps-5">
                          <div class="tab-content">
                            <div
                              v-for="(tab, index) in booking.related_bookings"
                              :key="tab.id"
                              class="tab-pane fade"
                              :class="{ 'show active': index === 0 }"
                              :id="`v-pills-${tab.id}`"
                            >
                              <div class="card p-4 appointment-detail">
                                <div
                                  class="card-header d-flex justify-content-between p-0 mb-3 bg-transparent border-0"
                                >
                                  <h5>
                                    {{
                                      tab.service_type == 0
                                        ? "ពិគ្រោះប្រឹក្សាជំងឺ"
                                        : tab.service_type == 2
                                        ? "កញ្ចប់ពិនិត្យសុខភាព"
                                        : "កញ្ចប់វ៉ាក់សាំង"
                                    }}
                                  </h5>
                                  <div>
                                    <p class="m-0">លេខសម្គាល់វិក្កយបត្រ</p>
                                    <small>{{ tab.invoice }}</small>
                                  </div>
                                </div>
                                <div
                                  class="card-body p-0 bg-transparent border-0"
                                >
                                  <div class="mb-3">
                                    <p class="m-0 fw-medium text-secondary">
                                      ម៉ោងណាត់ជួ​ប
                                    </p>
                                    <span class="fw-medium">{{
                                      tab.appointment_time
                                    }}</span>
                                  </div>
                                  <div>
                                    <p class="m-0 fw-medium text-secondary">
                                      អការៈរបស់អ្នកជំងឺ
                                    </p>
                                    <span>
                                      {{ tab.description }}
                                    </span>
                                  </div>
                                </div>
                                <div
                                  class="card-footer p-0 pt-3 border-0 bg-transparent"
                                >
                                  <a
                                    role="button"
                                    class="w-100 btn-bg-650"
                                    v-if="tab.is_complete == false"
                                    :class="{ 'd-none': tab.is_complete }"
                                    :disabled="loadingTabId === tab.id"
                                    @click="onBookingClick(tab.id)"
                                  >
                                    {{
                                      loadingTabId === tab.id
                                        ? "កំពុងដំណើរការ..."
                                        : "បានណាត់ជួប"
                                    }}
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="medical-table bg-white p-4">
                    <div
                      class="d-flex justify-content-between align-items-center mb-2"
                    >
                      <h4 class="text-color-900">លិខិតវេជ្ជបញ្ជា</h4>
                      <a
                        role="button"
                        class="text-color-900 fw-medium"
                        v-if="!booking?.booking?.is_complete"
                        @click="
                          storeAppointmentDetail.onClickCreateMedicalRecord(
                            booking.booking
                          )
                        "
                        ><span
                          >បង្កើតលិខិតថ្មី
                          <i class="fa-light fa-angle-right"></i
                        ></span>
                      </a>
                    </div>
                    <table class="medical-record-table">
                      <thead>
                        <th>លេខសម្គាល់</th>
                        <th>ប្រភេទសេវាកម្ម</th>
                        <th>ឈ្មោះវេជ្ជបណ្ឌិត</th>
                        <th>
                          <a role="button"> កាលបរិច្ឆេទបង្កើត </a>
                        </th>
                        <th>កំណត់ត្រា</th>
                        <th>សកម្មភាព</th>
                      </thead>
                      <tbody>
                        <tr v-if="medicalRecords.value.length == 0">
                          <td colspan="6" class="text-center">
                            <p class="m-0 fw-medium text-color-900 pt-3 fs-5">
                              មិនស្នើសុំការណាត់ជួបជាមួយវេជ្ជបណ្ឌិតនៅថ្ងៃនេះ
                              <i class="fa-light fa-user-doctor-hair"></i>
                            </p>
                          </td>
                        </tr>
                        <tr
                          v-for="record in medicalRecords.value"
                          :key="record.id"
                        >
                          <td>#{{ record.id }}</td>
                          <td>
                            {{
                              record.service_type === 0
                                ? "ពិគ្រោះប្រឹក្សាជំងឺ"
                                : record.service_type === 2
                                ? "កញ្ចប់ពិនិត្យសុខភាព"
                                : "កញ្ចប់វ៉ាក់សាំង"
                            }}
                          </td>
                          <td>{{ record.doctor_name }}</td>
                          <td>{{ record.created_at }}</td>
                          <td>
                            <p class="m-0 limit-line-1">
                              {{ record.description }}
                            </p>
                          </td>
                          <td class="btn-action">
                            <a
                              @click="getMedicalrecordDetailId(record.id)"
                              class="ms-3"
                            >
                              <i class="fa-light fa-eye"></i>
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
        </div>
      </div>
    </div>
  </main>
</template>
<script setup>
import loadingView from "@/components/global/loadingView.vue";
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import { useAppointmentStore } from "@/stores/appointmentStore";
import axios from "axios";
const router = useRouter();
const storeAppointmentDetail = useAppointmentStore();
const loadingTabId = ref(null);

// Handle appointment booking
const onBookingClick = async (id) => {
  loadingTabId.value = id;
  try {
    await storeAppointmentDetail.onClickBookingSuccess(id);
  } finally {
    loadingTabId.value = null;
  }
};
const pageLoading = ref(true);
onMounted(async () => {
  try {
    await storeAppointmentDetail.checkIfBooking();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const booking = computed(() => storeAppointmentDetail.bookingDetail.value);
const medicalRecords = computed(() => storeAppointmentDetail.medicalRecords);

const getMedicalrecordDetailId = (id) => {
  let selected = id;
  if (selected) {
    sessionStorage.setItem("selectId", selected);
    router.push("/medicaldetail");
  }
};

const isChatLoading = ref(false);

const onClickAddToChat = async (user_id) => {
  isChatLoading.value = true;

  try {
    const token = localStorage.getItem("token");
    const response = await axios.post(
      "/api/chat/find-conversation",
      { receiver_id: user_id },
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
    // Show error if needed
  } finally {
    isChatLoading.value = false;
  }
};
</script>

<style>
.secondary-btn.disabled-btn {
  opacity: 0.9;
  cursor: not-allowed !important;
}
</style>
