<template>
  <main>
    <loadingView v-if="pageLoading" />

    <Navbar />
    <section class="appointment" v-if="!isFinished">
      <div class="container-booking">
        <div class="sec-title text-center text-color-800">
          <h4>ជំនួបពិគ្រោះជំងឺ</h4>
        </div>
        <div class="row">
          <div>
            <form-wizard
              color="#087f96"
              ref="wizard"
              @finish="onFinish"
              @on-complete="submitBooking"
            >
              <tab-content title="ចាប់ផ្តើម" :before-change="validateStep1">
                <!-- <bookStep1 /> -->
                <div class="container">
                  <div class="sec-title mt-3">
                    <h6 class="text-muted mb-3">
                      សូមជ្រើសរើសមុខងារដែលអ្នកពេញចិត្ត
                      ដើម្បីធ្វើការណាត់ជួបជាមួយអ្នកជំនាញរបស់យើង
                    </h6>
                  </div>

                  <div class="row g-3">
                    <div
                      class="col-12 col-md-4"
                      v-for="option in seleted.chooseoption"
                      :key="option.id"
                    >
                      <label class="w-100">
                        <input
                          type="radio"
                          name="card_selection"
                          class="d-none"
                          :value="option.id"
                          v-model="seleted.service_type"
                          @change="updateSelection(option.id)"
                        />
                        <div
                          class="card p-3 d-flex justify-content-center align-items-center"
                          style="height: 270px"
                        >
                          <div class="card-icon">
                            <div class="col-12">
                              <img :src="option.icon" alt="" />
                            </div>
                          </div>
                          <div class="sec-title text-center mt-3">
                            <p>{{ option.title }}</p>
                          </div>
                        </div>
                      </label>
                    </div>
                  </div>

                  <div class="message-alert my-3">
                    <p class="text-color-600">
                      <span
                        ><i class="fa-regular fa-circle-exclamation"></i
                      ></span>
                      រាល់ការកក់របស់លោកអ្នកត្រូវបានធ្វើឡើងដោយបណ្ដោះអាសន្ន
                      ដោយត្រូវរង់ចាំការបញ្ជាក់ដោយអ្នកជំនាញក្នុងរយៈពេល 24 ម៉ោង
                    </p>
                  </div>
                </div>
              </tab-content>
              <tab-content
                title="ផ្នែកនៃមុខងារ"
                :before-change="onValidationstep2"
              >
                <div v-if="seleted.service_type == 0">
                  <step2Consult />
                </div>
                <div v-else-if="seleted.service_type == 1">
                  <step2Checkup />
                </div>
                <div v-else-if="seleted.service_type == 2">
                  <step2Checkup />
                </div>
              </tab-content>
              <tab-content
                title="ព័ត៌មានអ្នកជំងឺ"
                :before-change="onValidationstep3"
              >
                <bookStep3
                  :bookingfrm="seleted.bookingfrm"
                  :validation="seleted.validation.vvbooking"
                />
              </tab-content>
              <tab-content
                title="រង់ចាំសំណើរ"
                :before-change="onValidationstep4"
              >
                <div v-if="seleted.service_type == 0">
                  <bookStep4 />
                </div>
                <div v-else-if="seleted.service_type == 1">
                  <paymentStep4 />
                </div>
                <div v-else-if="seleted.service_type == 2">
                  <paymentStep4 />
                </div>
              </tab-content>

              <!-- Previous Button -->
              <template #prev>
                <button class="btn btn-custom prev-btn" @click="prevTab()">
                  <i class="fa-solid fa-chevron-left"></i> ថយក្រោយ
                </button>
              </template>

              <!-- Next Button -->
              <template #next>
                <button class="btn btn-custom next-btn">
                  បន្ទាប់ <i class="fa-solid fa-chevron-right"></i>
                </button>
              </template>
              <template #finish>
                <button
                  class="btn btn-custom next-btn"
                  @click="finishBooking()"
                >
                  បន្ទាប់ <i class="fa-solid fa-chevron-right"></i>
                </button>
              </template>

              <!-- message -->
              <span id="error-msg" class="text-danger"></span>
            </form-wizard>
          </div>
          <div class="row gx-0 px-4">
            <div class="col-12">
              <div class="card p-4 card-msg rounded-4">
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
                      <p class="ms-3">consultsphere@gmail.com</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div v-if="seleted.service_type === 0">
      <endBooking v-show="isFinished" />
    </div>
    <div v-else-if="seleted.service_type === 1 || seleted.service_type === 2">
      <section
        class="end-booking m-0"
        style="padding-block: 100px"
        v-show="isFinished"
      >
        <div class="container py-5">
          <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-lg-8">
              <div class="col-5 m-auto text-center">
                <img
                  src="@/assets/images/booking/success.gif"
                  style="height: 180px; width: 180px"
                  class="object-fit-contain"
                  alt=""
                />
              </div>
              <div class="icon-img d-flex justify-content-center notification">
                <!-- <div class="loader"></div> -->
                <!-- <img src="/src//assets/img/icon/waiticon.jpg" alt="" /> -->
              </div>
              <div class="sec-title text-center">
                <h3 class="text-color-800">ការកក់របស់អ្នកគឺជោគជ័យ</h3>
                <p class="text-muted">
                  សូមកុំភ្លេចមកកាលបរិច្ឆេទណាត់ជួបរបស់អ្នក។
                  អ្នកអាចពិនិត្យមើលវិក្កយបត្ររបស់អ្នកនៅក្នុងគណនីរបស់អ្នក។
                </p>
                <div class="mt-4 d-flex justify-content-center">
                  <!-- <RouterLink to="/invoice" class="btn btn-booking w-50"
                    >មើលវិក្កយបត្រ</RouterLink
                  > -->
                  <primaryBtn
                    :click-event="onClickInvoice"
                    label="មើលវិក្កយបត្រ"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <FooterView />
  </main>
