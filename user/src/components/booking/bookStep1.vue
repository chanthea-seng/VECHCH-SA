<template>
  <div class="container">
    <div class="sec-title mt-3">
      <h6 class="text-muted">
        សូមជ្រើសរើសមុខងារដែលអ្នកពេញចិត្ត
        ដើម្បីធ្វើការណាត់ជួបជាមួយអ្នកជំនាញរបស់យើង
      </h6>
    </div>

    <div class="row g-3">
      <div
        class="col-4"
        v-for="option in seleted.chooseoption"
        :key="option.value"
      >
        <label class="w-100">
          <input
            type="radio"
            name="card_selection"
            class="d-none"
            :value="option.value"
            v-model="seleted.seletedoption"
            @change="updateSelection(option.value)"
          />
          <div class="card p-3 py-5">
            <div class="card-icon m-auto">
              <img :src="option.icon" alt="" />
            </div>
            <div class="sec-title text-center mt-3">
              <p>{{ option.title }}</p>
            </div>
          </div>
          <!-- <span v-if="errors.seletedoption">{{ errors.seletedoption }}</span> -->
        </label>
      </div>
    </div>

    <div class="message-alert my-3">
      <p class="text-color-600">
        <span><i class="fa-regular fa-circle-exclamation"></i></span>
        រាល់ការកក់របស់លោកអ្នកត្រូវបានធ្វើឡើងដោយបណ្ដោះអាសន្ន
        ដោយត្រូវរង់ចាំការបញ្ជាក់ដោយអ្នកជំនាញក្នុងរយៈពេល 24 ម៉ោង
      </p>
    </div>
  </div>
</template>

<script setup>
import { appointment } from "@/stores/bookingstore";

const seleted = appointment();

const updateSelection = (value) => {
  seleted.seletedoption = value;
//   console.log(value);
};
</script>
