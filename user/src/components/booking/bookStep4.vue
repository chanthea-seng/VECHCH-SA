<template>
  <section class="information-request">
    <div class="container">
      <div class="sec-header">
        <h5 class="text-color-800">ផ្ទៀងផ្ទាត់ព័ត៌មានសម្រាប់សំណើរ</h5>
      </div>
      <hr />
      <div class="sec-title text-color-800 d-flex justify-content-between mt-4">
        <h5>ពិគ្រោះជាមួយវេជ្ជបណ្ឌិត</h5>
      </div>
      <div class="row">
        <div class="col-12" v-for="(history, index) in store.bookingHistory" :key="index">
          <div class="card p-0 rounded-4">
            <div class="card-body d-flex justify-content-between">
              <div class="col-10 doctor-card">
                <div class="row">
                  <div class="col-4 doctor-image ">
                      <img :src="history.user?.avatar ?? history.avatar" alt=""
                        class="img-fluid  card-img-top rounded-4">
                    </div>
                  <div class="col-8 doctor-info my-0 my-lg-2">
                    <h3 class="text-color-800">
                      វេជ្ជបណ្ឌិត {{ history.user?.local_fullname ?? history.local_fullname }}
                    </h3>
                    <div class="mt-0 mt-lg-3">
                      <span>ឯកទេស</span>
                      <p class="text-color-800">
                        {{ history?.specialist?.local_name }}
                      </p>
                    </div>
                    <div class="d-flex d-none d-md-block justify-content-between gap-0 gap-lg-5">
                      <div class=" ">
                        <span>មជ្ឈមណ្ឌល</span>
                        <p class="text-color-800">
                          {{ history?.center?.local_name }}
                        </p>
                      </div>
                      <div class="">
                        <span>ភាសា</span>
                        <p class="text-color-800">
                          {{ (history?.user?.languages ?? history?.languages ?? []).join(', ') }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="booking-detail my-3" v-for="patient in patients" :key="patient.id">
          <div class="booking-date">
            <h6 class="text-muted">
              កាលបរិច្ឆេទការណាត់ជួប<span class="text-danger">*</span>
            </h6>
            <p>{{ patient.appointment_time }}</p>
            <p>{{ calender.selectedDate + " " + calender.selectedTime }}</p>
          </div>
          <div class="symptoms">
            <h6 class="text-muted">
              បញ្ហាឬ រោគសញ្ញាអ្នកជំងឺ<span class="text-danger">*</span>
            </h6>
            <p>{{ patient.description }}</p>
          </div>
        </div>
        <hr />
      </div>
    </div>
  </section>
  <section class="patient-info">
    <div class="container">
      <div class="sec-title d-flex justify-content-between text-color-800">
        <h5>ព័ត៌មានអ្នកជំងឺ</h5>
      </div>
      <div class="row" v-for="patient in patients" :key="patient.id">
        <div class="col-6 col-md-4">
          <div class="card border-0 bg-transparent">
            <div class="f-name">
              <p class="m-0">នាមត្រកូល*</p>
              <h5>{{ patient.kh_name }}</h5>
            </div>
            <div class="dob my-3">
              <p class="m-0">ថ្ងៃ ខែ ឆ្នាំកំណើត*</p>
              <h5>{{ patient.dob }}</h5>
            </div>
            <div class="f-name">
              <p class="m-0">លេខទូរស័ព្ទ*</p>
              <h5>{{ patient.phoneNumber }}</h5>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4">
          <div class="card border-0 bg-transparent">
            <div class="f-name">
              <p class="m-0">នាមត្រកូល*</p>
              <h5>{{ patient.en_name }}</h5>
            </div>
            <div class="dob my-3">
              <p class="m-0">ភេទ*</p>
              <h5>{{ patient.gender == 1 ? "ប្រុស" : "ស្រី" }}</h5>
            </div>
            <div class="f-name">
              <p class="m-0">អាស័យដ្ធានអីម៉ែល*</p>
              <h5>{{ patient.email }}</h5>
            </div>
          </div>
        </div>
      </div>
      <div class="message-alert my-3">
        <p class="text-color-600">
          <span><i class="fa-regular fa-circle-exclamation"></i></span>
          រាល់ការកក់របស់លោកអ្នកត្រូវបានធ្វើឡើងដោយបណ្ដោះអាសន្ន
          ដោយត្រូវរង់ចាំការបញ្ជាក់ដោយអ្នកជំនាញក្នុងរយៈពេល24ម៉ោង
        </p>
      </div>
    </div>
  </section>
</template>
<script setup>
import { appointment } from "@/stores/bookingstore";

import { historySearch } from "@/stores/finddcotorstore";
import { calenderStore } from "@/stores/calenderstore";
const history = historySearch();
const calender = calenderStore();

const store = appointment();
const patients = store.patient;
</script>
