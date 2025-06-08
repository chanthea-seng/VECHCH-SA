<template>
  <main>
    <Navbar />
    <div class="container py-4 mt-5">
      <div class="row">
        <div class="col-3">
          <sidebarProfileSetting />
        </div>
        <div class="col-9">
          <appointment />
        </div>
      </div>
      <Modalconfirmdeleteappoint />
      <ToastSuccsess />
      <ModalCancelbooking />
    </div>
    <FooterView />
  </main>
</template>

<script setup>
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import appointment from "@/components/views/setting/appointment.vue";
import Modalconfirmdeleteappoint from "@/components/layouts/Modalconfirmdeleteappoint.vue";
import ModalCancelbooking from "@/components/layouts/ModalCancelbooking.vue";
import ToastSuccsess from "@/components/layouts/ToastSuccsess.vue";
import sidebarProfileSetting from "@/components/layouts/sidebarProfileSetting.vue";
</script>
