<template>
  <main class="main">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar />
        </div>

        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div
              class="doctor-container d-flex justify-content-between align-items-center mb-4"
            >
              <div class="col-3">
                <select
                  name="cate"
                  id="cate"
                  class="form-select form-select-global"
                  placeholder="Choose specialist"
                  v-model="useDoctorStore.filter.specialist"
                  @change="useDoctorStore.getDoctor()"
                >
                  <option
                    v-for="item in specialist"
                    :key="item.id"
                    :value="item.id"
                  >
                    {{ item.name }}
                  </option>
                </select>
              </div>
              <div
                class="d-flex align-items-center align-content-center column-gap-3"
              >
                <div>
                  <input
                    type="search"
                    class="search-input"
                    placeholder="search doctor name"
                    v-model="useDoctorStore.filter.inputSearch"
                    @input="useDoctorStore.getDoctor()"
                  />
                </div>
                <div
                  class="setting-doctor d-flex justify-content-center align-items-center"
                  @click="onClickBigModal()"
                >
                  <i class="bi bi-plus"></i>
                </div>
              </div>
            </div>
            <div class="list-doctor">
              <div class="row g-3">
                <div
                  class="col-3 ps-0 pe-3"
                  v-for="doctor in doctors"
                  :key="doctor.id"
                >
                  <div class="card">
                    <div class="card-body p-4 mt-3 text-center">
                      <div class="card-image m-auto mb-3">
                        <img :src="doctor.user.avatar" alt="avatar" />
                      </div>
                      <div class="sec-title">
                        <h5 class="text-color-900 mb-4">
                          {{ doctor.user.fullname || doctor.user.local_name }}
                        </h5>
                        <span class="doc-spicalize">
                          {{
                            doctor.specialist.name ||
                            doctor.specialist.local_name
                          }}
                        </span>
                      </div>
                    </div>
                    <div
                      class="card-footer px-4 py-0 d-flex justify-content-between mt-3"
                    >
                      <a
                        @click="useDoctorStore.onClickDoctorDetail(doctor.id)"
                        class="card-book d-flex align-items-center text-color-900 text-decoration-none"
                        role="button"
                      >
                        <span
                          ><i class="fa-regular fa-calendar-range"></i
                        ></span>
                        <p class="ms-2 mb-0 fs-6 fw-medium">Appointment</p>
                      </a>
                      <div class="divider"></div>
                      <a
                        class="card-info d-flex align-items-center text-color-900 text-decoration-none"
                        role="button"
                        @click="useDoctorStore.onClickToDetail(doctor.id)"
                      >
                        <span><i class="fa-regular fa-circle-info"></i></span>
                        <p class="ms-2 mb-0 fs-6 fw-medium">Information</p>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <doctorModalView />
</template>
<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import loadingView from "@/components/loadingView.vue";
import Navhead from "@/components/layouts/header.vue";
import doctorModalView from "@/components/layouts/doctorModal/doctorModalView.vue";
import { doctorStore } from "@/stores/doctorStore";
import { computed, onMounted, ref } from "vue";
const useDoctorStore = doctorStore();
const doctors = computed(() => useDoctorStore.doctors);
const specialist = computed(() => useDoctorStore.data);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    await useDoctorStore.getDoctor(30);
    useDoctorStore.getDataSpacailist();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});

const onClickBigModal = () => {
  useDoctorStore.doctorMdl.show();
};
</script>
