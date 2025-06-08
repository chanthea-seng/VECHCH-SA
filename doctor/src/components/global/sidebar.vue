<template>
  <div class="sidebar py-2">
    <div class="mb-3">
      <RouterLink to="/dashboard">
        <img src="@/assets/image/logo-vcs.png" alt="" class="navbrand" />
      </RouterLink>
    </div>
    <ul class="list-group position-relative mt-3">
      <!-- <span class="label-list mb-1">គ្រប់គ្រងទូទៅ</span> -->
      <li class="list-group-item">
        <RouterLink
          to="/dashboard"
          class="w-100 position-relative"
          :class="{ active: route.name == 'dashboard' }"
        >
          <i
            class="fa-light fa-grid-2"
            :class="{
              'fa-duotone fa-solid fa-grid-2': route.name == 'dashboard',
            }"
          ></i>
          ទិដ្ឋភាពទូទៅ
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'dashboard' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/chat"
          class="w-100 position-relative"
          :class="{ active: route.name == 'chat' }"
        >
          <i
            class="fa-light fa-comments"
            :class="{ 'fa-duotone fa-solid fa-comments': route.name == 'chat' }"
          ></i>
          ផ្ញើរសារ
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'chat' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/calendar"
          class="w-100 position-relative"
          :class="{ active: route.name == 'calendar' }"
        >
          <i
            class="fa-light fa-calendar-lines-pen"
            :class="{
              'fa-duotone fa-solid fa-calendar-lines-pen':
                route.name == 'calendar',
            }"
          ></i>
          កាលវិភាគ
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'calendar' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/patient"
          class="w-100 position-relative"
          :class="{ active: route.name == 'patient' }"
        >
          <i
            class="fa-light fa-users-medical"
            :class="{
              'fa-duotone fa-solid fa-users-medical': route.name == 'patient',
            }"
          ></i>
          ព័ត៌មានអ្នកជំងឺ
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'patient' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink to="/article" :class="{ active: route.name == 'article' }">
          <i
            class="fa-light fa-pen-nib"
            :class="{
              'fa-duotone fa-solid fa-pen-nib': route.name == 'article',
            }"
          ></i>
          អត្ថបទ
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'article' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <RouterLink
          to="/accountSetting"
          :class="{ active: route.name == 'accountSetting' }"
        >
          <i
            class="fa-light fa-gear"
            :class="{ 'fa-solid fa-gear': route.name == 'accountSetting' }"
          ></i>
          គ្រប់គ្រងគណនី
          <div
            class="active-circle position-absolute end-0 opacity-0"
            :class="{ 'opacity-100': route.name == 'accountSetting' }"
          ></div>
        </RouterLink>
      </li>
      <li class="list-group-item">
        <a role="button" @click="openModal()">
          <span> <i class="bi bi-box-arrow-in-left pe-3"></i>ចេញពីគណនី</span>
        </a>
      </li>
    </ul>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="តើអ្នកប្រាកដថា​ ចង់ចាកចេញគណនីរបស់អ្នកមែនទេ?"
    @confirm="confirmSignout"
  />
</template>
<script setup>
import mdlConfirm from "./mdlConfirm.vue";
import router from "@/router";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/userAuthStore";
import { useNotyfStore } from "@/stores/notfyStore";
import axios from "axios";
const authStore = useAuthStore();
const route = useRoute();

const notfy = useNotyfStore();
const modalRef = ref(null);
const openModal = () => {
  modalRef.value.openModal();
};

async function confirmSignout() {
  authStore.loadToken();

  if (!authStore.token) {
    notfy.error("No token found, already signed out.");
    return;
  }

  try {
    const response = await axios.post(
      "/api/auth/logout",
      {}, // Empty body if no data is needed
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
        },
      }
    );
    localStorage.clear();
    sessionStorage.clear();
    authStore.token = null;
    notfy.success("ចាកចេញដោយជោគជ័យ!");
    router.push("/");
  } catch (error) {
    console.log(error);
    notfy.error("ចាកចេញមានបញ្ហា");
    // console.error("Signout error:", error);
  }
}
</script>
