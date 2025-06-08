<template>
  <div class="transportation pt-4">
    <loadingView v-if="pageLoading" />

    <section class="hero mt-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-8 mx-auto position-relative z-3">
            <div class="content text-center">
              <img
                src="/src/assets/images/auth/Vcs new.png"
                width="60px"
                alt=""
              />
              <h4 class="mt-2">មធ្យោបាយធ្វើដំណើរ</h4>
              <p>
                យើងនឹងផ្ដល់នូវមធ្យោបាយធ្វើដំណើរសម្រាប់តំបន់ក្រុងប៉ុណ្នោះ
                ដើម្បីជួយសម្រួល
                នឹងផ្ដល់ភាពងាយស្រួលដល់លោកអ្នកសម្រាប់ការធ្វើដំណើរដោយសុខសុវត្ថិភាព
                ដើម្បីទទូលសេវាកម្មមធ្យោបាយធ្វើដំណើរនេះ
                សូមធ្វើការទំនាក់ទំនងមកយើងដោយផ្ទាល់តាមរយៈអាស័យដ្ធានខាងក្រោម
              </p>
              <div
                class="mx-auto bg-color-800 p-1 px-3 d-flex align-items-center justify-content-center rounded-3 text-white"
                style="width: 370px"
              >
                <i class="bi bi-envelope-fill fs-5 me-2"></i>
                <span class="">vechchsalHospitalTransportation@gmail.com</span>
              </div>
            </div>
            <div class="d-flex mx-auto mt-4 location">
              <div class="ilocation">
                <img
                  src="/src/assets/images/auth/icon/location-location-route-wavy.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <div class="car-hero">
                <img
                  src="/src/assets/images/auth/icon/car3.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="process mt-0 pt-0">
      <div class="container">
        <div class="row">
          <h4 class="mb-4 pb-3 text-center">
            នេះជាដំណើរការនៃការកក់មធ្យោបាយធ្វើដំណើរ
          </h4>
          <div class="col-4">
            <div class="item first">
              <div class="d-flex my-3">
                <div class="col">
                  <i
                    class="bi bi-telephone-outbound-fill text-color-warning fs-3 me-3"
                  ></i>
                </div>
                <div>
                  <span class="">ទំនាក់ទំនងយើងដោយផ្ទាល់</span>
                  <p class="mb-0">
                    សូមធ្វើការទំនាក់ទំនងយើងដោយផ្ទាល់តាមរយៈលេខទូរស័ព្ទមួយនេះ
                    098765432
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="item">
              <div class="d-flex">
                <div class="col">
                  <i
                    class="bi bi-geo-alt-fill text-color-warning fs-3 me-3"
                  ></i>
                </div>
                <div>
                  <span class="">កំណត់ទីតាំងដែលអ្នកកំពុងស្នាក់នៅ</span>
                  <p class="mb-0">
                    លោកអ្នកត្រូវធ្វើការផ្ដល់ពីទីតាំងដែលអ្នកកំពុងស្នាក់នៅដើម្បីភាពងាយស្រួលដល់ក្រុមការងាររបស់យើងទៅយកលោកអ្នក
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="item">
              <div class="d-flex">
                <div class="col">
                  <i
                    class="fa-regular fa-check text-color-warning fs-3 me-3"
                  ></i>
                  <!-- <i class="bi bi-telephone-outbound-fill text-color-warning fs-3 me-3"></i> -->
                </div>
                <div>
                  <span class="">រីករាយនឹងការធ្វើដំណើរជាមួយយើង</span>
                  <p class="mb-0">
                    លោកអ្នកត្រូវធ្វើការផ្ដល់ពីទីតាំងដែលអ្នកកំពុងស្នាក់នៅដើម្បីភាពងាយស្រួលដល់ក្រុមការងាររបស់យើងទៅយកលោកអ្នក
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="timework py-5 m-0">
      <div class="container">
        <div class="row align-items-end">
          <div class="col-7">
            <div>
              <h4 class="mb-0">ម៉ោងធ្វើការរបស់យើង</h4>
              <p class="my-4 pe-5">
                សូមចំណាំថា សេវាកម្មមានផ្តល់ជូនតាមតំរូវការអ្នកមកមុន
                និងបម្រើមុនគេ។ សម្រាប់ព័ត៌មានលម្អិតអំពីផ្លូវ
                និងការអាប់ដេតកាលវិភាគណាមួយ
                សូមពិនិត្យមើលតារាងពេលវេលាដឹកជញ្ជូនរបស់យើង
                ឬទាក់ទងការិយាល័យជំនួយរបស់យើង។
              </p>
              <div class="d-flex gap-5 justify-content-between">
                <div class="w-50">
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃចន្ទ</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃអង្គារ</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃពុធ:</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃព្រហស្បតិ៍:</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                </div>
                <div class="w-50">
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃសុក្រ:</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃសៅរ៍:</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                  <div class="d-flex my-3">
                    <span class="day me-2">ថ្ងៃអាទិត្យ:</span>
                    <span class="time">07:00 AM - 06:00 PM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-5">
            <div class="car position-relative w-100">
              <img
                src="/src/assets/images/auth/icon/car2.png"
                class="img-fluid"
                alt=""
              />
              <div class="logo">
                <img
                  src="/src/assets/images/auth/new.png"
                  class="w-100 h-100 object-fit-cover"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import loadingView from "@/views/loading/loadingView.vue";
import { onMounted, ref } from "vue";
const pageLoading = ref(true);
onMounted(() => {
  setTimeout(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
    pageLoading.value = false;
  }, 1500);
});
</script>
