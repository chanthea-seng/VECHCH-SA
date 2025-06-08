<template>
  <div class="col-12">
    <loadingView v-if="pageLoading" />

    <div class="row g-0">
      <div class="col-9">
        <div class="doctor-wrapper-card" v-if="useSetting">
          <span class="title">ព័ត៌មានផ្ទាល់ខ្លួន</span>
          <ul class="nav doctor-info w-100">
            <li class="nav-item">
              <div class="label">
                <i class="fa-light fa-user"></i>
                <span>ឈ្មោះសមីខ្លួន</span>
              </div>
              <div class="value">
                {{ useSetting.local_fullname || "មិនមានទិន្នន័យ" }}
              </div>
            </li>
            <li class="nav-item">
              <div class="label">
                <i class="fa-light fa-language"></i>
                <span>ឈ្មោះជាអក្សរឡាតាំង</span>
              </div>
              <div class="value">
                {{ useSetting.fullname || "មិនមានទិន្នន័យ" }}
              </div>
            </li>
            <li class="nav-item">
              <div class="label">
                <i class="fa-light fa-envelope"></i>
                <span>អាស័យដ្ធានអីម៉ែល</span>
              </div>
              <div class="value">
                {{ useSetting.email || "មិនមានទិន្នន័យ" }}
              </div>
            </li>
            <li class="nav-item">
              <div class="label">
                <i class="fa-light fa-phone"></i>
                <span>លេខទូរស័ព្ទ</span>
              </div>
              <div class="value">
                {{ useSetting.phone_number || "មិនមានទិន្នន័យ" }}
              </div>
            </li>
            <li class="nav-item mb-0">
              <div class="label">
                <i class="fa-light fa-venus-mars"></i>
                <span>ភេទ</span>
              </div>
              <div class="value">
                {{ useSetting.gender || "មិនមានទិន្នន័យ" }}
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-3 ps-3" v-if="useSetting">
        <div class="card">
          <div class="card-avatar p-5">
            <img :src="useSetting.avatar" alt="" />
            <span>
              {{ useSetting.bio }}
            </span>
            <div class="mt-3">
              <span class="text-italic text-secondary fw-medium"
                >ប្រសិនបើព័ត៌មានណាមួយមិនត្រឹមត្រូវ សូមទាក់ទងអ្នកគ្រប់គ្រង</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-9 mt-4" v-if="useSetting">
    <div class="doctor-wrapper-card">
      <span class="title">ព័ត៌មានការងារ</span>
      <ul class="nav doctor-info w-100">
        <li class="nav-item">
          <div class="label">
            <i class="fa-light fa-lightbulb-on"></i>
            <span>ឯកទេសជំនាញ</span>
          </div>
          <div class="value">
            {{ useSetting.doctor_profile.specialist_name || "មិនមានទិន្នន័យ" }}
          </div>
        </li>
        <li class="nav-item">
          <div class="label">
            <i class="fa-light fa-building"></i>
            <span>នាយកដ្ឋាន</span>
          </div>
          <div class="value">
            {{ useSetting.doctor_profile.department_name || "មិនមានទិន្នន័យ" }}
          </div>
        </li>
        <li class="nav-item">
          <div class="label">
            <i class="fa-light fa-display-medical"></i>
            <span>ការិយាល័យ</span>
          </div>
          <div class="value">
            {{ useSetting.doctor_profile.center_name || "មិនមានទិន្នន័យ" }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import loadingView from "../global/loadingView.vue";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
const authStore = useAuthStore();
const useSetting = computed(() => authStore.userData);
const loginError = ref(null);
const pageLoading = ref(true);
onMounted(async () => {
  //   useSetting.loadToken();
  //   fetchDoctorProfile();
  try {
    await authStore.checkIfDoctor();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

// const fetchDoctorProfile = async () => {
//   try {
//     const { data } = await axios.get("/api/auth/me", {
//       headers: { Authorization: `Bearer ${useSetting.token}` },
//     });
//     useSetting.setData(data);
//     // console.log("Doctor profile:", useSetting.userData.user.doctor_profile.center_name);
//     // console.log("Doctor profile:", data);
//   } catch (error) {
//     loginError.value =
//       error.response?.data?.message || "Failed to fetch profile.";
//     console.error("Fetch error:", error);
//   }
// };
</script>
<style scope>
.card-avatar {
  text-align: center;
}
.card-avatar img {
  border: 3px solid #dadadada;
  --size: 100px;
  height: var(--size);
  width: var(--size);
  border-radius: 100%;
  object-fit: cover !important;
}
</style>
