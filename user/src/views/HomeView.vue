<template>
  <main>
    <Navbar />

    <HomePageView />
    <FooterView />

  </main>
</template>
<script setup>
import Navbar from '@/components/layouts/Navbar.vue';
import HomePageView from '@/components/views/homeView/HomePageView.vue';
import FooterView from '@/components/layouts/FooterView.vue';

</script>
