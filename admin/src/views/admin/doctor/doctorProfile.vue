<template>
  <main>
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>
        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="doctor-profile-content bg-white rounded-4">
              <div class="doctor-profile-title">
                <div class="section-title mb-4">
                  <h5 class="text-color-900">Doctor name</h5>
                </div>
                <div class="account-information">
                  <h4 class="text-color-700 fw-semibold m-0 mb-4">
                    Account User
                  </h4>
                  <div class="account-user-form" v-if="docDetail?.user">
                    <div>
                      <div class="form-group">
                        <div class="row g-0 gx-4">
                          <!-- Full Name (Khmer) -->
                          <div class="col-6 mb-3" v-if="docDetail">
                            <label
                              for="fullNameK"
                              class="fw-semibold mb-2 text-color-900"
                            >
                              Full Name (Khmer)<span class="text-danger"
                                >*</span
                              >
                            </label>
                            <input
                              type="text"
                              class="form-control-global"
                              id="fullNameK"
                              placeholder="Full Name (Khmer)"
                              v-model="docDetail.user.local_fullname"
                              :class="{
                                'is-invalid': $v.user.local_fullname.$error,
                              }"
                              @blur="$v.user.local_fullname.$touch()"
                            />
                            <div
                              class="invalid-feedback"
                              v-if="$v.user.local_fullname.$error"
                            >
                              <span>
                                {{ $v.user.local_fullname.$errors[0].$message }}
                              </span>
                            </div>
                          </div>

                          <!-- Full Name (English) -->
                          <div class="col-6 mb-3">
                            <label
                              for="fullNameE"
                              class="fw-semibold mb-2 text-color-900"
                            >
                              Full Name (English)<span class="text-danger"
                                >*</span
                              >
                            </label>
                            <input
                              type="text"
                              class="form-control-global"
                              id="fullNameE"
                              placeholder="Full Name (English)"
                              v-model="docDetail.user.fullname"
                              :class="{ 'is-invalid': $v.user.fullname.$error }"
                              @blur="$v.user.fullname.$touch()"
                            />
                            <div
                              class="invalid-feedback"
                              v-if="$v.user.fullname.$error"
                            >
                              <span>
                                {{ $v.user.fullname.$errors[0].$message }}
                              </span>
                            </div>
                          </div>
                          <div class="col-6 mb-3">
                            <label
                              for="email"
                              class="fw-semibold mb-2 text-color-900"
                            >
                              Email<span class="text-danger">*</span>
                            </label>
                            <input
                              type="email"
                              class="form-control-global"
                              id="email"
                              placeholder="example@gmail.com"
                              v-model="docDetail.user.email"
                              :class="{ 'is-invalid': $v.user.email.$error }"
                              @blur="$v.user.email.$touch()"
                            />
                            <div
                              class="invalid-feedback"
                              v-if="$v.user.email.$error"
                            >
                              <span>
                                {{ $v.user.email.$errors[0].$message }}
                              </span>
                            </div>
                          </div>

                          <!-- Phone Number -->
                          <div class="col-6 mb-3">
                            <label
                              for="phoneNumber"
                              class="fw-semibold mb-2 text-color-900"
                            >
                              Phone Number<span class="text-danger">*</span>
                            </label>
                            <input
                              type="text"
                              class="form-control-global"
                              id="phoneNumber"
                              placeholder="Phone Number"
                              v-model="docDetail.user.phone"
                              :class="{ 'is-invalid': $v.user.phone.$error }"
                              @blur="$v.user.phone.$touch()"
                            />
                            <div
                              class="invalid-feedback"
                              v-if="$v.user.phone.$error"
                            >
                              <span>
                                {{ $v.user.phone.$errors[0].$message }}
                              </span>
                            </div>
                          </div>

                          <div class="col-6 mb-3">
                            <label
                              for="avatarInput"
                              class="fw-semibold mb-2 text-color-900"
                              >Avatar<span class="text-danger">*</span></label
                            >
                            <div class="file-upload-wrapper">
                              <input
                                type="file"
                                id="avatarInput"
                                class="file-upload-input d-none"
                                accept="image/*"
                                @change="previewAvatar"
                              />
                              <label for="avatarInput" class="file-upload-box">
                                <div
                                  class="upload-content align-content-center"
                                >
                                  <img
                                    v-if="avatarUrl"
                                    :src="avatarUrl"
                                    class="img-fluid object-fit-cover"
                                    alt="Avatar"
                                  />
                                  <i
                                    v-else
                                    class="bi bi-person-circle upload-icon"
                                  ></i>
                                  <h6 v-if="!avatarUrl">upload avatar</h6>
                                </div>
                              </label>
                              <p
                                role="button"
                                v-if="avatarUrl"
                                @click="removeAvatar"
                                class="text-color-800 fw-medium"
                              >
                                <i class="bi bi-arrow-clockwise"></i> Click to
                                change image
                              </p>
                            </div>
                          </div>
                          <div class="col-6">
                            <div
                              class="d-flex justify-content-between flex-wrap h-100 flex-column"
                            >
                              <div class="form-group">
                                <label
                                  for="gender"
                                  class="fw-semibold mb-2 text-color-900"
                                  >Gender<span class="text-danger"
                                    >*</span
                                  ></label
                                >
                                <div>
                                  <div
                                    class="form-check form-check-inline me-4"
                                  >
                                    <input
                                      type="radio"
                                      class="form-check-input"
                                      id="male"
                                      name="gender"
                                      value="male"
                                      v-model="docDetail.user.gender"
                                      :checked="docDetail.user.gender == 'male'"
                                    />
                                    <label class="form-check-label" for="male"
                                      >Male</label
                                    >
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input
                                      type="radio"
                                      class="form-check-input"
                                      id="female"
                                      name="gender"
                                      value="female"
                                      v-model="docDetail.user.gender"
                                      :checked="
                                        docDetail.user.gender == 'female'
                                      "
                                    />
                                    <label class="form-check-label" for="female"
                                      >Female</label
                                    >
                                  </div>
                                </div>
                                <div
                                  class="invalid-feedback"
                                  v-if="$v.user.gender.$error"
                                >
                                  <span>
                                    {{ $v.user.gender.$errors[0].$message }}
                                  </span>
                                </div>
                              </div>
                              <div class="d-flex justify-content-end">
                                <primaryBtn
                                  label="Update"
                                  :click-event="validateBeforeSubmit"
                                />
                              </div>
                            </div>
                          </div>

                          <div class="account-information">
                            <h4
                              class="text-color-700 fw-semibold m-0 mb-4 mt-4"
                            >
                              Account Information
                            </h4>
                            <div class="row">
                              <div class="col-6 mb-3">
                                <div class="row">
                                  <div class="col-12 mb-3">
                                    <label
                                      for="center"
                                      class="fw-semibold mb-2 text-color-900 label-txt"
                                      >Center</label
                                    >
                                    <select
                                      v-model="selectedCenter"
                                      class="form-select form-select-global"
                                    >
                                      <option value="" disabled>
                                        Select a Center
                                      </option>
                                      <option
                                        v-for="center in centers"
                                        :key="center.id"
                                        :value="center.id"
                                      >
                                        {{ center.name }}
                                      </option>
                                    </select>
                                  </div>

                                  <div class="col-12 mb-3">
                                    <label
                                      for="department"
                                      class="fw-semibold mb-2 text-color-900 label-txt"
                                      >Department</label
                                    >
                                    <select
                                      v-model="selectedDepartment"
                                      class="form-select form-select-global"
                                      :disabled="!departments.length"
                                    >
                                      <option value="" disabled>
                                        Select a Department
                                      </option>
                                      <option
                                        v-for="department in departments"
                                        :key="department.id"
                                        :value="department.id"
                                      >
                                        {{ department.name }}
                                      </option>
                                    </select>
                                  </div>

                                  <div class="col-12 mb-3">
                                    <label
                                      for="specialty"
                                      class="fw-semibold mb-2 text-color-900 label-txt"
                                      >Specialty</label
                                    >
                                    <select
                                      v-model="selectSpecialist"
                                      class="form-select form-select-global"
                                    >
                                      <option value="" disabled>
                                        Select a Specialty
                                      </option>
                                      <option
                                        v-for="specialty in specialties"
                                        :key="specialty.id"
                                        :value="specialty.id"
                                      >
                                        {{ specialty.name }}
                                      </option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-6">
                                <div class="mb-4">
                                  <label
                                    for=""
                                    class="fw-semibold mb-2 text-color-900 label-txt"
                                    >languages</label
                                  >
                                  <select
                                    ref="select"
                                    multiple
                                    id="language-select"
                                  >
                                    <option
                                      v-for="lang in languages"
                                      :key="lang"
                                      :value="lang"
                                    >
                                      {{ lang }}
                                    </option>
                                  </select>
                                </div>
                                <div class="mb-4">
                                  <label
                                    for="author"
                                    class="fw-semibold mb-2 text-color-900 label-txt"
                                    >Authorize author</label
                                  >
                                  <div class="d-flex column-gap-5">
                                    <span>Allow doctor to publish article</span>
                                    <div class="form-check form-switch">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="author"
                                        :checked="isAuthor"
                                        @change="useDoctorStore.toggleAuthor"
                                      />
                                    </div>
                                  </div>
                                </div>
                                <div>
                                  <label
                                    for="publishAccount"
                                    class="fw-semibold mb-2 text-color-900 label-txt"
                                    >Publish Account</label
                                  >
                                  <div class="d-flex column-gap-5">
                                    <span>Allow acccount to be use</span>
                                    <div class="form-check form-switch">
                                      <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        id="author"
                                        :checked="isVerified"
                                        @change="useDoctorStore.toggleVerified"
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end">
                    <primaryBtn label="Update" :click-event="getDocAcc" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <doctorModalView />
