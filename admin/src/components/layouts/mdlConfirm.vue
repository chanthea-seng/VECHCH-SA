<template>
  <Teleport to="body">
    <div ref="modalRef" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
          <div class="modal-body text-center">
            <div class="col-4 m-auto mb-2">
              <!-- <img src="@/assets/img/alert.png" class="img-fluid" alt="" /> -->
            </div>
            <h3 class="fw-bold text-color-800 text-danger">
              Confirmation <i class="fa-light fa-location-exclamation"></i>
            </h3>
            <p class="fw-medium text-secondary">{{ message }}</p>
          </div>
          <div class="d-flex justify-content-center column-gap-3">
            <!-- <button class="btn btn-primary" @click="">Confirm</button> -->
            <a role="button" class="pending-btn px-4" @click="closeModal">
              <span class="fw-medium">Cancel</span>
            </a>
            <primaryBtn
              label="Confirm"
              class="bg-danger"
              :click-event="confirmAction"
            />
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import primaryBtn from "./primaryBtn.vue";
import {
  ref,
  defineProps,
  defineExpose,
  onMounted,
  onUnmounted,
  defineEmits,
} from "vue";
import { Modal } from "bootstrap";
import { helpers } from "@vuelidate/validators";

const props = defineProps({
  message: String,
});

const emit = defineEmits(["confirm"]);

const modalRef = ref(null);
let bootstrapModal = null;

const openModal = () => {
  if (bootstrapModal) {
    bootstrapModal.show();
  }
};

const closeModal = () => {
  if (bootstrapModal) {
    bootstrapModal.hide();
  }
};

const confirmAction = () => {
  emit("confirm"); // Emit event instead of calling props.event
  closeModal();
};

onMounted(() => {
  bootstrapModal = new Modal(modalRef.value);
});

onUnmounted(() => {
  if (bootstrapModal) {
    bootstrapModal.dispose();
  }
});

defineExpose({ openModal });
</script>
