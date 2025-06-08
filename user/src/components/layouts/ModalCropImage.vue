<template>

    <div class="modal fade setting" id="mdl-crop-profile" tabindex="-1" aria-labelledby="mdl-crop-profileLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 px-3">
                    <h1 class="modal-title fs-5   text-color-950" id="mdl-crop-profileLabel">កាត់រូបភាព</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3" style="height: 350px;">
                    <Cropper :src="state.img" style="height: 350px" :stencil-props="{
                        aspectRatio: 1,
                        resizable: true
                    }" @change="onCropImage" />
                </div>
                <div class="modal-footer border-0  p-3 pt-0 mt-0">

                    <a role="button" class="btn-bg-650 btn-delete mb-0 mt-0" data-bs-dismiss="modal">បោះបង់</a>
                    <primaryBtn :click-event="onCropped" label="រក្សាទុក" />
                    <!-- <a role="button" @click="onCropped()" class="btn-bg-650   mb-0 mt-0 me-0 " >រក្សាទុក</a> -->

                </div>
            </div>
        </div>
    </div>
    <input type="file" @change="onSelectFile($event)" class="d-none" id="file-image">

    <ToastSuccsess/>

</template>

<script setup>

import { RouterLink } from 'vue-router';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css'
import 'vue-advanced-cropper/dist/theme.bubble.css'
import { Modal } from 'bootstrap';
import { onMounted, reactive } from 'vue';
import { userStore } from '@/stores/userStore';
import ToastSuccsess from './ToastSuccsess.vue';
import axios from 'axios';

import setAuthHeader from '@/stores/setAuthHeader';
import { useAuthStore } from '@/stores/authTokenStore'
// import { userStore } from '@/stores/userstore';

import primaryBtn from '@/views/primaryBtn.vue';
const userstore = userStore();
let temp = null;

const state = reactive({
    mdl_crop_profile: null,
    img: '',
    result: {
        coordinates: null,
        canvas: null
    },

})


const authStore = useAuthStore();
onMounted(() => {
    state.mdl_crop_profile = Modal.getOrCreateInstance(document.getElementById('mdl-crop-profile'));
})



const onCropImage = async ({ coordinates, canvas }) => {
    state.result = {
        coordinates,
        canvas
    }
}


const onSelectFile = (e) => {

    if (e.currentTarget.files.length === 0) {
        return;
    }

    const file = e.currentTarget.files[0]
    if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {

        document.getElementById('titletoast').innerHTML = 'ផ្លាស់ប្តររូបភាព បរាជ័យ'
        document.getElementById('subtitletoast').innerHTML = 'រូបភាពរបស់អ្នកត្រូវតែជា​ (.png, .jpg)'
        authStore.toastfail.show();
        // alert('File type must be image (.png, .jpg).')
        return
    }
    if (file.size / 1048576 > 2) {
        document.getElementById('titletoast').innerHTML = 'ផ្លាស់ប្តររូបភាព បរាជ័យ'
        document.getElementById('subtitletoast').innerHTML = 'រូបភាពរបស់អ្នកត្រូវតែមានទំហំតូចជាង 2 MB​'
        authStore.toastfail.show();
        return
    }

    state.img = URL.createObjectURL(file)
    state.mdl_crop_profile.show();
    document.getElementById("body-wrapper").style.padding = 0;
    document.getElementById("body-wrapper").style.overflow = "auto";

}


// const onCropped = async () => {
//     if (state.result.canvas) {

//         const bin = await new Promise((resolve) => {
//             state.result.canvas.toBlob(resolve, 'image/jpeg');
//         });

//         if (!bin) {
//             alert('Image processing failed! Please try again.');
//             return;
//         }

//         await state.result.canvas.toBlob((bin) => {
//             userstore.avatar.bin = bin;
//             userstore.avatar.url = URL.createObjectURL(bin);
//             state.mdl_crop_profile.hide();
//         }, 'image/jpeg')
//     } else {
//         alert(
//             'Something went wrong! Please refresh page and try again.'
//         )
//     }

    

//     await onSaveImage();

// }

const changecontentToastFail = (title='ផ្លាស់ប្តររូបភាព បរាជ័យ' ,subtitle='ការផ្លាស់ប្ដូររូបភាពរបស់អ្នកបរាជ័យ សូមព្យាយាមម្ដងទៀត') =>{
    document.getElementById('titletoast').innerHTML = title;
     document.getElementById('subtitletoast').innerHTML =subtitle;
}


const onCropped = async () => {
    if (!state.result.canvas) {
        changecontentToastFail();
        authStore.toastfail.show();
        return;
    }

    const bin = await new Promise((resolve) => {
        state.result.canvas.toBlob(resolve, 'image/jpeg');
    });

    if (!bin) {
        changecontentToastFail();
        authStore.toastfail.show();
        return;
    }

    userstore.avatar.bin = bin;
    userstore.avatar.url = URL.createObjectURL(bin);
    
    state.mdl_crop_profile.hide();
    

    
    let frmData = new FormData();
    if (userstore.avatar.bin) {
        frmData.append('avatar', userstore.avatar.bin);
    }
    try {
        const response = await axios.post('/api/users/avatar', frmData, {
            headers: {
                "Content-Type": "multipart/form-data",
                Accept: 'application/json',
                Authorization: 'Bearer ' + authStore.token
            }
        }, {
        });
        userstore.onLoadData();
        document.getElementById('titletoastsuccess').innerHTML = 'ផ្លាស់ប្តររូបភាព ជោគជ័យ';
        document.getElementById('subtitletoastsuccess').innerHTML = 'ការផ្លាស់ប្ដូររូបភាពរបស់អ្នកទទួលបានជោគជ័យ';
        userstore.tostsuccess.show();

    }
    catch (error) {
        // console.error(error);
        document.getElementById('titletoast').innerHTML = 'ផ្លាស់ប្តររូបភាព បរាជ័យ'
        document.getElementById('subtitletoast').innerHTML = 'ការផ្លាស់ប្ដូររូបភាពរបស់អ្នកបរាជ័យ'
        authStore.toastfail.show();

    }
    
};

</script>