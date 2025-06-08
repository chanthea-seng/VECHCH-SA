<template>
  <div class="modal fade" id="mdlCreateService" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content p-5 rounded-4">
        <div class="modal-header p-0 border-0">
          <button
            type="button"
            class="btn-close"
            aria-label="Close"
            @click="onClickCloseMdl()"
          ></button>
        </div>
        <div class="modal-body p-0">
          <div>
            <div class="row row-gap-3">
              <div class="col-12">
                <h4 class="fw-semibold text-color-800">Enter Sub Service</h4>
                <span>Input service in both languages</span>
              </div>
              <div class="col-12">
                <div class="form-custom">
                  <label for="description" class="fw-medium text-grey mb-2">
                    English <small class="text-red">*</small>
                  </label>
                  <input
                    id="description"
                    type="text"
                    class="pb-5"
                    v-model="useCreateService.description"
                    placeholder="English"
                    :class="{ 'is-invalid': $v.description.$error }"
                    @blur="$v.description.$touch()"
                  />
                  <div v-if="$v.description.$error" class="invalid-feedback">
                    <span v-if="!$v.description.required"
                      >English description is required.</span
                    >
                    <span v-else-if="!$v.description.minLength"
                      >Must be at least 5 characters.</span
                    >
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-custom">
                  <label
                    for="localDescription"
                    class="fw-medium text-grey mb-2"
                  >
                    Khmer <small class="text-red">*</small>
                  </label>
                  <input
                    id="localDescription"
                    type="text"
                    class="pb-5"
                    v-model="useCreateService.local_description"
                    placeholder="Khmer"
                    :class="{ 'is-invalid': $v.local_description.$error }"
                    @blur="$v.local_description.$touch()"
                  />
                  <div
                    v-if="$v.local_description.$error"
                    class="invalid-feedback"
                  >
                    <span v-if="!$v.local_description.required"
                      >Khmer description is required.</span
                    >
                    <span v-else-if="!$v.local_description.minLength"
                      >Must be at least 5 characters.</span
                    >
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-custom">
                  <label for="price" class="fw-medium text-grey mb-2">
                    Price <small class="text-red">*</small>
                  </label>
                  <input
                    id="price"
                    type="number"
                    v-model="useCreateService.price"
                    placeholder="Price in USD"
                    :class="{ 'is-invalid': $v.price.$error }"
                    @blur="$v.price.$touch()"
                    step="0.01"
                  />
                  <div v-if="$v.price.$error" class="invalid-feedback">
                    <span v-if="!$v.price.required">Price is required.</span>
                    <span v-else-if="!$v.price.numeric"
                      >Must be a valid number.</span
                    >
                    <span v-else-if="!$v.price.minValue"
                      >Price must be at least 0.</span
                    >
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end mt-2">
                <primaryBtn
                  label="Confirm"
                  class="px-5"
                  :click-event="submitForm"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Modal } from "bootstrap";
import { onMounted } from "vue";
import { CreateService } from "@/stores/createService";
import primaryBtn from "../primaryBtn.vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, numeric, minValue } from "@vuelidate/validators";
import { useNotyfStore } from "@/stores/notyfStore";
const useCreateService = CreateService();
const notfy = useNotyfStore();
onMounted(() => {
  useCreateService.mdlCreateService = Modal.getOrCreateInstance(
    document.getElementById("mdlCreateService")
  );
  useCreateService.checkIfUpdate();
});

const onClickCloseMdl = () => {
  useCreateService.selectedId = 0;
  useCreateService.mdlCreateService.hide();
};
const rules = {
  description: { required, minLength: minLength(5) },
  local_description: { required, minLength: minLength(5) },
  price: { required, numeric, minValue: minValue(0) },
};

const $v = useVuelidate(rules, useCreateService);
const submitForm = async () => {
  $v.value.description.$touch();
  $v.value.local_description.$touch();
  $v.value.price.$touch();
  const relevantErrors = $v.value.$errors.filter((err) =>
    ["description", "local_description", "price"].includes(err.$property)
  );
  if (relevantErrors.length > 0) {
    notfy.warning("Missing input");
    return;
  }
  useCreateService.addSubService();
};
</script>