</template>

<script setup>
import primaryBtn from "../primaryBtn.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import step2Checkup from "@/components/booking/step2Checkup.vue";
import step2Consult from "@/components/booking/step2Consult.vue";
import bookStep3 from "@/components/booking/bookStep3.vue";
import bookStep4 from "@/components/booking/bookStep4.vue";
import paymentStep4 from "@/components/booking/paymentStep4.vue";
import endBooking from "@/components/booking/endBooking.vue";
import { ref, onMounted } from "vue";
import { FormWizard, TabContent } from "vue3-form-wizard";
import { appointment } from "@/stores/bookingstore";
import axios from "axios";
import { calenderStore } from "@/stores/calenderstore";
import { useAuthStore } from "@/stores/authTokenStore";
import loadingView from "../loading/loadingView.vue";

import router from "@/router";
const seleted = appointment();
const wizard = ref(null);
const isFinished = ref(false);
const calender = calenderStore();
const Token = useAuthStore();
const pageLoading = ref(true);
onMounted(() => {
  setTimeout(() => {
    Token.loadToken();
    if (!Token.token) {
      router.go(-1);
    }
    window.scrollTo({ top: 0, behavior: "smooth" });
    pageLoading.value = false;
  }, 1500);
  seleted.setupValidation();
});

const resetBookingData = () => {
  seleted.bookingfrm = {
    name: "",
    local_name: "",
    dob: "",
    gender: "",
    phone_number: "",
    email: "",
    description: "",
    appointment_time: "",
    doctor_id: null,
  };
  seleted.service_type = null;
  seleted.consult_option = null;
  seleted.sub_service_id = null;
  seleted.patient = [];
  seleted.showhistory = false;
  seleted.bookingHistory = [];
  calender.selectedDate = "";
  calender.selectedTime = "";

  seleted.fileShow = {
    filename: null,
    paymentFile: null,
  };
};
const onClickInvoice = () => {
  resetBookingData();
  router.push("/invoice");
};
const updateSelection = (value) => {
  seleted.service_type = value;
  //   console.log(value);
};

