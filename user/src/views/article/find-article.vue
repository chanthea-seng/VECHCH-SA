<template>
  <main>
    <Navbar/>
    <articleSearch/>
    <Pagination/>
    <FooterView/>
  </main>
</template>
<script setup>
  import Navbar from '@/components/layouts/Navbar.vue';
  import FooterView from '@/components/layouts/FooterView.vue';
  import articleSearch from '@/components/views/article/articleSearch.vue';
  import Pagination from '@/components/layouts/Pagination.vue';

</script>