<template>
  <div
    class="modal fade"
    id="mdlEducation"
    ref="modalRef"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-5 rounded-4">
        <div class="modal-header p-0 border-0 d-flex justify-content-end">
          <button
            type="button"
            class="btn-close"
            @click="closeModal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body p-0">
          <form @submit.prevent="saveEducation">
            <div class="row row-gap-3">
              <div class="col-12">
                <h4 class="fw-semibold text-color-800">
                  បញ្ចូល/កែប្រែព័ត៌មានអប់រំ
                </h4>
                <span>បញ្ចូលព័ត៌មានអប់រំជាភាសាទាំងពីរ</span>
              </div>
              <div class="col-12">
                <label class="fw-medium text-grey mb-2"
                  >សកលវិទ្យាល័យ <small class="text-red">*</small></label
                >
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលសាកលវិទ្យាល័យ"
                  v-model="education.institution_name"
                  required
                />
              </div>
              <div class="col-12">
                <label class="fw-medium text-grey mb-2"
                  >សញ្ញាបត្រ <small class="text-red">*</small></label
                >
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលសញ្ញាបត្រ"
                  v-model="education.degree_name"
                  required
                />
              </div>
              <div class="col-12">
                <label class="fw-medium text-grey mb-2"
                  >ទីកន្លែង <small class="text-red">*</small></label
                >
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលទីកន្លែង"
                  v-model="education.location"
                  required
                />
              </div>
              <div class="col-6">
                <label class="fw-medium text-grey mb-2 me-2"
                  >កាលបរិច្ឆេទចាប់ផ្តើម</label
                >
                <flat-pickr
                  style="width: 330px"
                  v-model="education.start_date"
                  :config="config"
                  class="form-control"
                />
              </div>
              <div class="col-6">
                <label class="fw-medium text-grey mb-2 me-5 w-100"
                  >កាលបរិច្ឆេទបញ្ចប់</label
                >

                <flat-pickr
                  style="width: 330px"
                  v-model="education.end_date"
                  :config="config"
                  class="form-control"
                />
              </div>
              <div class="text-end mt-2">
                <button type="submit" class="btn-bg-650 px-5 py-2">
                  {{ education.id ? "ធ្វើបច្ចុប្បន្នភាព" : "បន្ថែម" }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { Modal } from "bootstrap";
import FlatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { useAuthStore } from "@/stores/userAuthStore";
import { eduStore } from "@/stores/docEduExStore";

import dayjs from "dayjs";
const useEduStore = eduStore();
const useEducation = useAuthStore();

const modalRef = ref(null);
let modalInstance = null;

const education = ref({
  id: null,
  institution_name: "",
  degree_name: "",
  location: "",
  start_date: null,
  end_date: null,
});

const config = ref({
  dateFormat: "Y-m-d",
  static: true,
  locale: { firstDayOfWeek: 1 },
});

onMounted(() => {
  if (modalRef.value) {
    modalInstance = new Modal(modalRef.value);
  }
});

// Function to fetch updated education data
// const fetchDoctorEducation = async () => {
//   try {
//     const response = await axios.get("/api/doctor/educations", {
//       headers: {
//         Authorization: `Bearer ${useEducation.token}`,
//         accept: "application/json",
//       },
//     });
//     useEducation.educations = response.data; // Ensure it's updating the reactive state
//     console.log(useEducation.educations);
//   } catch (error) {
//     console.error("Error fetching education data:", error);
//   }
// };

const openModal = (data = null) => {
  if (data) {
    education.value = { ...data };
  } else {
    education.value = {
      id: null,
      institution_name: "",
      degree_name: "",
      location: "",
      start_date: null,
      end_date: null,
    };
  }
  if (modalInstance) modalInstance.show();
};

const closeModal = () => {
  if (modalInstance) modalInstance.hide();
};

const saveEducation = async () => {
  try {
    const payload = {
      institution_name: education.value.institution_name.trim(),
      degree_name: education.value.degree_name.trim(),
      location: education.value.location.trim(),
      start_date: education.value.start_date
        ? dayjs(education.value.start_date).format("YYYY-MM-DD")
        : null,
      end_date: education.value.end_date
        ? dayjs(education.value.end_date).format("YYYY-MM-DD")
        : null,
    };

    let response;
    if (education.value.id) {
      response = await axios.put(
        `/api/doctor/educations/${education.value.id}`,
        payload,
        {
          headers: {
            Authorization: `Bearer ${useEducation.token}`,
            accept: "application/json",
          },
        }
      );
    } else {
      response = await axios.post("/api/doctor/educations", payload, {
        headers: {
          Authorization: `Bearer ${useEducation.token}`,
          accept: "application/json",
        },
      });
    }

    if (response.data) {
      //   console.log("Education saved successfully:", response.data);
      await useEduStore.fetchDoctorEducation(); // Refresh education list
      closeModal(); // Close modal after saving
    }
  } catch (error) {
    console.log(error);
    // console.error(
    //   "Error saving education:",
    //   error.response?.data || error.message || "Unknown error"
    // );
  }
};

defineExpose({ openModal });
</script>

<style scoped>
.form-control {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  width: 100%;
}
</style>
