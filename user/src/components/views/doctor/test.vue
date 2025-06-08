<template>
    <div class="swiper-container">
      <!-- Swiper -->
      <Swiper
        :modules="[Navigation]"
        :navigation="{
          prevEl: '.custom-prev-btn',
          nextEl: '.custom-next-btn',
        }"
        :slides-per-view="1"
        :space-between="30"
      >
        <SwiperSlide>Slide 1</SwiperSlide>
        <SwiperSlide>Slide 2</SwiperSlide>
        <SwiperSlide>Slide 3</SwiperSlide>
      </Swiper>
  
      <!-- Custom Buttons -->
      <button class="custom-prev-btn">Previous</button>
      <button class="custom-next-btn">Next</button>
    </div>
  </template>
  
  <style>
  .swiper-container {
    position: relative;
  }
  
  .custom-prev-btn,
  .custom-next-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    margin: 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .custom-prev-btn:hover,
  .custom-next-btn:hover {
    background: #0056b3;
  }
  </style>
  <script setup>
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import 'swiper/swiper-bundle.css';
  import { Navigation } from 'swiper/modules';
  </script>
  
  