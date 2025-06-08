<template>
  <loadingView v-if="useDoctorStore.loading" />
  <main v-if="doctor">
    <section class="doctor-profile">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card p-4 rounded-4">
              <div class="card-body d-flex justify-content-between">
                <div class="doctor-card d-flex gap-5">
                  <div class="doctor-image">
                    <img
                      :src="doctor.user.avatar"
                      alt=""
                      class="image-fluid rounded-4"
                    />
                  </div>
                  <div class="doctor-info my-2">
                    <h3 class="text-color-950 fw-medium">
                      វេជ្ជបណ្ឌិត
                      {{ doctor.user.local_fullname }}
                    </h3>
                    <h5 class="text-color-950 fw-medium">
                      Dr.
                      {{ doctor.user.fullname }}
                    </h5>
                    <div class="mt-3">
                      <span class="fw-medium text-color-gray">ឯកទេស</span>
                      <p class="text-color-800 fw-medium">
                        {{ doctor.specialist.local_name }}
                      </p>
                    </div>
                    <div class="mt-3">
                      <span class="fw-medium text-color-gray">មជ្ឈមណ្ឌល</span>
                      <p class="text-color-800 fw-medium">
                        {{ doctor.center.local_name }}
                      </p>
                    </div>
                    <div class="mt-3">
                      <span class="fw-medium text-color-gray">ភាសា</span>
                      <d class="d-flex column-gap-2">
                        <p class="text-color-800 fw-medium">
                          {{ doctor.user.languages.join(", ") }}
                        </p>
                      </d>
                    </div>
                  </div>
                </div>
                <div class="d-flex gap-3">
                  <div v-if="authStore.token">
                    <!-- Btn Controll Sava or Remove -->
                    <a
                      class="save-icon mt-1"
                      role="button"
                      @click.stop.prevent="
                        is_save == 1
                          ? useDoctorStore.onRemoveDoctor(doctor.id)
                          : useDoctorStore.onSaveDoctor(doctor.id)
                      "
                    >
                      <i
                        class="fs-4"
                        :class="
                          is_save == 1
                            ? 'bi bi-bookmarks-fill text-color-warning'
                            : 'bi bi-bookmarks text-color-gray'
                        "
                      ></i>
                    </a>
                  </div>
                  <div>
                    <a
                      role="button"
                      class="btn-bg-650"
                      @click="onClickToBooking(doctor.id)"
                    >
                      <span> កក់ឥឡូវនេះ </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="doc-history">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-7">
            <div class="row g-0 row-gap-3">
              <div class="card border-0 bg-transparent">
                <div class="sec-title">
                  <h4 class="text-color-900">ជីវប្រវត្តិសង្ខេប</h4>
                  <p v-if="doctor.user.bio" class="text-muted">
                    {{ doctor.user.bio }}
                  </p>
                  <div v-else>
                    <h5 class="text-muted text-center">
                      មិនមានទិន្នន័យជីវប្រវត្តិសង្ខេបទេ
                    </h5>
                  </div>
                </div>
              </div>
              <div class="doc-experience">
                <div class="sec-title text-color-900 mb-3">
                  <h4>ការអប់រំ</h4>
                </div>
                <div v-if="doctor.educations && doctor.educations.length > 0">
                  <div class="row g-3">
                    <div
                      class="card p-1 ps-3 pe-2 edu-card"
                      v-for="data in useDoctorStore.doctor.educations"
                      :key="data.id"
                    >
                      <div class="card-body d-flex gap-4">
                        <div
                          class="card-icon d-flex align-items-center justify-content-center"
                        >
                          <span class="text-color-800 fs-5"
                            ><i class="fa-light fa-briefcase"></i
                          ></span>
                        </div>
                        <div class="education-background">
                          <h5 class="text-color-950">
                            {{ data.institution }}
                          </h5>
                          <h5 class="mb-3">
                            {{ data.degree }}
                          </h5>
                          <p class="text-muted mb-0">
                            {{ data.start }} - {{ data.end }}
                          </p>
                          <p class="text-muted mb-0">
                            {{ data.location }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-else>
                  <h5 class="text-muted text-center">
                    មិនមានទិន្នន័យការអប់រំទេ
                  </h5>
                </div>
              </div>
              <div class="doc-education">
                <div class="sec-title text-color-900 mb-3">
                  <h4>បទពិសោធន៍</h4>
                </div>
                <div v-if="doctor.experiences && doctor.experiences.length > 0">
                  <div class="row g-3">
                    <div
                      class="card p-1 ps-3 pe-2 edu-card"
                      v-for="data in useDoctorStore.doctor.experiences"
                      :key="data.id"
                    >
                      <div class="card-body d-flex gap-4">
                        <div
                          class="card-icon d-flex align-items-center justify-content-center"
                        >
                          <span class="text-color-800 fs-5"
                            ><i class="fa-light fa-briefcase"></i
                          ></span>
                        </div>
                        <div class="education-background">
                          <h5 class="text-color-950">
                            {{ data.responsibilities }}
                          </h5>
                          <h5 class="">
                            {{ data.position }}
                          </h5>
                          <p class="fw-medium mb-1">
                            {{ data.organization_name }}
                          </p>
                          <p class="mb-1">
                            {{ data.start_date }} ដល់ {{ data.end_date }}
                          </p>

                          <p class="text-muted mb-0">
                            {{ data.location }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-else>
                  <h5 class="text-muted text-center">
                    មិនមានទិន្នន័យបទពិសោធន៍ទេ
                  </h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="card p-4 rounded-4 border-cus">
              <div class="sec-title">
                <h6 class="text-color-900">ចំពោះករណីមានបញ្ហាចាំបាច់ភ្លៀមៗ</h6>
                <p class="text-muted">
                  សូមលោកអ្នកធ្វើការទំនាក់ទំនងមកកាន់ខាងមន្ទីពេទ្យរបស់យើងផ្ទាល់តាមរយៈទំនាក់ទំនងខាងក្រោម៖
                </p>
                <div class="contact">
                  <div class="d-flex">
                    <span class=""
                      ><i class="fa-regular fa-phone-arrow-down-left"></i
                    ></span>
                    <p class="ms-3">+855 987654321 (សង្គ្រោះបន្ទាន់)</p>
                  </div>
                  <div class="d-flex">
                    <span class=""
                      ><i class="fa-regular fa-phone-arrow-down-left"></i
                    ></span>
                    <p class="ms-3">+855 123456789</p>
                  </div>
                  <div class="d-flex">
                    <span class=""><i class="fa-light fa-envelope"></i></span>
                    <p class="ms-3">vechchsal@gmail.com</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="find-more" v-if="useDoctorStore.doctors">
      <div class="container">
        <div class="row">
          <div class="sec-title d-flex justify-content-between mb-2">
            <h4 class="text-color-900">ស្វែងរកវេជ្ជបណ្ឌិតផ្សេងៗ</h4>
            <div class="navigation-swiper d-flex align-items-center gap-3">
              <div class="custom-prev-btn cursor-pointer">
                <i class="fa-regular fa-arrow-left"></i>
              </div>
              <div class="custom-next-btn cursor-pointer">
                <i class="fa-regular fa-arrow-right"></i>
              </div>
            </div>
          </div>
          <div class="list-doctor">
            <div class="wrapper d-flex justify-content-between">
              <swiper
                :spaceBetween="30"
                :centeredSlides="false"
                :pagination="{
                  clickable: false,
                }"
                :navigation="{
                  prevEl: '.custom-prev-btn',
                  nextEl: '.custom-next-btn',
                }"
                :modules="[Navigation]"
                :breakpoints="{
                  640: { slidesPerView: 1 },
                  768: { slidesPerView: 2 },
                  1024: { slidesPerView: 3 },
                  1024: { slidesPerView: 4 },
                }"
                class="mySwiper"
              >
                <swiper-slide
                  v-for="doctor in useDoctorStore.doctors"
                  :key="doctor.id"
                >
                  <div class="col-12">
                    <div class="card">
                      <div class="card-body p-4 mt-3 text-center">
                        <div class="card-image m-auto mb-3">
                          <img :src="doctor?.user?.avatar" alt="" />
                        </div>
                        <div class="sec-title">
                          <h5 class="text-color-900 mb-4">
                            {{ doctor?.user?.local_fullname }}
                          </h5>
                          <span class="doc-spicalize">
                            {{ doctor?.specialist?.local_name }}
                          </span>
                        </div>
                      </div>
                      <div
                        class="card-footer px-4 py-0 d-flex justify-content-between mt-3"
                      >
                        <a
                          @click="useDoctorStore.onClickToBooking(doctor.id)"
                          class="card-book d-flex align-items-center text-color-900 text-decoration-none"
                          role="button"
                        >
                          <span
                            ><i class="fa-regular fa-calendar-range"></i
                          ></span>
                          <p class="ms-2 mb-0 fs-6 fw-medium">ការណាត់ជួប</p>
                        </a>
                        <div class="divider"></div>
                        <a
                          class="card-info d-flex align-items-center text-color-900 text-decoration-none"
                          role="button"
                          @click="selectDoctor(doctor.id)"
                        >
                          <span><i class="fa-regular fa-circle-info"></i></span>
                          <p class="ms-2 mb-0 fs-6 fw-medium">ព័ត៌មានបន្ថែម</p>
                        </a>
                      </div>
                    </div>
                  </div>
                </swiper-slide>
              </swiper>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>
