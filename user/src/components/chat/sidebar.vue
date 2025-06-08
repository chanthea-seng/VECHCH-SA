
<template>
    <div class="sidebar py-2">
      <div class="mb-3">
        <RouterLink to="/">
          <img src="/src//assets/img/new2.png" alt="" class="navbrand" />
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
      </ul>
    </div>
  </template>
  <script setup>
  import router from "@/router";
//   import { useAuthStore } from "@/stores/authstore";
  import { onMounted } from "vue";
  import { useRoute } from "vue-router";
  
  const route = useRoute();
  </script>
    