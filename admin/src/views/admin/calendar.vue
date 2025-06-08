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
            <div class="title">
              <h5 class="text-color-900 fw-medium">Appointment Calendar</h5>
            </div>
            <div class="calendar-container bg-white p-4 rounded-4">
              <calendar />
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
import calendar from "@/components/layouts/calendar/calendar.vue";
</script>