<script setup>
import loadingView from "@/views/loading/loadingView.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Navigation } from "swiper/modules";
import { historySearch } from "@/stores/finddcotorstore";
import { onMounted, computed, watch, ref } from "vue";
import router from "@/router";
import { useAuthStore } from "@/stores/authTokenStore";

const authStore = useAuthStore();
const useDoctorStore = historySearch();
const doctor = computed(() => useDoctorStore.doctor);
const saveDoctor = ref([]);
const onClickToBooking = (id) => {
  authStore.loadToken();
  if (!authStore.token) {
    router.push("/login");
    return;
  }
  if (id) {
    sessionStorage.setItem("selectId", id);
    router.push("/book-appointment");
  }
};
// onMounted(async () => {
//   await useDoctorStore.getDocDetail();
//   await useDoctorStore.getDoctor();
// });
// Props
defineProps({
  doctor: {
    type: Object,
    required: true,
  },
});
const is_save = computed(() => useDoctorStore.is_save(useDoctorStore.DoctorId));
onMounted(async () => {
  useDoctorStore.loading = true;
  await useDoctorStore.fetchAllData();
  authStore.loadToken();
  if (!authStore.token) {
    await useDoctorStore.onloadSave();
  }
});

const selectDoctor = async (id) => {
  useDoctorStore.setSelectId(id);
  window.scrollTo({ top: 0, behavior: "smooth" });
};
watch(
  () => useDoctorStore.selectId,
  async (newVal) => {
    if (newVal) {
      useDoctorStore.loading = true;
      await useDoctorStore.getDocDetail();
    }
  },
  { immediate: true }
);
</script>
