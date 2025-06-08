<template>
    <main>
        <Navbar/>
        <div class="container py-4 mt-5">
            <div class="row">
                <div class="col-3">
                    <sidebarProfileSetting/>
                </div>
                <div class="col-9">
                    <profilesetting/>
                </div>
            </div>
        </div>
       <ModalCropImage/>
        <FooterView/>
    </main>
</template>

<script setup>
import Navbar from '@/components/layouts/Navbar.vue';
import profilesetting from '@/components/views/setting/profilesetting.vue';
import sidebarProfileSetting from '@/components/layouts/sidebarProfileSetting.vue';
import ModalCropImage from '@/components/layouts/ModalCropImage.vue';
import FooterView from '@/components/layouts/FooterView.vue';
</script>