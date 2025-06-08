<template>
  <Teleport to="body">
    <div ref="modalRef" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
          <div class="modal-body text-center">
            <div class="col-4 m-auto mb-2">
              <!-- <img src="@/assets/img/alert.png" class="img-fluid" alt="" /> -->
            </div>
            <p class="fw-medium text-secondary">{{ message }}</p>
          </div>
          <div class="d-flex justify-content-center column-gap-3">
            <primaryBtn
              label="បោះបង់"
              class="bg-btn-650"
              :click-event="closeModal"
            />
            <primaryBtn
              label="សម្រេច"
              class="bg-danger fw-medium"
              :click-event="confirmAction"
            />
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>
<style scope>
.bg-btn-650 {
  color: #728084;
  background-color: #dce4e6;
  font-weight: 500;
}
</style>
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
