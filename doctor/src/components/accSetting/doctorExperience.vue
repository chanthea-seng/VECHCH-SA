<template>
  <div class="col-9 edu-ex mt-4">
    <div
      class="add-card mb-2 px-4 py-3 d-flex justify-content-between align-items-center"
    >
      <h5 class="m-0 text-color-900">បន្ថែមបទពិសោធន៍</h5>
      <a role="button" @click="openExperienceModal">
        <span class="fs-4 text-color-900"
          ><i class="bi bi-plus-circle"></i
        ></span>
      </a>
    </div>

    <!-- Experience Cards -->
    <div class="row g-0 row-gap-2">
      <div v-if="experienceList" class="text-center w-100">
        <p v-if="experienceList.length == 0">មិនមានកំណត់ត្រាបទពិសោធន៍</p>
      </div>

      <div
        v-for="data in experienceList"
        :key="data.id"
        class="card p-1 ps-3 pe-2 edu-card"
      >
        <div class="card-body d-flex gap-4">
          <div
            class="card-icon d-flex align-items-center justify-content-center"
          >
            <span class="text-color-800 fs-5"
              ><i class="fas fa-briefcase"></i
            ></span>
          </div>
          <div class="education-background">
            <h5 class="text-color-950">
              {{ data.specialist.local_name }}
            </h5>
            <h5 class="text-color-950">{{ data.position }}</h5>
            <!-- <h5 class="mb-3">{{ data.organization_name }}</h5> -->
            <!-- <h5 class="mb-3">{{ data.responsibilities }}</h5> -->
            <!-- <p class="text-muted mb-0 d-flex ">
              <div class="text-color-950" style="width: 100px;">ឯកទេស </div>
              <strong class="text-color-950">: {{ getSpecialistName(data.specialist_id) }}</strong>
            </p>
            <p class="text-muted mb-0 d-flex ">
              <div class="text-color-950" style="width: 100px;">តួនាទី </div>
              <strong class="text-color-950">: {{ data.position }}</strong>
            </p> -->
            <p class="text-muted mb-0">{{ data.responsibilities }}</p>
            <p class="text-muted mb-0">{{ data.organization_name }}</p>
            <p class="text-muted mb-0">{{ data.location }}</p>
            <!-- <p class="text-muted mb-0 d-flex">
              <div style="width: 100px;">ទំនួលខុសត្រូវ </div> <strong>: {{ data.responsibilities }}</strong>
            </p>
            <p class="text-muted mb-0 d-flex">
              <div style="width: 100px;">ស្ថាប័ណ្ឋ </div> <strong>: {{ data.organization_name  }}</strong>
            </p> -->

            <p class="text-muted mb-0">
              {{ data.start || "N/A" }} -
              {{ data.end || "បច្ចុប្បន្ន" }}
            </p>
          </div>
          <div
            class="ms-auto d-flex flex-column justify-content-between align-items-end"
          >
            <div class="d-flex column-gap-2">
              <a role="button" class="btn-edit" @click="editExperience(data)">
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

  <!-- Experience Modal -->
  <mdlExperienceForm
    ref="experienceModalRef"
    @saved="useEduStore.fetchDoctorExperience"
  />
  <mdlConfirm
    ref="modalRef"
    message="តើ​អ្នក​ប្រាកដ​ក្នុង​ចិត្ត​លុប​ព័ត៌មាន​​នេះ?!"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import mdlExperienceForm from "../profile/mdlExperienceForm.vue";
import mdlConfirm from "../global/mdlConfirm.vue";
import { computed, onMounted, ref } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
import { eduStore } from "@/stores/docEduExStore";
import { useNotyfStore } from "@/stores/notfyStore";
const useExperience = useAuthStore();
const notfy = useNotyfStore();
const useEduStore = eduStore();
const experienceModalRef = ref(null);
const experienceList = computed(() => useEduStore.experiences);
const specialistsList = ref([]);

const modalRef = ref(null);
const openModal = (id) => {
  useEduStore.selectedId = id;
  modalRef.value.openModal();
};
const confirmDelete = async () => {
  useExperience.loadToken();
  try {
    if (useEduStore.selectedId != 0) {
      useExperience.loadToken();
      await axios.delete(`/api/doctor/experiences/${useEduStore.selectedId}`, {
        headers: { Authorization: `Bearer ${useExperience.token}` },
      });
      await useEduStore.fetchDoctorExperience();
      useEduStore.selectedId = 0;
      notfy.success("ការដកចេញជោគជ័យ");
    }
  } catch (error) {
    console.log(error);
    notfy.warning("ការដកចេញមានបញ្ហា");
  }
};

// Open modal for adding/editing experience
const openExperienceModal = (experienceData = null) => {
  experienceModalRef.value?.openModal(experienceData || {});
};

// Edit Experience
const editExperience = (experienceData) => {
  openExperienceModal(experienceData);
};

// Fetch Experiences
// const fetchDoctorExperience = async () => {
//   fetchSpecialists;
//   try {
//     const { data } = await axios.get("/api/doctor/experiences", {
//       headers: { Authorization: `Bearer ${useExperience.token}` },
//     });
//     experienceList.value = data.data || [];
//   } catch (error) {
//     console.error(
//       "Error fetching experiences:",
//       error.response?.data?.message || error.message
//     );
//   }
// };

// Fetch Specialists
const fetchSpecialists = async () => {
  try {
    const { data } = await axios.get("/api/specialists", {
      headers: { Authorization: `Bearer ${useExperience.token}` },
    });
    specialistsList.value = data.data || [];
  } catch (error) {
    // console.error(
    //   "Error fetching specialists:",
    //   error.response?.data?.message || error.message
    // );
  }
};

// Get Specialist Name by ID
const getSpecialistName = (id) => {
  const specialist = specialistsList.value.find((s) => s.id === id);
  return specialist ? specialist.name : "មិនមាន";
};

// Load experiences and specialists on mount
onMounted(async () => {
  await useExperience.loadToken();
  await fetchSpecialists();
  await useEduStore.fetchDoctorExperience();
});
</script>

<style scoped>
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
