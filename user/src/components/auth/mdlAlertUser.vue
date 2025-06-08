<template>
  <div class="modal fade" id="mdl-alert-user-login" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header d-flex text-center border-0 pt-4 px-4 pb-0"
        ></div>
        <div class="modal-body mt-0 p-4 pt-0">
          <div class="wrapper text-center my-3">
            <p class="mb-1 text-center fw-medium text-color-1000">
              តើអ្នកប្រាកដថា​ ចង់លុបគណនីរបស់អ្នកមែនទេ?
            </p>
            <span
              >ប្រសិនបើអ្នកចង់លុបគណនីរបស់អ្នក ទិន្នន័យ
              ព័ត៌មានទាំងអស់របស់អ្នកនិងត្រូវលុបជាអចិន្ត្រៃយ៌</span
            >
          </div>
          <div class="mx-auto">
            <a
              role="button"
              class="btn-bg-650 btn-delete mb-0 mt-0 me-3"
              data-bs-dismiss="modal"
              >បោះបង់</a
            >
            <a
              role="button"
              @click="onCLicklogout"
              class="btn-bg-650 btn-logout mb-0 px-3"
            >
              <i class="fa-solid fa-trash"></i> ចាកចេញ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { useAuthStore } from "@/stores/authTokenStore";
import { Modal } from "bootstrap";
import { onMounted } from "vue";
const authStore = useAuthStore();

onMounted(() => {
  authStore.mdlCheckToken = Modal.getOrCreateInstance(
    document.getElementById("mdl-alert-user-login")
  );
});

</script>
