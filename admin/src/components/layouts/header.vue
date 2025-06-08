<template>
  <div
    class="section-header p-0 d-flex justify-content-between align-items-center"
  >
    <h4 class="text-gradient text-capitalize fw-semibodl m-0">
      {{ $route.meta.body }}
    </h4>
    <div class="border-left" v-if="user">
      <RouterLink to="/profile" class="d-flex column-gap-2 align-items-center">
        <img :src="user.avatar" alt="" class="img-control" />
        <div class="align-content-center">
          <p class="m-0 fw-medium text-color-900">{{ user.fullname }}</p>
          <small class="text-color-950">{{ user.email }}</small>
        </div>
      </RouterLink>
    </div>
  </div>
</template>
<script setup>
import { useAuthStore } from "@/stores/userAuthStore";
import { computed, onMounted } from "vue";

const authStore = useAuthStore();
const user = computed(() => authStore.userData);
onMounted(async () => {
  authStore.loadToken();
  if (!(await authStore.checkIfAdmin())) {
    window.location.reload();

    router.push("/");
    return;
  }
});
</script>
