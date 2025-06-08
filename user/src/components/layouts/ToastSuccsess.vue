<template>
    <div class="toast-container border-0 settingToast success position-fixed  end-0 p-3">
        <div id="Toastsuccess" class="toast border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header  border-0 d-flex justify-content-start" >  
                <h6  class="mb-0  text-color-1100 " id="titletoastsuccess" 
                    
                >ផ្លាស់ប្តររូបភាព ជោគជ័យ</h6>               
                <!-- <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button> -->
            </div>
            <div class="toast-body mx-auto mt-0  d-flex align-items-center ">
                <div class="col-2 icon me-3">
                    <i class="fa-duotone fa-regular fa-check"></i>
                </div>
                <p class="col-10 mb-0 text-color-950" id="subtitletoastsuccess" style="font-size: 13px;">
                    ការផ្លាស់ប្ដូររូបភាពរបស់អ្នកទទួលបានជោគជ័យ
                </p>
            </div>
        </div>
    </div>

</template>

<script setup>
    import { Toast } from 'bootstrap';
import { onMounted } from 'vue';
import { userStore } from '@/stores/userStore';
import { useAuthStore } from '@/stores/authTokenStore';

const userstore = userStore();
const authStore = useAuthStore();


    onMounted(() =>{

        userstore.tostsuccess = Toast.getOrCreateInstance(document.getElementById('Toastsuccess'));
        authStore.tostsuccess = Toast.getOrCreateInstance(document.getElementById('Toastsuccess'));
    })


</script>