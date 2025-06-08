<template>
    <div class="toast-container border-0 toastfail settingToast position-fixed  end-0 p-3">
        <div id="liveToast" class="toast border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header mb-0 border-0 d-flex justify-content-start position-relative"> 
                <h6 class="mb-0 " id="titletoast" style=" color:red"
                
                >ចូលប្រើប្រាស់ បរាជ័យ</h6> 
               
                              
                <!-- <button type="button" class="btn-close position-absolute end-0 top-0" data-bs-dismiss="toast" aria-label="Close"></button> -->
            </div>
            <div class="toast-body mt-0 d-flex align-items-center ">
                
                <div class="col-2 icon me-3">
                    <i class="fa-regular fa-xmark text-danger"></i>
                </div>
                <p class="col-10 mb-0" style="font-size: 13px;" id="subtitletoast">
                  អាស័យដ្ឋានអ៊ីមែល ឬ ពាក្យសម្ងាត់មិនត្រឹមត្រូវ សូមព្យាយាមម្ដងទៀត
                </p>
            </div>
        </div>
    </div>

</template>

<script setup>
    import { Toast } from 'bootstrap';
import { onMounted } from 'vue';
import { useAuthStore } from '@/stores/authTokenStore';

    const authStore = useAuthStore();

    onMounted(() =>{

        authStore.toastfail = Toast.getOrCreateInstance(document.getElementById('liveToast'));
    })


</script>