<template>
  <div class="doctor-modal">
    <div
      class="modal fade"
      id="addDepartmentModal"
      tabindex="-1"
      aria-labelledby="addDepartmentModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-5">
            <div class="add-department-modal">
              <div class="d-flex justify-content-between">
                <div class="add-title mb-4">
                  <h4 class="text-color-900 fw-bold">Add Department</h4>
                  Add a new department to organize doctor groups.
                </div>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  @click="onClickClear()"
                  aria-label="Close"
                ></button>
              </div>
              <div
                class="form-group d-flex justify-content-between align-items-center mb-3"
              >
                <input
                  type="text"
                  class="form-control-speciality me-2"
                  id="department-english"
                  v-model="useDoctorStore.dInputName"
                  placeholder="Enter English Name"
                />
                <input
                  type="text"
                  class="form-control-speciality me-2"
                  id="department-khmer"
                  v-model="useDoctorStore.dInputLocalName"
                  placeholder="Enter Khmer Name"
                />
                <button
                  type="button"
                  class="btn-save btn-primary align-content-center"
                  @click="useDoctorStore.onclickInsertDepartment()"
                >
                  Save <i class="bi bi-check2"></i>
                </button>
              </div>
              <div class="select-center mb-5" style="width: 40%">
                <select
                  class="form-select shadow-none"
                  aria-label="Default select example"
                  style="padding: 10px 0"
                  v-model="useDoctorStore.selectedCenter"
                >
                  <option
                    v-for="data in useDoctorStore.arrCenter"
                    :key="data.id"
                    :value="data.id"
                  >
                    {{ data.name }}
                  </option>
                </select>
              </div>
              <div class="row">
                <div
                  class="col-12"
                  v-for="item in useDoctorStore.data"
                  :key="item.id"
                >
                  <ul class="general-list list-unstyled">
                    <li class="d-flex justify-content-between">
                      <div
                        class="add-general col-10 d-flex justify-content-center align-items-center"
                      >
                        <i class="bi bi-dot me-2 text-color-700"></i>

                        <div class="d-flex w-100">
                          <p class="me-5 mb-0 limit-line-1 w-50">
                            {{ item.name }}
                          </p>
                          <p class="mb-0 limit-line-1 w-50">
                            {{ item.local_name }}
                          </p>
                        </div>
                      </div>
                      <div
                        class="add-general d-flex justify-content-center align-items-center"
                      >
                        <a role="button">
                          <i
                            class="bi bi-pen me-3"
                            @click="
                              useDoctorStore.onClickUpdateDepartment(item)
                            "
                          ></i>
                        </a>
                        <a role="button" @click="openModal(item.id)">
                          <i class="bi bi-trash"></i>
                        </a>
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
import { Modal } from "bootstrap";
import { onMounted, ref } from "vue";
import mdlConfirm from "../mdlConfirm.vue";
import { useNotyfStore } from "@/stores/notyfStore";
import axios from "axios";
const notyf = useNotyfStore();
const useDoctorStore = doctorStore();

onMounted(async () => {
  useDoctorStore.mdlDCreate = Modal.getOrCreateInstance(
    document.getElementById("addDepartmentModal")
  );
  await getCenter();
});
let selectId = 0;
const modalRef = ref(null);
const openModal = (id) => {
  selectId = id;
  console.log(selectId);
  modalRef.value.openModal();
};
const confirmDelete = async () => {
  useDoctorStore.onclickDeleteDepartment(selectId);
};
const onClickClear = () => {
  selectId = 0;
  useDoctorStore.inputName = "";
  useDoctorStore.inputLocalName = "";
  useDoctorStore.isUpdate = 0;
};
async function createDepartmentModal() {
  console.log("dName:", useDoctorStore.dName);
  console.log("dLocalName:", useDoctorStore.dLocalName);

  const formdata = new FormData();
  formdata.append("name", useDoctorStore.dName);
  formdata.append("local_name", useDoctorStore.dLocalName);
  try {
    const res = await axios.post("/api/departments", formdata, {
      headers: {
        Accept: "application/json",
        "Content-Type": "multipart/form-data",
      },
    });
  } catch (error) {
    console.error("Error creating department:", error.response?.data || error);
  }
}

async function getCenter() {
  try {
    const res = await axios.get("/api/centers");
    useDoctorStore.arrCenter = res.data.data;
  } catch (error) {
    console.error("Error getting centers:", error.response?.data || error);
  }
}
</script>
