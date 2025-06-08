<template>
    <div>
      <a role="button" v-show="showButton" @click="scrollToTop" class="btnscrolltop">
        <i class="fa-regular text-white fa-chevron-up"></i>
      </a>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from "vue";
  
  const showButton = ref(false);
  
  const handleScroll = () => {
    showButton.value = window.scrollY > 200; // Show button after 200px scroll
  };
  
  const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  };
  
  onMounted(() => {
    window.addEventListener("scroll", handleScroll);
  });
  
  onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
  });
  </script>
  