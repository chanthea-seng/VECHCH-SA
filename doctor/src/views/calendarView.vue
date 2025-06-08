<template>
  <main class="bg-main">
    <div class="container-fluid p-0">
      <div class="row justify-content-between position-relative g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />
          <div class="row p-4 pe-0 g-0">
            <calendar />
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="row ">
      <sidebar />
      <div class="col-10 p-0">
        <navhead />
        <div class="row p-4 g-0">
          <calendar />
        </div>
      </div>
    </div> -->
  </main>
</template>
<script setup>
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import calendar from "@/components/calendar/calendar.vue";
</script>
