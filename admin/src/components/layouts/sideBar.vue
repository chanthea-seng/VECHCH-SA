<template>
  <div class="sidebar bg-white">
    <div class="mb-4">
      <RouterLink to="/dashboard">
        <img src="@/assets/img/logo-vcs.png" alt="" class="navbrand" />
      </RouterLink>
    </div>
    <ul class="list-group">
      <h4>Overall Management</h4>
      <li class="list-group-item">
        <RouterLink
          to="/dashboard"
          :class="{ active: route.name == 'dashboard' }"
        >
          <span>
            <i class="bi bi-clipboard-data"></i>
            Overview
          </span>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/appointment"
          :class="{ active: route.name == 'appointment' }"
        >
          <span>
            <i class="bi bi-calendar2-plus"></i>
            Appointment
          </span>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/calendar"
          :class="{ active: route.name == 'calendar' }"
        >
          <span>
            <i class="bi bi-calendar-week"></i>
            Calendar
          </span>
        </RouterLink>
      </li>
    </ul>
    <ul class="list-group">
      <h4>Management</h4>
      <li class="list-group-item">
        <RouterLink to="/doctor" :class="{ active: route.name == 'doctor' }">
          <span>
            <i class="fa-light fa-users-medical"></i>
            Doctor
          </span>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink to="/service" :class="{ active: route.name == 'service' }">
          <span>
            <i class="bi bi-calendar2-plus"></i>
            Service
          </span>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink to="/content" :class="{ active: route.name == 'content' }">
          <span>
            <i class="fa-light fa-display-medical"></i> Article/ Disease
          </span>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/patient-information"
          :class="{ active: route.name == 'patient-information' }"
        >
          <span>
            <i class="fa-light fa-hospital-user"></i> Patient Information
          </span>
        </RouterLink>
      </li>
    </ul>
    <ul class="list-group">
      <h4>Other</h4>
      <li class="list-group-item">
        <RouterLink to="/contact" :class="{ active: route.name == 'contact' }">
          <span> <i class="fa-light fa-address-book"></i> Contact </span>
        </RouterLink>
      </li>
    </ul>
    <hr />
    <ul class="list-group gap-0">
      <li class="list-group-item">
        <RouterLink to="/profile" :class="{ active: route.name == 'profile' }">
          <span> <i class="bi bi-person-circle"></i>Admin </span>
        </RouterLink>
      </li>
      <hr />
      <li class="list-group-item">
        <a role="button" @click="openModal()">
          <span> <i class="bi bi-box-arrow-in-left"></i>Sign out</span>
        </a>
      </li>
    </ul>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="Sign Out. Are you sure to sign out?"
    @confirm="confirmSignout"
  />
</template>
<script setup>
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/userAuthStore";
import { useNotyfStore } from "@/stores/notyfStore";
import { onMounted, ref } from "vue";
import router from "@/router";
import mdlConfirm from "./mdlConfirm.vue";
import axios from "axios";
const route = useRoute();
const authStore = useAuthStore();
const notfy = useNotyfStore();
const modalRef = ref(null);

const openModal = () => {
  modalRef.value.openModal();
};

async function confirmSignout() {
  await authStore.loadToken(); // Ensure token is loaded before proceeding

  if (!authStore.token) {
    notfy.error("No token found, already signed out.");
    return;
  }

  try {
    const response = await axios.post(
      "api/auth/logout",
      {}, // Empty body if no data is needed
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );

    authStore.clearToken();
    notfy.success("Sign Out Success!");
    router.push("/");
  } catch (error) {
    notfy.error("Sign Out Failed");
  }
}

onMounted(async () => {});
</script>
