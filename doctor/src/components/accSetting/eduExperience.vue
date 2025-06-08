<template>
  <div class="col-9 edu-ex mt-4">
    <div
      class="add-card mb-2 px-4 py-3 d-flex justify-content-between align-items-center"
    >
      <h5 class="m-0 text-color-900">បន្ថែមការអប់រំ</h5>
      <div>
        <a role="button" @click="openEducationModal">
          <span class="fs-4 text-color-900">
            <i class="bi bi-plus-circle"></i>
          </span>
        </a>
      </div>
    </div>

    <!-- Education Cards -->
    <div class="row g-0 row-gap-2">
      <div v-if="educationList" class="text-center w-100">
        <p v-if="educationList.length == 0">មិនមានកំណត់ត្រាអប់រំ</p>
      </div>

      <div
        class="card p-1 ps-3 pe-2 edu-card"
        v-for="data in educationList"
        :key="data.id"
      >
        <div class="card-body d-flex gap-4">
          <div
            class="card-icon d-flex align-items-center justify-content-center"
          >
            <span class="text-color-800 fs-5">
              <i class="fas fa-briefcase"></i>
            </span>
          </div>
          <div class="education-background">
            <h5 class="text-color-950">{{ data.institution_name }}</h5>
            <h5 class="mb-3">{{ data.degree_name }}</h5>
            <p class="text-muted mb-0">
              {{ data.start_date || "N/A" }} -
              {{ data.end_date || "បច្ចុប្បន្ន" }}
            </p>
            <p class="text-muted mb-0">{{ data.location }}</p>
          </div>
          <div
            class="ms-auto d-flex flex-column justify-content-between align-items-end"
          >
            <span :class="getVerificationClass(data.is_verified)">
              {{ getVerificationText(data.is_verified) }}
            </span>
            <div class="d-flex column-gap-2">
              <a role="button" class="btn-edit" @click="onClickMdlEdit(data)">
                <i class="fas fa-pen"></i>
              </a>
              <a role="button" class="btn-del" @click="openModal(data.id)">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Education Modal -->
  <mdlDynamicForm
    ref="educationModalRef"
    @saved="useEduStore.fetchDoctorEducation"
  />
  <mdlConfirm
    ref="modalRef"
    message="តើ​អ្នក​ប្រាកដ​ក្នុង​ចិត្ត​លុប​ព័ត៌មាន​អប់រំ​នេះ?!"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import mdlDynamicForm from "@/components/profile/mdlDynamicForm.vue";
import mdlConfirm from "../global/mdlConfirm.vue";
import { computed, onMounted, ref } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import { eduStore } from "@/stores/docEduExStore";
import { useNotyfStore } from "@/stores/notfyStore";
const useEduStore = eduStore();
const notfy = useNotyfStore();
const useEducation = useAuthStore();
const educationModalRef = ref(null);
const educationList = computed(() => useEduStore.educations);

const modalRef = ref(null);
const openModal = (id) => {
  useEduStore.selectedId = id;
  modalRef.value.openModal();
};
const confirmDelete = async () => {
  try {
    if (useEduStore.selectedId != 0) {
      useEducation.loadToken();
      await axios.delete(`api/doctor/educations/${useEduStore.selectedId}`, {
        headers: { Authorization: `Bearer ${useEducation.token}` },
      });
      await useEduStore.fetchDoctorEducation();
      useEduStore.selectedId = 0;
      notfy.success("ការដកចេញជោគជ័យ");
    }
  } catch (error) {
    notfy.warning("ការដកចេញមានបញ្ហា");
  }
};

// Open Education Modal for Adding/Editing
const openEducationModal = (educationData = null) => {
  educationModalRef.value?.openModal(educationData);
};

// Handle Edit Button Click
const onClickMdlEdit = (educationData) => {
  openEducationModal(educationData);
};

// Handle Delete Button Click
const onClickMdlDel = async (id) => {
  if (!confirm("Are you sure you want to delete this record?")) return;
  try {
    await axios.delete(`api/doctor/educations/${id}`, {
      headers: { Authorization: `Bearer ${useEducation.token}` },
    });
    useEduStore.fetchDoctorEducation(); // Refresh list after delete
  } catch (error) {
    // console.error(
    //   "Error deleting education:",
    //   error.response?.data?.message || error.message
    // );
  }
};

// Badge Class for Verification Status
const getVerificationClass = (verified) => ({
  "pending-badge": verified == 0,
  "came-badge": verified == 1,
  "not-came-badge": verified == 2,
});

// Text for Verification Status
const getVerificationText = (verified) => {
  return verified == 0
    ? "កំពុងរង់ចាំ"
    : verified == 1
    ? "ផ្ទៀងផ្ទាត់"
    : "មិនបានផ្ទៀងផ្ទាត់";
};

// Fetch Doctor's Education Data
// const fetchDoctorEducation = async () => {
//   try {
//     const { data } = await axios.get("/api/doctor/educations", {
//       headers: { Authorization: `Bearer ${useEducation.token}` },
//     });

//     if (data && data.data) {
//       educationList.value = data.data;
//     } else {
//       console.error("No educations found in the response.");
//     }
//   } catch (error) {
//     console.error(
//       "Error fetching doctor education:",
//       error.response?.data?.message || error.message
//     );
//   }
// };

// Load Data on Component Mount
onMounted(async () => {
  await useEducation.loadToken();
  await useEduStore.fetchDoctorEducation();
});
</script>

<style scoped>
.pending-badge {
  background-color: orange;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
}

.came-badge {
  background-color: green;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
}

.not-came-badge {
  background-color: red;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
}

/* Edit and Delete button styles */
.btn-edit,
.btn-del {
  cursor: pointer;
  font-size: 18px;
}

.btn-edit:hover {
  color: blue;
}

.btn-del:hover {
  color: red;
}
</style>