</template>
<script setup>
import loadingView from "@/components/loadingView.vue";
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import primaryBtn from "@/components/layouts/primaryBtn.vue";
import doctorModalView from "@/components/layouts/doctorModal/doctorModalView.vue";
import { doctorStore } from "@/stores/doctorStore";
import { useNotyfStore } from "@/stores/notyfStore";
import { computed, onMounted, ref, watch, nextTick } from "vue";
import TomSelect from "tom-select";
import axios from "axios";
import useVuelidate from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";

const notfy = useNotyfStore();
const useDoctorStore = doctorStore();

const isVerified = computed(() => useDoctorStore.doctor.user.is_verify);
const isAuthor = computed(() => useDoctorStore.doctor.user.is_author);
const docDetail = computed(() => useDoctorStore.doctor);

const avatarUrl = ref(null);

// const previewAvatar = (event) => {
//   const file = event.target.files[0];
//   if (file && file.type.startsWith("image/")) {
//     avatarUrl.value = URL.createObjectURL(file);
//   } else {
//     alert("Please upload a valid image file.");
//   }
// };
const previewAvatar = (event) => {
  const file = event.target.files[0];
  if (file) {
    useDoctorStore.doctorAvatar = file;
    avatarUrl.value = URL.createObjectURL(file);
    // v$.value.user.avatar.$touch(); // Trigger validation
  }
};

