<template>
  <div class="main">
    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>
        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="profile-container bg-white p-4 rounded-4" v-if="user">
              <div class="section-title mb-3">
                <h5 class="text-color-900">
                  <i class="bi bi-person-circle"></i> Account Overview
                </h5>
              </div>
              <div class="banner position-relative overflow-hidden">
                <div class="cicle"></div>
                <div class="cicle2"></div>
                <div
                  class="row position-relative z-3 align-items-center justify-content-between"
                ></div>
              </div>
              <div class="profile-card px-4">
                <div class="row g-0 column-gap-4 align-items-center">
                  <img :src="user.avatar" alt="" class="profile-img" />
                  <div class="profile-detail col-5">
                    <h3 class="fw-semibold text-white mb-3">
                      {{ user.fullname }}
                    </h3>
                    <div
                      class="d-flex justify-content-between text-color-900 fw-medium"
                    >
                      <span>Email: {{ user.email }}</span>
                      <span
                        >Role: {{ user.role_id == 1 ? "Admin" : "..." }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row px-4 g-0 row-gap-4 column-gap-5">
                <div>
                  <h5 class="text-color-900">Personal Information</h5>
                  <span class="">Edit your own profile information</span>
                </div>
                <div class="col-4">
                  <label for="name" class="mb-2">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="user.fullname"
                    disabled
                  />
                </div>

                <div class="col-4">
                  <label for="email" class="mb-2">email</label>
                  <input
                    type="email"
                    class="form-control"
                    v-model="user.email"
                    disabled
                  />
                </div>
              </div>
              <div class="px-4 pb-4">
                <hr />
                <div class="setting-card p-4">
                  <div>
                    <h5 class="text-color-800 fw-medium">Advance Setting</h5>
                    <span class="text-color-text">Change your password</span>
                  </div>
                  <div class="bg-white">
                    <button type="button" class="btn" disabled>
                      <i class="fa-light fa-key"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import { useAuthStore } from "@/stores/userAuthStore";
import { computed, onMounted } from "vue";

const authStore = useAuthStore();
authStore.loadToken();

const user = computed(() => authStore.userData);
onMounted(async () => {
  await authStore.onLoadGetMe();
});
</script>
