<template>
    <main class="">
        <Navbar/>
        <div class="container py-4 mt-5">
            <div class="row">
                <div class="col-3">
                    <sidebarProfileSetting/>
                </div>
                <div class="col-9">
                    <account/>
                </div>
            </div>
        </div>
        <FooterView/>
    </main>
</template>

<script setup>
import account from '@/components/views/setting/account.vue';
import Navbar from '@/components/layouts/Navbar.vue';
import sidebarProfileSetting from '@/components/layouts/sidebarProfileSetting.vue';
import FooterView from '@/components/layouts/FooterView.vue';
</script>