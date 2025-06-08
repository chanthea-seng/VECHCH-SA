<template>
  <main>
    <Navbar /> 
    <finddoctor />
    <FooterView />
  </main>
</template>
<script setup>
    import Navbar from '@/components/layouts/Navbar.vue';
    import finddoctor from '@/components/views/doctor/finddoctor.vue';
    import FooterView from '@/components/layouts/FooterView.vue';
</script>