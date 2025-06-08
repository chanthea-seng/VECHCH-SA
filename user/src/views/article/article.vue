a<template>
  <main>

    <Navbar />
    <articles/>
    <FooterView />
  </main>
</template>
<script setup>
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import articles from "@/components/views/article/article.vue";
</script>