const validateStep1 = () => {
  if (seleted.service_type === null) {
    document.getElementById("error-msg").innerText =
      "សូមមេត្តាជ្រើសរើសមុខងារណាមួយ!!";
    return false;
  }
  document.getElementById("error-msg").innerText = "";
  return true;
};
const onValidationstep2 = () => {
  let ErrorMessage = document.getElementById("error-msg");
  if (seleted.service_type === 0) {
    if (seleted.consult_option === null) {
      ErrorMessage.innerText =
        "សូមជ្រើសរើសជម្រើសមួយ (ជ្រើសរើសវេជ្ជបណ្ឌិត ឬ ណែនាំវេជ្ជបណ្ឌិត)!";
      return false;
    }
    if (seleted.consult_option === 1 && !seleted.showhistory) {
      if (!seleted.bookingfrm.doctor_id) {
        ErrorMessage.innerText = "សូមជ្រើសរើសវេជ្ជបណ្ឌិតមុននឹងបន្ត!";
        return false;
      }
    }
    if (seleted.consult_option === 2 || seleted.showhistory) {
      // if (!seleted.bookingfrm.description || seleted.bookingfrm.description.trim() === "") {
      //   ErrorMessage.innerText = "សូមបំពេញបញ្ជាសុខភាព!";
      //   return false;
      // }

      if (!calender.selectedDate) {
        ErrorMessage.innerText = "សូមជ្រើសរើសកាលបរិច្ឆេទ!";
        return false;
      }

      if (!calender.selectedTime) {
        ErrorMessage.innerText = "សូមជ្រើសរើសម៉ោង!";
        return false;
      }
    }
  } else if (seleted.service_type === 1 || seleted.service_type === 2) {
    if (!seleted.sub_service_id) {
      ErrorMessage.innerText = "សូមជ្រើសរើសសេវាកម្មណាមួយ!";
      return false;
    }
    if (!calender.selectedDate) {
      ErrorMessage.innerText = "សូមជ្រើសរើសកាលបរិច្ឆេទ!";
      return false;
    }

    if (!calender.selectedTime) {
      ErrorMessage.innerText = "សូមជ្រើសរើសម៉ោង!";
      return false;
    }

    ErrorMessage.innerText = "";
    return true;
  }
  ErrorMessage.innerText = "";
  return true;
};
const onValidationstep3 = () => {
  seleted.validation.vvbooking.$touch();
  if (seleted.validation.vvbooking.$invalid) {
    return false;
  }
  seleted.patient.push({
    kh_name: seleted.bookingfrm.name,
    en_name: seleted.bookingfrm.local_name,
    dob: seleted.bookingfrm.dob,
    gender: seleted.bookingfrm.gender,
    phoneNumber: seleted.bookingfrm.phone_number,
    email: seleted.bookingfrm.email,
    description: seleted.bookingfrm.description,
  });
  return true;
};
const onValidationstep4 = () => {
  isFinished.value = true;
  return true;
};

const onFinish = () => {
  isFinished.value = true;
};

const finishBooking = async () => {
  Token.loadToken();
  const formdata = new FormData();
  if (seleted.bookingfrm.doctor_id) {
    formdata.append("doctor_id", seleted.bookingfrm.doctor_id);
  }
  formdata.append("name", seleted.bookingfrm.name);
  formdata.append("local_name", seleted.bookingfrm.local_name);
  formdata.append("dob", seleted.bookingfrm.dob);
  formdata.append("gender", seleted.bookingfrm.gender);
  formdata.append("phone_number", seleted.bookingfrm.phone_number);
  formdata.append("email", seleted.bookingfrm.email);
  formdata.append("description", seleted.bookingfrm.description);
  formdata.append(
    "appointment_time",
    calender.selectedDate + " " + calender.selectedTime
  );
  if (seleted.sub_service_id) {
    formdata.append("sub_service_id", seleted.sub_service_id);
  }
  formdata.append("service_type", seleted.service_type);
  if (seleted.fileShow.filename) {
    formdata.append("file", seleted.fileShow.filename);
  }
  if (seleted.fileShow.paymentFile) {
    formdata.append("paymentImage", seleted.fileShow.paymentFile);
  }
  // for (const [key, value] of formdata.entries()) {
  //     console.log(`${key}: ${value}`);
  // }
  try {
    const response = await axios.post("/api/bookings", formdata, {
      headers: {
        Authorization: `Bearer ${Token.token}`,
        "Content-Type": "multipart/form-data",
      },
    });
    // console.log("Response:", response.data);
    // console.log("Booking ID:", response.data.data.id);
    sessionStorage.setItem("selectId", response.data.data.id);
    onFinish();

    return true;
  } catch (error) {
    // console.error(
    //   "Error:",
    //   error.response ? error.response.data : error.message
    // );
  }
};
</script>

<style scope>
.appointment {
  margin: 0 !important;
  padding-block: 100px;
}
</style>
