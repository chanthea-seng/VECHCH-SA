<template>
    <main>
        <Navbar/>
        <div class="container py-4 mt-5">
            <div class="row">
                <div class="col-3">
                    <sidebarProfileSetting/>
                </div>
                <div class="col-9">
                    <save/>
                </div>
            </div>
        </div>
        <FooterView/>
    </main>
</template>

<script setup>
    import Navbar from '@/components/layouts/Navbar.vue';
    import FooterView from '@/components/layouts/FooterView.vue';
    import save from '@/components/views/setting/save.vue';
    import sidebarProfileSetting from '@/components/layouts/sidebarProfileSetting.vue';

</script>