const removeAvatar = () => {
  URL.revokeObjectURL(avatarUrl.value);
  avatarUrl.value = null;
};
const selectedCenter = ref("");
const selectedDepartment = ref("");
const selectSpecialist = ref("");
const centers = ref([]);
const departments = ref([]);
const specialties = computed(() => useDoctorStore.data);

const fetchCenters = async () => {
  try {
    const response = await axios.get("/api/centers");
    centers.value = response.data.data;
  } catch (error) {
    // console.error("Error fetching centers:", error);
  }
};

watch(selectedCenter, async (newCenter) => {
  selectedDepartment.value = "";
  departments.value = [];
  if (!newCenter) return;
  try {
    const response = await axios.get(`/api/departments?center_id=${newCenter}`);
    departments.value = response.data.data;
  } catch (error) {
    // console.error("Error fetching departments:", error);
  }
});
const noThumbnailPattern = /no_avatar\.jpg$/i;

const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;

    useDoctorStore.doctor = null;
    await useDoctorStore.getDocDetail();
    useDoctorStore.getDataSpacailist();

    if (!noThumbnailPattern.test(useDoctorStore.doctor.user.avatar)) {
      avatarUrl.value = useDoctorStore.doctor.user.avatar;
    }
    await fetchCenters();
    if (useDoctorStore.doctor.center.id) {
      selectedCenter.value = useDoctorStore.doctor.center.id;
    }
    if (useDoctorStore.doctor.department.id) {
      selectedDepartment.value = useDoctorStore.doctor.department.id;
    }
    if (useDoctorStore.doctor.specialist.id) {
      selectSpecialist.value = useDoctorStore.doctor.specialist.id;
    }
    if (useDoctorStore.doctor.user.languages) {
      selectedLanguages.value = useDoctorStore.doctor.user.languages;
    }
    await nextTick();

    nextTick(() => {
      tom = new TomSelect(select.value, {
        maxItems: 3,
        plugins: ["dropdown_input", "remove_button"],
        sortField: { field: "text", direction: "asc" },
        render: {
          item: (data, escape) => `
            <div class="custom-tag" data-value="${escape(data.value)}">
              ${escape(data.text)}
			  </div>`,
        },
      });
      tom.setValue(selectedLanguages.value);
      tom.on("item_add", () => {
        selectedLanguages.value = tom.getValue();
      });
    });
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
const selectedLanguages = ref([]);
const select = ref(null);
let tom = null;

