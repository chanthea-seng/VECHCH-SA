<template>
  <div
    class="section-header px-4 py-3 d-flex justify-content-between align-items-center"
  >
    <div class="title align-content-center">
      <h5 class="text-color-800 fw-medium m-0">
        {{ $route.meta.title }}
      </h5>
    </div>

    <div class="d-flex align-items-center">
      <RouterLink to="/chat" class="chat me-3">
        <i class="fa-light fa-comment"></i>
      </RouterLink>
      <div class="d-flex" v-if="user">
        <div class="avatar-wrapper">
          <img :src="user.avatar" alt="Doctor Avatar" class="avatar" />
        </div>
        <RouterLink
          to="/accountSetting"
          class="d-flex flex-column justify-content-start align-items-start ms-2"
        >
          <span class="mb-0 fw-medium doctor-name">
            {{ user.fullname }}
          </span>
          <small class="mb-0 email fw-medium">
            {{ user.email }}
          </small>
        </RouterLink>
      </div>
    </div>

    <!-- <div v-if="loginError" class="error-message text-danger">
      {{ loginError }}
    </div> -->
  </div>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/userAuthStore";
const authStore = useAuthStore();
const user = computed(() => authStore.userData);

onMounted(async () => {
  await authStore.checkIfDoctor();
});
</script>
