<template>
  <main>
    <loadingView v-if="pageLoading" />

    <div class="forgetpassword vh-100 position-relative overflow-hidden">
      <div class="container position-relative z-2 h-100">
        <div class="row h-100 justify-content-center align-items-center">
          <forgetpass class="card-forget forget" />
          <opt class="card-forget opt" />
          <newpassword class="card-forget newpassword" />
        </div>
      </div>
      <div class="bg-footer d-none d-lg-block"></div>
    </div>
  </main>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { forgetpassword } from "@/stores/authstore";
import forgetpass from "@/components/auth/forgetpass.vue";
import opt from "@/components/auth/opt.vue";
import newpassword from "@/components/auth/newpassword.vue";
import loadingView from "../loading/loadingView.vue";
import { useAuthStore } from "@/stores/authTokenStore";
const authForget = forgetpassword();
const authStore = useAuthStore();
const pageLoading = ref(true);
onMounted(() => {
  setTimeout(() => {
    authStore.loadToken();
    if (authStore.token) {
      router.go(-1);
    }
    authForget.forgetpass = document.querySelector(".forget");
    authForget.getopt = document.querySelector(".opt");
    authForget.resetnewpassword = document.querySelector(".newpassword");
    pageLoading.value = false;
  }, 1500);
});
</script>