watch(selectedLanguages, (newValues) => {
  if (tom) {
    tom.setValue(newValues);
  }
});
const languages = [
  "Arabic",
  "Bengali",
  "Chinese",
  "Dutch",
  "English",
  "Filipino",
  "French",
  "German",
  "Greek",
  "Gujarati",
  "Hebrew",
  "Hindi",
  "Hungarian",
  "Indonesian",
  "Italian",
  "Japanese",
  "Javanese",
  "Kannada",
  "Korean",
  "Malay",
  "Malayalam",
  "Marathi",
  "Persian",
  "Polish",
  "Portuguese",
  "Punjabi",
  "Romanian",
  "Russian",
  "Spanish",
  "Swahili",
  "Swedish",
  "Tamil",
  "Telugu",
  "Thai",
  "Turkish",
  "Ukrainian",
  "Urdu",
  "Vietnamese",
  "Zulu",
  "Khmer",
];

async function getDocAcc() {
  let error = 0;

  selectedCenter.value
    ? (useDoctorStore.doctor.center.id = selectedCenter.value)
    : (error = 1);
  selectedDepartment.value
    ? (useDoctorStore.doctor.department.id = selectedDepartment.value)
    : (error = 1);
  selectSpecialist.value
    ? (useDoctorStore.doctor.specialist.id = selectSpecialist.value)
    : (error = 1);
  console.log(useDoctorStore.doctor.user.languages);
  selectedLanguages.value
    ? (useDoctorStore.doctor.user.languages = selectedLanguages.value)
    : (error = 1);
  console.log(useDoctorStore.doctor.user.languages);

  if (error != 0) {
    notfy.warning("Please Check Information again");
    return;
  }
  await useDoctorStore.onClickUpdateDoctorProfile();
}

const alphaOnly = (value) => /^[A-Za-z\s]+$/.test(value);
const rules = computed(() => ({
  user: {
    fullname: {
      required: helpers.withMessage("Please enter full name", required),
      alphaOnly: helpers.withMessage("Only letters are allowed", alphaOnly),
    },
    local_fullname: {
      required: helpers.withMessage("Please enter full name (Khmer)", required),
    },
    email: {
      required: helpers.withMessage("Please enter email", required),
      email: helpers.withMessage("Invalid email format", email),
    },
    phone: {
      required: helpers.withMessage("Please enter phone number", required),
    },
    gender: {
      required: helpers.withMessage("Please select a gender", required),
    },
    avatar: {
      required: helpers.withMessage("Please upload an avatar", required),
    },
  },
}));

const $v = useVuelidate(rules, useDoctorStore);
const validateBeforeSubmit = async () => {
  $v.value.user.fullname.$touch();
  $v.value.user.local_fullname.$touch();
  $v.value.user.email.$touch();
  $v.value.user.phone.$touch();
  $v.value.user.gender.$touch();
  $v.value.user.avatar.$touch();
  const relevantErrors = $v.value.$errors.filter((err) =>
    [
      "fullname",
      "local_fullname",
      "email",
      "phone",
      "gender",
      "avatar",
    ].includes(err.$property)
  );
  if (relevantErrors.length > 0) {
    console.log("Validation errors:", relevantErrors);
    notfy.warning("Missing input");
    return;
  }
  await useDoctorStore.onClickUpdateDoctorAccount();
};
</script>
