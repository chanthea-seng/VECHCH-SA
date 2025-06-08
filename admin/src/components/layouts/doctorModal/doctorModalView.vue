<template>
  <!-- Doctor Modal -->
  <div class="doctor-modal">
    <div
      class="modal fade"
      id="doctorMdl"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5" style="min-width: 900px !important">
          <div class="modal-body">
            <div class="doctor-contant-modal">
              <div class="doctor-title-modal mb-3 text-center">
                <h4 class="fw-bold text-color-800">Key Features</h4>
                <p class="m-0">
                  Open doctor account, input more speciality and department
                </p>
              </div>

              <div class="doctor-card content-type mb-4">
                <div class="row gy-0">
                  <div class="col-4">
                    <input
                      type="radio"
                      v-model="useDoctorStore.selectId"
                      id="card1"
                      name="account"
                      class="d-none radio-content"
                      value="1"
                    />
                    <label
                      for="card1"
                      class="card label-content-type border-0 d-flex justify-content-center align-items-center py-4 rounded-4"
                    >
                      <div
                        class="card-img d-flex justify-content-center align-items-center"
                      >
                        <img
                          src="@/assets/img/id-card.png"
                          class="img-fluid rounded mb-2"
                          alt=""
                        />
                      </div>
                      <span class="text-center">
                        Create Account For <br />
                        Doctor
                      </span>
                    </label>
                  </div>

                  <div class="col-4">
                    <input
                      type="radio"
                      v-model="useDoctorStore.selectId"
                      id="card2"
                      name="account"
                      class="d-none radio-content"
                      value="2"
                    />
                    <label
                      for="card2"
                      class="card label-content-type border-0 d-flex justify-content-center align-items-center py-4 rounded-4"
                    >
                      <div
                        class="card-img d-flex justify-content-center align-items-center"
                      >
                        <img
                          src="@/assets/img/stethoscope.png"
                          class="img-fluid rounded mb-2"
                          alt=""
                        />
                      </div>
                      <span class="text-center">Add Speciality And</span>
                    </label>
                  </div>

                  <div class="col-4">
                    <input
                      type="radio"
                      v-model="useDoctorStore.selectId"
                      id="card3"
                      name="account"
                      class="d-none radio-content"
                      value="3"
                    />
                    <label
                      for="card3"
                      class="card label-content-type border-0 d-flex justify-content-center align-items-center py-4 rounded-4"
                    >
                      <div
                        class="card-img d-flex justify-content-center align-items-center"
                      >
                        <img
                          src="../../../assets/img/medical-staff.png"
                          class="img-fluid rounded mb-2"
                          alt=""
                        />
                      </div>
                      <span class="text-center">
                        Add <br />
                        Department
                      </span>
                    </label>
                  </div>
                </div>
              </div>

              <primaryBtn
                label="Next"
                class="px-5 m-auto"
                :click-event="onclickSelectId"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Register Doctor -->
  <registerDoctorModalView />

  <!-- Modal Add Speciality -->
  <specialityModalView />

  <!-- Modal Add Department -->
  <addDepartment />
</template>

<script setup>
import primaryBtn from "../primaryBtn.vue";
import registerDoctorModalView from "@/components/layouts/doctorModal/registerDoctorModalView.vue";
import specialityModalView from "@/components/layouts/doctorModal/specialityModalView.vue";
import addDepartment from "@/components/layouts/doctorModal/addDepartment.vue";
import { doctorStore } from "@/stores/doctorStore";
import { onBeforeUnmount, onMounted } from "vue";
import { Modal } from "bootstrap";
const useDoctorStore = doctorStore();

onMounted(() => {
  useDoctorStore.doctorMdl = Modal.getOrCreateInstance(
    document.getElementById("doctorMdl")
  );
});
const onclickSelectId = () => {
  if (useDoctorStore.selectId == 1) {
    useDoctorStore.mdlRegister.show();
  } else if (useDoctorStore.selectId == 2) {
    useDoctorStore.mdlCreate.show();
    useDoctorStore.getDataSpacailist();
  } else {
    useDoctorStore.mdlDCreate.show();
    useDoctorStore.getDataDepartment();
    useDoctorStore.getDataCenter();
  }
  useDoctorStore.doctorMdl.hide();
};
</script>
