<template>
    <main>
        <Navbar/>
        <contact/>
        <FooterView/>
    </main>
</template>

<script setup>
    import Navbar from '@/components/layouts/Navbar.vue';
    import contact from '@/components/views/homeView/contact.vue';
    import FooterView from '@/components/layouts/FooterView.vue';
</script>