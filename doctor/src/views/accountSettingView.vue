<template>
  <main class="bg-main accSetting">
    <div class="container-fluid p-0">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div class="col-10 p-0">
          <navhead />
          <div class="row p-4 g-0">
            <GeneralInformation />
            <BiographyManage />
            <eduExperience />
            <DoctorExperience />
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import { useRouter } from "vue-router";
import GeneralInformation from "@/components/accSetting/GeneralInformation.vue";
import BiographyManage from "@/components/accSetting/BiographyManage.vue";
import eduExperience from "@/components/accSetting/eduExperience.vue";
import DoctorExperience from "@/components/accSetting/doctorExperience.vue";
</script>
<style scope>
.card {
  border-radius: 12px;
  /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
  border: 1px solid #eceded;
}
</style>
