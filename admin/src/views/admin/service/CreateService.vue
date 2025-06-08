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
            <div class="content-container bg-white p-4 rounded-4">
              <div class="section-title mb-4">
                <h5 class="text-color-900">Create Service</h5>
              </div>
              <div class="account-information mb-3">
                <h4 class="text-color-700 fw-semibold">Main Service</h4>
              </div>

              <div class="row row-gap-3 mb-4">
                <!-- Input Image -->
                <div class="col-12">
                  <div class="d-flex justify-content-between mb-2">
                    <spansc class="text-grey fw-semibold">Service Image</spansc>
                    <a
                      role="button"
                      @click="useCreateService.clearImage()"
                      class="text-color-800 fw-medium"
                    >
                      <i class="bi bi-arrow-clockwise"></i> Click to change
                      image
                    </a>
                  </div>

                  <!-- Drag & Drop Area -->
                  <div class="border rounded-4 p-3 text-center">
                    <input
                      type="file"
                      class="d-none"
                      id="choose-image"
                      @change="useCreateService.handleFileUpload"
                      accept="image/*"
                      multiple
                    />
                    <label
                      for="choose-image"
                      class="label-choose-image p-3 column-gap-2"
                      id="drop-area"
                      @dragover.prevent="useCreateService.highlightDropArea"
                      @dragleave.prevent="useCreateService.removeHighlight"
                      @drop.prevent="useCreateService.handleDrop"
                    >
                      <div class="col-6 position-relative">
                        <img
                          v-if="useCreateService.previewImages.length"
                          :src="useCreateService.previewImages[0]"
                          class="main-preview position-relative z-2"
                        />
                        <p
                          v-if="!useCreateService.previewImages.length"
                          class="text-center position-absolute top-50 start-50 translate-middle z-1"
                        >
                          <i class="bi bi-file-earmark-arrow-up fs-4"></i>
                          Drag & Drop or Click to Choose Image (Max: 3MB,
                          PDF/JPG/PNG)
                        </p>
                      </div>
                      <div
                        class="col-6 d-flex justify-content-between row-gap-2 flex-wrap"
                      >
                        <img
                          v-for="(
                            img, index
                          ) in useCreateService.previewImages.slice(1)"
                          :key="index"
                          :src="img"
                          class="small-preview"
                        />
                      </div>
                    </label>
                  </div>

                  <p
                    v-if="useCreateService.errorMessage"
                    class="text-danger mt-2"
                  >
                    {{ useCreateService.errorMessage }}
                  </p>
                </div>

                <!-- choose service -->
                <div class="col-12">
                  <div class="mb-2">
                    <span class="text-grey fw-semibold"
                      >Choose service type
                      <small class="text-red">*</small></span
                    >
                  </div>
                  <div class="d-flex column-gap-3">
                    <label
                      class="card-radio"
                      :class="{
                        selectedRadio: useCreateService.selectedService == 1,
                      }"
                    >
                      <input
                        type="radio"
                        name="service"
                        value="1"
                        v-model="useCreateService.selectedService"
                      />
                      <div>
                        <p class="fw-medium m-0">Package</p>
                        <span>Service package for check-up</span>
                      </div>
                    </label>
                    <label
                      for="serviceVaccine"
                      class="card-radio"
                      :class="{
                        selectedRadio: useCreateService.selectedService == 2,
                      }"
                    >
                      <input
                        type="radio"
                        name="service"
                        id="serviceVaccine"
                        value="2"
                        v-model="useCreateService.selectedService"
                      />
                      <div>
                        <p class="fw-medium m-0">Vaccine</p>
                        <span>Service package for vaccine</span>
                      </div>
                    </label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="row row-gap-3">
                    <!-- title -->
                    <div class="col-6">
                      <div class="form-custom">
                        <label for="" class="fw-medium text-grey mb-2"
                          >Title in English
                          <small class="text-red">*</small></label
                        >
                        <input
                          type="text"
                          v-model="useCreateService.titleEn"
                          placeholder="English Title"
                        />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-custom">
                        <label for="" class="fw-medium text-grey mb-2"
                          >Title in Khmer
                          <small class="text-red">*</small></label
                        >
                        <input
                          type="text"
                          v-model="useCreateService.titleKm"
                          placeholder="Khmer Title"
                        />
                      </div>
                    </div>

                    <!-- description -->
                    <div class="col-6">
                      <div class="form-custom">
                        <label for="" class="fw-medium text-grey mb-2"
                          >Description in English
                          <small class="text-red">*</small></label
                        >
                        <textarea
                          type="text"
                          v-model="useCreateService.descriptionEn"
                          placeholder="Detail description"
                        />
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-custom">
                        <label for="" class="fw-medium text-grey mb-2"
                          >Description in Khmer
                          <small class="text-red">*</small></label
                        >
                        <textarea
                          type="text"
                          v-model="useCreateService.descriptionKm"
                          placeholder="Detail description"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="account-information mb-3">
                <h4 class="text-color-700 fw-semibold">Sub Service</h4>
              </div>

              <div class="d-flex align-items-center column-gap-2 mb-3">
                <div>
                  <span class="fw-medium text-grey">Add Sub service</span>
                </div>
                <a
                  role="button"
                  class="btn-add-service"
                  @click="onClickCreateMdl()"
                >
                  <span> <i class="bi bi-plus"></i> </span
                ></a>
              </div>

              <div class="row row-gap-3">
                <div
                  class="sub-service-card"
                  v-for="sub in useCreateService.subService"
                  :key="sub.id"
                >
                  <div class="col-1">
                    <span class="fw-medium text-color-900"
                      >Type: {{ sub.id }}</span
                    >
                  </div>
                  <div class="col-4">
                    <span class="text-grey limit-line-1">{{
                      sub.description
                    }}</span>
                  </div>

                  <div class="col-4">
                    <span class="text-grey limit-line-1">{{
                      sub.local_description
                    }}</span>
                  </div>
                  <div class="col-1">
                    <span>$ {{ sub.price }}</span>
                  </div>
                  <div class="col-2">
                    <div class="d-flex justify-content-between">
                      <div class="form-check form-switch">
                        <input
                          class="form-check-input"
                          type="checkbox"
                          role="switch"
                          id="flexSwitchCheckChecked"
                          :checked="sub.is_active == 1"
                          @change="useCreateService.toggleStatus(sub.id)"
                        />
                      </div>

                      <div class="group-btn">
                        <a
                          role="button"
                          class="btn-edit"
                          @click="EditSub(sub.id)"
                        >
                          <span><i class="bi bi-pen"></i></span>
                        </a>

                        <a
                          role="button"
                          class="btn-edit"
                          @click="RemoveSub(sub.id)"
                        >
                          <span><i class="bi bi-trash3"></i></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-2">
                  <primaryBtn
                    label="Create"
                    class="px-5"
                    :click-event="useCreateService.onClickCreateService"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <dynamicForm />
</template>

<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import primaryBtn from "@/components/layouts/primaryBtn.vue";
import dynamicForm from "@/components/layouts/dynamicForm/dynamicForm.vue";
import { CreateService } from "@/stores/createService";
const useCreateService = CreateService();
const onClickCreateMdl = () => {
  useCreateService.clearInput();
  useCreateService.mdlCreateService.show();
};
const EditSub = (id) => {
  useCreateService.selectedId = id;
  useCreateService.checkIfUpdate();
  useCreateService.mdlCreateService.show();
};

const RemoveSub = (id) => {
  useCreateService.selectedId = id;
  useCreateService.RemoveSub();
};
</script>
