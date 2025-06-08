<template>
  <main class="bg-main prescription-page">
    <div class="row justify-content-between position-relative g-0">
      <div class="col-2 p-0">
        <sidebar />
      </div>
      <div class="col-10 p-0">
        <navhead />
        <div class="row p-0 ps-4 g-0">
          <div class="col-12 p-0 mt-3">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <RouterLink to="/medical-record">
                    <i class="fas fa-book"></i>
                    បង្កើតកំណត់ត្រា
                  </RouterLink>
                </li>
                <li><i class="fa-light fa-angle-right fw-medium"></i></li>
              </ol>
            </nav>
          </div>

          <div class="col-12 pb-5">
            <div class="row g-0 row-gap-4">
              <!-- Patient Info -->
              <div class="card p-4" v-if="bookingDetail">
                <div class="card-header mb-2 bg-transparent p-0 border-0">
                  <div class="d-flex justify-content-between">
                    <h5 class="text-color-900 fw-medium">ព័ត៌មានអ្នកជំងឺ</h5>
                    <div>
                      <a
                        class="tooltip-btn"
                        ref="tooltipBtn"
                        data-bs-toggle="tooltip"
                        title="ព័ត៌មានរបស់អ្នកជំងឺមិនអាចផ្លាស់ប្ដូរបានទេ"
                      >
                        <i class="bi bi-exclamation-circle-fill"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-body bg-transparent p-0">
                  <form class="patient-detail row row-gap-4">
                    <div class="group-input col-4">
                      <label>ឈ្មោះសមីខ្លួន</label>
                      <input
                        type="text"
                        class="form-control-global"
                        v-model="bookingDetail.local_name"
                        disabled
                      />
                    </div>
                    <div class="group-input col-4">
                      <label>ឈ្មោះអក្សរឡាតាំង</label>
                      <input
                        type="text"
                        class="form-control-global"
                        v-model="bookingDetail.name"
                        disabled
                      />
                    </div>
                    <div class="group-input col-2">
                      <label>ភេទ</label>
                      <input
                        type="text"
                        class="form-control-global"
                        :value="bookingDetail.gender == 1 ? 'ប្រុស' : 'ស្រី'"
                        disabled
                      />
                    </div>
                    <div class="group-input col-2">
                      <label>អាយុ</label>
                      <input
                        type="text"
                        class="form-control-global"
                        v-model="bookingDetail.dob"
                        disabled
                      />
                    </div>
                    <div class="group-input col-4">
                      <label>លេខទូរស័ព្ទ</label>
                      <input
                        type="text"
                        class="form-control-global"
                        v-model="bookingDetail.phone_number"
                        disabled
                      />
                    </div>
                    <div class="group-input col-4">
                      <label>អាសយដ្ធានអុីមែល</label>
                      <input
                        type="text"
                        class="form-control-global"
                        v-model="bookingDetail.email"
                        disabled
                      />
                    </div>
                  </form>
                </div>
              </div>

              <!-- Examinations -->
              <div class="card p-4">
                <div class="card-header mb-2 bg-transparent p-0 border-0">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <h5 class="text-color-900 fw-medium mb-0">
                      ការធ្វើតេស្តមន្ទីរពិសោធន៍ និងរោគវិនិច្ឆ័យ
                    </h5>
                    <a
                      role="button"
                      @click="addExamination"
                      class="addmore-btn"
                    >
                      <span><i class="bi bi-plus"></i> បង្កើតជួរថ្មី</span>
                    </a>
                  </div>
                </div>
                <div class="card-body bg-transparent p-0">
                  <div class="row mb-2">
                    <div class="col-4">
                      <span class="fw-medium text-color-950 ms-4 ps-3"
                        >ប្រភេទ/សញ្ញាសំខាន់ៗ</span
                      >
                    </div>
                    <div class="col-6">
                      <span class="fw-medium text-color-950">លទ្ធផល</span>
                    </div>
                    <div class="col-2">
                      <span class="fw-medium text-color-950"
                        >ស្ថានភាពសុខភាព</span
                      >
                    </div>
                  </div>
                  <div
                    v-for="(exam, index) in examinations"
                    :key="index"
                    class="row row-gap-3"
                  >
                    <div class="col-4 mb-3 d-flex column-gap-3">
                      <a
                        role="button"
                        @click="removeExamination(index)"
                        class="remove-btn"
                        ><i class="bi bi-trash"></i
                      ></a>
                      <div class="w-100">
                        <input
                          v-model="exam.name"
                          type="text"
                          class="form-control"
                          placeholder="ឈ្មោះវាល"
                        />
                        <small
                          v-if="submitted && !exam.name"
                          class="text-danger"
                          >សូមបំពេញឈ្មោះ</small
                        >
                      </div>
                    </div>
                    <div class="col-6">
                      <input
                        v-model="exam.result"
                        type="text"
                        class="form-control"
                        placeholder="បញ្ចូលតម្លៃ"
                      />
                      <small
                        v-if="submitted && !exam.result"
                        class="text-danger"
                        >សូមបំពេញលទ្ធផល</small
                      >
                    </div>
                    <div class="col-2">
                      <select v-model="exam.status" class="form-select">
                        <option value="Normal">ធម្មតា</option>
                        <option value="Abnormal">មិនធម្មតា</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Prescriptions -->
              <div class="card p-4">
                <div class="card-header mb-2 bg-transparent p-0 border-0">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <h5 class="text-color-900 fw-medium mb-0">
                      ថ្នាំដែលបានចេញវេជ្ជបញ្ជា
                    </h5>
                    <a
                      role="button"
                      @click="addPrescription"
                      class="addmore-btn"
                    >
                      <span><i class="bi bi-plus"></i> បង្កើតជួរថ្មី</span>
                    </a>
                  </div>
                </div>
                <div class="card-body bg-transparent p-0">
                  <div class="row mb-2">
                    <div class="col-4">
                      <span class="fw-medium text-color-950 ms-4 ps-3"
                        >ថ្នាំ</span
                      >
                    </div>
                    <div class="col-4">
                      <span class="fw-medium text-color-950">កម្រិតថ្នាំ</span>
                    </div>
                    <div class="col-2">
                      <span class="fw-medium text-color-950">ភាពញឹកញាប់</span>
                    </div>
                    <div class="col-2">
                      <span class="fw-medium text-color-950">រយៈពេល</span>
                    </div>
                  </div>
                  <div
                    v-for="(prescription, index) in prescriptions"
                    :key="index"
                    class="row row-gap-3"
                  >
                    <div class="col-4 mb-3 d-flex column-gap-3">
                      <a
                        role="button"
                        @click="removePrescription(index)"
                        class="remove-btn"
                        ><i class="bi bi-trash"></i
                      ></a>
                      <div class="w-100">
                        <input
                          v-model="prescription.medication"
                          type="text"
                          class="form-control"
                          placeholder="ថ្នាំ"
                        />
                        <small
                          v-if="submitted && !prescription.medication"
                          class="text-danger"
                          >សូមបំពេញឈ្មោះថ្នាំ</small
                        >
                      </div>
                    </div>
                    <div class="col-4">
                      <input
                        v-model="prescription.dosage"
                        type="text"
                        class="form-control"
                        placeholder="កម្រិតថ្នាំ"
                      />
                      <small
                        v-if="submitted && !prescription.dosage"
                        class="text-danger"
                        >សូមបំពេញកម្រិតថ្នាំ</small
                      >
                    </div>
                    <div class="col-2">
                      <input
                        v-model="prescription.frequency"
                        type="text"
                        class="form-control"
                        placeholder="ភាពញឹកញាប់"
                      />
                      <small
                        v-if="submitted && !prescription.frequency"
                        class="text-danger"
                        >សូមបំពេញភាពញឹកញាប់</small
                      >
                    </div>
                    <div class="col-2">
                      <input
                        v-model="prescription.duration"
                        type="text"
                        class="form-control"
                        placeholder="រយៈពេល"
                      />
                      <small
                        v-if="submitted && !prescription.duration"
                        class="text-danger"
                        >សូមបំពេញរយៈពេល</small
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="card p-4">
                <div class="card-header mb-2 bg-transparent p-0 border-0">
                  <h5 class="text-color-900 fw-medium">
                    កំណត់ចំណាំសម្រាប់អ្នកជំងឺ
                  </h5>
                  <span
                    >សូមធ្វើការបញ្ចូលការណែនាំ
                    និងការតាមដានសុខភាពដែលអ្នកជំងឺត្រូវអនុវត្តតាម</span
                  >
                </div>
                <div class="card-body bg-transparent p-0">
                  <textarea
                    name="notemessage"
                    v-model="noteMessage"
                    placeholder="សូមធ្វើការបញ្ចូលព័ត៌មាននៅទីនេះ"
                    class="cus-textarea w-100 mb-3"
                  ></textarea>
                </div>
                <!-- Save Button -->
                <div class="col-12 d-flex justify-content-end">
                  <primary-btn
                    @click="saveRecord"
                    label="បង្កើតវេជ្ជបញ្ជា"
                    class="fw-medium col-2"
                  />
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
import { toRaw, ref, unref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import { useAppointmentStore } from "@/stores/appointmentStore";
import { useAuthStore } from "@/stores/userAuthStore";
import { useNotyfStore } from "@/stores/notfyStore";
import axios from "axios";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import primaryBtn from "@/components/global/primaryBtn.vue";
import { Tooltip } from "bootstrap";
const notfy = useNotyfStore();
const authStore = useAuthStore();
const router = useRouter();
const appointmentStore = useAppointmentStore();
const tooltipBtn = ref(null);
const noteMessage = ref(null);
const examinations = ref([]);
const prescriptions = ref([]);
const submitted = ref(false); // Track form submission

// Methods
const addExamination = () => {
  examinations.value.push({ name: "", result: "", status: "normal" });
};

const removeExamination = (index) => {
  examinations.value.splice(index, 1);
};

const addPrescription = () => {
  prescriptions.value.push({
    medication: "",
    dosage: "",
    frequency: "",
    duration: "",
  });
};

const removePrescription = (index) => {
  prescriptions.value.splice(index, 1);
};

const saveRecord = async () => {
  submitted.value = true;

  try {
    const notes = [
      ...toRaw(examinations.value)
        .filter((exam) => exam.name && exam.result && exam.status)
        .map((exam) => ({
          type: "examination",
          name: exam.name,
          result: exam.result,
          status: exam.status,
        })),
      ...toRaw(prescriptions.value)
        .filter(
          (pres) =>
            pres.medication && pres.dosage && pres.frequency && pres.duration
        )
        .map((pres) => ({
          type: "prescription",
          medication: pres.medication,
          dosage: pres.dosage,
          frequency: pres.frequency,
          duration: pres.duration,
        })),
    ];

    if (notes.length === 0) {
      notfy.warning("សូមបំពេញព័ត៌មានអស់គ្រប់សម្រាប់ការពិនិត្យ ឬវេជ្ជបញ្ជា។");
      return;
    }

    authStore.loadToken();

    if (authStore.token) {
      const response = await axios.post(
        "/api/medical-records",
        {
          booking_id: bookingDetail.value.id,
          message: noteMessage.value,
          notes,
        },
        {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: `Bearer ${authStore.token}`,
          },
        }
      );

      submitted.value = false;
      noteMessage.value = "";
      examinations.value = [];
      prescriptions.value = [];
      sessionStorage.clear();
      notfy.success("បង្កើតវេជ្ជបញ្ជាដោយជោគជ័យ");
      router.go(-1);
    }
  } catch (error) {
    if (error.response) {
      //   console.error(
      //     "Server responded with an error:",
      //     error.response.status,
      //     error.response.data
      //   );
      notfy.warning("មានបញ្ហា");
    } else if (error.request) {
      //   console.error(
      //     "Request was made but no response received:",
      //     error.request
      //   );
      notfy.warning("មានបញ្ហា");
    } else {
      //   console.error("Error setting up the request:", error.message);
    }
  } finally {
    submitted.value = false;
  }
};

const bookingDetail = computed(() => appointmentStore.bookingDetail.value);
onMounted(() => {
  //   console.log(bookingDetail.value.id);
  appointmentStore.checkIfMedicalRecord();
  if (tooltipBtn.value) {
    new Tooltip(tooltipBtn.value);
  } else {
    console.warn("Tooltip button not found");
  }
  if (examinations.value.length === 0) addExamination();
  if (prescriptions.value.length === 0) addPrescription();
});
</script>

<style scoped>
.card {
  border-radius: 12px;
  /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
  border: 1px solid #eceded;
}

.form-control,
.form-select {
  border-radius: 4px;
}

.addmore-btn {
  color: #007bff;
  cursor: pointer;
}

.remove-btn {
  color: #dc3545;
  cursor: pointer;
}

.text-danger {
  font-size: 0.8rem;
}
</style>
