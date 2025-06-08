<template>
  <!-- Modal Speciality doctor -->
  <div class="doctor-modal">
    <div
      class="modal fade"
      id="addSpecailyModal"
      tabindex="-1"
      aria-labelledby="addSpecailyModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body p-5">
            <div class="add-specaily-modal">
              <div class="d-flex justify-content-between">
                <div class="add-title mb-4">
                  <h4 class="text-color-900 fw-bold">Add Speciality</h4>
                  Add more type of speciality for to show off doctor skill.
                </div>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                  @click="onClickClear()"
                ></button>
              </div>
              <div
                class="form-group d-flex justify-content-between align-items-center mb-3"
              >
                <input
                  style="width: 42%"
                  type="text"
                  class="form-control-speciality me-2"
                  id="speciality"
                  v-model="useDoctorStore.inputName"
                  placeholder="Enter english"
                />
                <input
                  style="width: 42%"
                  type="text"
                  class="form-control-speciality me-2"
                  id="speciality"
                  v-model="useDoctorStore.inputLocalName"
                  placeholder="Enter khmer"
                />
                <primaryBtn
                  class="px-3"
                  :click-event="useDoctorStore.onclickInsert"
                  label='Save <i class="bi bi-check2"></i>'
                />
              </div>
              <div class="row g-0">
                <div
                  class="col-12 p-0"
                  v-for="item in useDoctorStore.data"
                  :key="item.id"
                >
                  <ul class="general-list list-unstyled">
                    <li class="d-flex justify-content-between">
                      <div class="add-general col-10 d-flex align-items-center">
                        <i class="bi bi-dot me-2 text-color-600"></i>
                        <div class="d-flex w-100">
                          <p class="mb-0 me-5 limit-line-1 w-50">
                            {{ item.name }}
                          </p>
                          <p class="mb-0 limit-line-1 w-50">
                            {{ item.local_name }}
                          </p>
                        </div>
                      </div>
                      <div
                        class="add-general col-1 d-flex justify-content-center align-items-center"
                      >
                        <a role="button"
                          ><i
                            class="bi bi-pen me-3"
                            @click="useDoctorStore.onClickUpdate(item)"
                          ></i
                        ></a>
                        <a role="button" @click="openModal(item.id)"
                          ><i class="bi bi-trash"></i
                        ></a>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <mdlConfirm
    ref="modalRef"
    message="Reminder? Are you sure to delete!"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import { doctorStore } from "@/stores/doctorStore";
import mdlConfirm from "../mdlConfirm.vue";
import primaryBtn from "../primaryBtn.vue";
import axios from "axios";
import { Modal } from "bootstrap";
import { onMounted, ref } from "vue";
const useDoctorStore = doctorStore();
let selectId = 0;
const modalRef = ref(null);
const openModal = (id) => {
  selectId = id;
  modalRef.value.openModal();
};
const confirmDelete = async () => {
  useDoctorStore.onclickDelete(selectId);
};
onMounted(() => {
  useDoctorStore.mdlCreate = Modal.getOrCreateInstance(
    document.getElementById("addSpecailyModal")
  );
});
const onClickClear = () => {
  selectId = 0;
  useDoctorStore.inputName = "";
  useDoctorStore.inputLocalName = "";
  useDoctorStore.isUpdate = 0;
};
// async function onclickCreate() {
//   console.log(useDoctorStore.name);
//   console.log(useDoctorStore.localName);

//   const formdata = new FormData();
//   formdata.append("name", useDoctorStore.name);
//   formdata.append("local_name", useDoctorStore.localName);

//   try {
//     const res = await axios.post("/api/specialists", formdata, {
//       headers: { "Content-Type": "multipart/form-data" },
//     });
//     console.log(res.data.data);
//   } catch (error) {
//     console.error("Error creating specialist:", error.response?.data || error);
//   }
// }
</script>
