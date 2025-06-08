<template>
  <div
    class="modal fade"
    id="mdlExperience"
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
          <form @submit.prevent="saveExperience">
            <div class="row row-gap-3">
              <div class="col-12">
                <h4 class="fw-semibold text-color-800">
                  បញ្ចូល/កែប្រែបទពិសោធន៍
                </h4>
                <span>បញ្ចូលព័ត៌មានអប់រំជាភាសាទាំងពីរ</span>
              </div>

              <div class="col-6">
                <label class="fw-medium text-grey mb-2">
                  ផ្នែក <small class="text-red">*</small>
                </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលផ្នែក"
                  v-model="experience.position"
                  required
                />
              </div>

              <div class="col-6">
                <label class="fw-medium text-grey mb-2">
                  ជ្រើសរើសឯកទេស <small class="text-red">*</small>
                </label>
                <select
                  v-model="experience.specialist_id"
                  class="form-control"
                  required
                >
                  <option disabled selected>ជ្រើសរើសឯកទេស</option>
                  <option
                    v-for="specialist in specialistsList"
                    :key="specialist.id"
                    :value="specialist.id"
                  >
                    {{ specialist.local_name }}
                  </option>
                </select>
              </div>

              <div class="col-12">
                <label class="fw-medium text-grey mb-2">
                  តួនាទី <small class="text-red">*</small>
                </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលតួនាទី"
                  v-model="experience.responsibilities"
                  required
                />
              </div>

              <div class="col-12">
                <label class="fw-medium text-grey mb-2">
                  ស្ថាប័ណ្ឋ <small class="text-red">*</small>
                </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលស្ថាប័ណ្ឋ"
                  v-model="experience.organization_name"
                  required
                />
              </div>

              <div class="col-12">
                <label class="fw-medium text-grey mb-2">
                  ទីកន្លែង <small class="text-red">*</small>
                </label>
                <input
                  type="text"
                  class="form-control"
                  placeholder="បញ្ចូលទីកន្លែង"
                  v-model="experience.location"
                  required
                />
              </div>

              <div class="col-6">
                <label class="fw-medium text-grey mb-2">
                  កាលបរិច្ឆេទចាប់ផ្តើម <small class="text-red">*</small>
                </label>
                <flat-pickr
                  style="width: 330px"
                  v-model="experience.start_date"
                  :config="config"
                  class="form-control"
                />
              </div>

              <div class="col-6">
                <label class="fw-medium text-grey mb-2">
                  កាលបរិច្ឆេទបញ្ចប់ <small class="text-red">*</small>
                </label>
                <flat-pickr
                  style="width: 330px"
                  v-model="experience.end_date"
                  :config="config"
                  class="form-control"
                />
              </div>

              <div class="text-end mt-2">
                <button type="submit" class="btn-bg-650 px-5 py-2">
                  {{ experience.id ? "ធ្វើបច្ចុប្បន្នភាព" : "បន្ថែម" }}
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
import { ref, onMounted, defineExpose } from "vue";
import { Modal } from "bootstrap";
import FlatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { useAuthStore } from "@/stores/userAuthStore";
import dayjs from "dayjs";
import { eduStore } from "@/stores/docEduExStore";
import { useNotyfStore } from "@/stores/notfyStore";
const useExperience = useAuthStore();
const useEduStore = eduStore();
const modalRef = ref(null);
const notfy = useNotyfStore();
let modalInstance = null;

const experience = ref({
  id: null,
  specialist_id: null,
  organization_name: "",
  position: "",
  responsibilities: "",
  location: "",
  start_date: null,
  end_date: null,
});

const specialistsList = ref([]);
const config = ref({
  dateFormat: "Y-m-d",
  static: true,
  locale: { firstDayOfWeek: 1 },
});

onMounted(() => {
  if (modalRef.value) {
    modalInstance = new Modal(modalRef.value);
  }
  fetchSpecialists();
});

const fetchSpecialists = async () => {
  try {
    const { data } = await axios.get("api/specialists", {
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

const openModal = (data = null) => {
  experience.value = data
    ? { ...data }
    : {
        id: null,
        specialist_id: null,
        organization_name: "",
        position: "",
        responsibilities: "",
        location: "",
        start_date: null,
        end_date: null,
      };

  if (modalInstance) {
    modalInstance.show();
  }
};

const closeModal = () => {
  if (modalInstance) {
    modalInstance.hide();
  }
};

const saveExperience = async () => {
  try {
    const payload = {
      specialist_id: experience.value.specialist_id,
      organization_name: experience.value.organization_name.trim(),
      position: experience.value.position.trim(),
      responsibilities: experience.value.responsibilities.trim(),
      location: experience.value.location.trim(),
      start_date: experience.value.start_date
        ? dayjs(experience.value.start_date).format("YYYY-MM-DD")
        : null,
      end_date: experience.value.end_date
        ? dayjs(experience.value.end_date).format("YYYY-MM-DD")
        : null,
    };

    const url = experience.value.id
      ? `/api/doctor/experiences/${experience.value.id}`
      : "/api/doctor/experiences";

    await axios({
      method: experience.value.id ? "put" : "post",
      url,
      data: payload,
      headers: { Authorization: `Bearer ${useExperience.token}` },
    });

    await useEduStore.fetchDoctorExperience();
    closeModal();
    notfy.success("ធ្វើសកម្មភាពជោគជ័យ");
  } catch (error) {
    notfy.warning("សូមពិនិត្យមើលព័ត៌មានរបស់អ្នកម្តងទៀត");
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
