<template>
    <loadingView v-if="userstore.loading"/>
    <main class="setting">
        <div class="account-setting bg-white border-radius p-4 ">
            <h5 class=" setting-title text-color-950 mb-3">ព័ត៌មានផ្ទាល់ខ្លួន</h5>
                <div class="row">
                    <div class="col-12  mb-4 ">
                        <div class=" wrapper-pf d-flex align-items-center justify-content-between">

                            <div class="d-flex  align-items-center pf">
                                <a role="button" @click="onChooseImage" class="profile-img">                                    
                                        <img :src="userstore.users.avatar ? userstore.users.avatar : '/src/assets/images/auth/no_photo.jpg'"
                                            class="w-100 object-fit-cover h-100" alt="">
                                        
                                        <div class=" position-absolute chooseimg">
                                            <i class="fa-light fa-camera-retro"></i>
                                            </div>
                                        </a>
                                        
                                <div class="ms-4" >
                                    <p class="mb-0">រូបថតគណនី</p>
                                    <span class="text-color-gray txt-small ">រាល់ការផ្លាស់ប្ដូររូបភាព
                                        វានឹងបង្ហាញនៅលើប្រវត្តិរូបរបស់អ្នក</span>
                                </div>
    
                            </div>
                            <div>
                                <primaryBtn :click-event="onChooseImage" label="ប្ដូររូបភាព" />
                                <!-- <a role="button" @click="onChooseImage" class="btn-bg-650 mb-0">ប្ដូររូបភាព</a> -->
                                <!-- <input type="file" @change="onSelectFile($event)" class="d-none" id="file-image"> -->
                            </div>
                        </div>
                    </div>

                </div>
                <form >
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label"> នាមត្រកូល</label>
                            <input class="form-control" v-model="userstore.userfrm.fullname" id="first_name" placeholder="នាមត្រកូល" type="text"
                            :class="{'is-invalid' : userstore.vvuser.fullname.$error}">
                            <div class="invalid-feedback"
                            v-if="userstore.vvuser.fullname.$error">
                                {{ userstore.vvuser.fullname.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">អាស័យដ្ធានអ៊ីមែល</label>
                            <input class="form-control"  v-model="userstore.userfrm.email" id="email" placeholder="អាស័យដ្ធានអ៊ីមែល" type="text"
                            :class="{ 'is-invalid' : userstore.vvuser.email.$error}">
                            <div class="invalid-feedback"
                            v-if="userstore.vvuser.email.$error">
                                {{ userstore.vvuser.email.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <primaryBtn :click-event="onClickUpdateUser"   label="ផ្លាស់ប្ដូរ" />
                    </div>

                </div>

            </form>

        </div>
        <div class="account-setting bg-white mt-5  border-radius  p-4">
            <h5 class=" setting-title text-color-950 ">សុវត្ថិភាពគណនី</h5>
            <span class="text-color-gray txt-small ">ពាក្យសម្ងាត់របស់អ្នកត្រូវតែមានយ៉ាងហោចណាស់ 8 តួអក្សរ
                ហើយគួរតែរួមបញ្ចូលអក្សរធំ អក្សរតូច លេខ និងនិមិត្តសញ្ញាពិសេស (ឧ. #, %, &)</span>

            <form  class="mt-2">
                <div class="row">

                    <div class="col-6">

                        <div class="mb-3 position-relative">
                            <label for="old_password" class="form-label">ពាក្យសម្ងាត់ចាស់</label>
                            <input class="form-control"  v-model="userstore.userfrm.old_password" id="old_password" placeholder="ពាក្យសម្ងាត់ចាស់" 
                             :type="isPasswordOld ? 'text' : 'password'"
                             :class="{ 'is-invalid' : userstore.vvpassword.old_password.$error}"
                            >
                            <div class="invalid-feedback" v-if="userstore.vvpassword.old_password?.$error">
                                {{ userstore.vvpassword.old_password.$errors[0].$message }}
                            </div>
                            <i
                            @click="toggleOldPassword"
                            :class="OldpassIconClass"
                            class="position-absolute fs-6"
                            style="top: 41px; right: 10px; cursor: pointer"
                            ></i>
                            <!-- <div class="invalid-feedback"
                            v-if="userstore.vvuser.old_password.$error">
                                {{ userstore.vvuser.old_password.$errors[0].$message }}
                            </div> -->
                        </div>

                       
                    </div>
                    <div class="col-6">
                        <div class="mb-3 position-relative">
                            <label for="new_password" class="form-label">ពាក្យសម្ងាត់ថ្មី</label>
                            <input class="form-control" id="new_password" placeholder="ពាក្យសម្ងាត់ថ្មី"
                            v-model="userstore.userfrm.new_password"
                            :type="isPasswordVisible ? 'text' : 'password'"
                            :class="{ 'is-invalid' : userstore.vvpassword.new_password.$error}">
                            <div class=" invalid-feedback" v-if="userstore.vvpassword.new_password.$error">
                                {{ userstore.vvpassword.new_password.$errors[0].$message }} 
                            </div>
                            <i
                      @click="togglePassword"
                      :class="iconClass"
                      class="position-absolute fs-6"
                      style="top: 41px; right: 10px; cursor: pointer"
                    ></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3 position-relative">
                            <label for="verify-pass" class="form-label">ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់</label>
                            <input class="form-control" id="verify-pass"  :type="isPasswordChecked ? 'text' : 'password'"
                                placeholder="ផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់"
                                v-model="userstore.userfrm.confirm_password"
                                :class="{ 'is-invalid' : userstore.vvpassword.confirm_password.$error}"
                                >
                                <div class=" invalid-feedback" v-if="userstore.vvpassword.confirm_password.$error">
                                    {{ userstore.vvpassword.confirm_password.$errors[0].$message }}
                                </div>
                                <i
                      @click="toggleConfirmPassword"
                      :class="confirmIconClass"
                      class="position-absolute fs-6"
                      style="top: 41px; right: 10px; cursor: pointer"
                    ></i>
                        </div>
                    </div>
                   
                    <div class="col-12 mt-2">
                        <primaryBtn :click-event="onResetPassword" label="ផ្លាស់ប្ដូរ"/>
                        <!-- <a role="button" @click="onClickupdateImage
                        " class="btn-bg-650   mb-0  ">ផ្លាស់ប្ដូរ</a> -->
                    </div>
                </div>

            </form>

        </div>
        <ToastSuccsess/>
        <Toastfail/>
        <!-- <ModalCropImage ref="mdlCropProfile"/> -->
        
    </main>


</template>

<script setup>
import { RouterLink } from 'vue-router';
import { Modal } from 'bootstrap';
import { reactive ,ref,onMounted, computed} from 'vue';
import primaryBtn from '@/views/primaryBtn.vue';
import axios from 'axios';
import ModalCropImage from '@/components/layouts/ModalCropImage.vue';
import loadingView from '@/views/loading/loadingView.vue';
import { userStore } from '@/stores/userStore';
import { url } from '@vuelidate/validators';
import  setAuthHeader  from '@/stores/setAuthHeader';
import { useAuthStore } from '@/stores/authTokenStore';
import { useVuelidate } from '@vuelidate/core';
import { required, helpers, email ,minLength,sameAs} from '@vuelidate/validators';

import Toastfail from '@/components/layouts/Toastfail.vue';
import ToastSuccsess from '@/components/layouts/ToastSuccsess.vue';

const userstore = userStore();
const authStore = useAuthStore();


onMounted( async()=>{
    await authStore.loadToken();
    userstore.onLoadData();
    
    userstore.userfrm.fullname = userstore.users.fullname;    
    userstore.userfrm.email = userstore.users.email; 
    userstore.avatar.url = userstore.users.avatar;
})

const isPasswordVisible = ref(false);
const isPasswordOld = ref(false);
const isPasswordChecked = ref(false);

const togglePassword = () => {
    isPasswordVisible.value = !isPasswordVisible.value;
};

const toggleConfirmPassword = () => {
    isPasswordChecked.value = !isPasswordChecked.value;
};
const toggleOldPassword = () => {
    isPasswordOld.value = !isPasswordOld.value;
};

const iconClass = computed(() => {
    return isPasswordVisible.value ? 'fa-light fa-eye' : 'fa-light fa-eye-slash';
});
const confirmIconClass = computed(() => {
    return isPasswordChecked.value ? 'fa-light fa-eye' : 'fa-light fa-eye-slash';
});
const OldpassIconClass = computed(() => {
    return isPasswordOld.value ? 'fa-light fa-eye' : 'fa-light fa-eye-slash';
});


const nameRegex = /^[\p{L}\s]+$/u;
const alphaOnly = (value) => nameRegex.test(value);

const rules = computed(() => ({
    fullname: {
        required: helpers.withMessage("សូមបញ្ចូលឈ្មោះរបស់អ្នក", required),
        alphaOnly: helpers.withMessage("ឈ្មោះត្រូវមានតែអក្សរប៉ុណ្ណោះ", alphaOnly)
    },
 
    email: {
    required: helpers.withMessage("សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលរបស់អ្នក", required),
    email: helpers.withMessage("សូមបញ្ចូលអ៊ីមែលដែលមាន @ និង .com", email),
    
  },

}));

const verifypassword = computed(()=>userstore.userfrm.new_password);

const passwordroles = computed(()=>({
    old_password: {
        required: helpers.withMessage("សូមបញ្ចូលពាក្យសម្ងាត់ចាស់", required)
    },
    new_password : {
         required: helpers.withMessage("សូមបញ្ចូលពាក្យសម្ងាត់ថ្មី", required),
         minLength: helpers.withMessage("ពាក្យសម្ងាត់ត្រូវមានយ៉ាងហោចណាស់ 8 តួអក្សរ", minLength(8))
    },
    confirm_password: {
        required: helpers.withMessage("សូមបញ្ចូលផ្ទៀងផ្ទាត់ពាក្យសម្ងាត់ថ្មី", required),
        sameAs: helpers.withMessage('ពាក្យសម្ងាត់មិនដូចគ្នាទៅនឹងការផ្ទៀងផ្ទាត់',sameAs(verifypassword))
    },
}));

userstore.vvuser = useVuelidate(rules,userstore.userfrm)
userstore.vvpassword = useVuelidate(passwordroles,userstore.userfrm)


const onClickUpdateUser = async () => {
        // alert(authStore.token);
        userstore.vvuser.$touch();
    if (userstore.vvuser.$invalid) {  
        return;
        // alert('error');
        
    }

        const params = new URLSearchParams();
        params.append('fullname', userstore.userfrm.fullname);
        params.append('email', userstore.userfrm.email);


        try{
            const response = await axios.put('/api/users/info',params,{
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept':'application/json',
                    'Authorization': 'Bearer '+ authStore.token

                },
            });
            document.getElementById('titletoastsuccess').innerHTML = 'ផ្លាស់ប្តរូព័ត៌មានផ្ទាល់ខ្លួន ជោគជ័យ';
            document.getElementById('subtitletoastsuccess').innerHTML = 'អ្នកបានផ្លាស់ប្តរូព័ត៌មានផ្ទាល់ខ្លួនរបស់អ្នក បានដោយជោគជ័យ';

                userstore.tostsuccess.show();
                userstore.onLoadData();
                
        }
        catch(error)
        {
            // console.error(error);
             document.getElementById('titletoast').innerHTML = 'ផ្លាស់ប្តរូព័ត៌មានផ្ទាល់ខ្លួន បរាជ័យ';
        document.getElementById('subtitletoast').innerHTML = 'អាស័យដ្ឋានអ៊ីមែលត្រូវបានគេប្រើប្រាស់រួចហើយ សូមបញ្ចូលអាស័យដ្ឋានអ៊ីមែលផ្សេងទៀត';
            authStore.toastfail.show();
            
        }
    }
    

    const onResetPassword =  async() =>{
        userstore.vvpassword?.$touch();

        if(userstore.vvpassword?.$invalid)
        {
        // alert('error');

            return ;
        }

        const param = new URLSearchParams();
        param.append('current_password',userstore.userfrm.old_password);
        param.append('new_password',userstore.userfrm.new_password);
        param.append('new_password_confirmation',userstore.userfrm.new_password);

        try{

            const res =  await axios.put(`/api/users/update-password`,param,{
                headers:{
                    Authorization:'Bearer ' + authStore.token
                }
            });
            document.getElementById('titletoastsuccess').innerHTML = 'ផ្លាស់ប្ដូរពាក្យសម្ងាត់ ជោគជ័យ';
            document.getElementById('subtitletoastsuccess').innerHTML = 'អ្នកបានផ្លាស់ប្តរូពាក្យសម្ងាត់របស់អ្នក បានដោយជោគជ័យ';
            userstore.tostsuccess.show();
            userstore.CLearResetPassword();
            
        }catch(error)
        {   
            authStore.isresetpassfail = 1;
            document.getElementById('titletoast').innerHTML = 'ផ្លាស់ប្ដូរពាក្យសម្ងាត់ បរាជ័យ'
            document.getElementById('subtitletoast').innerHTML = 'ពាក្យសម្ងាត់ចាស់មិនត្រឹមត្រូវ សូមព្យាយាមម្ដងទៀត'

            authStore.toastfail.show();
            // console.log('reset password error',error);
            
        }
        
    
    
    }
    





const onOpenMdlCrop = () => {
    Store.mdl_crop_profile.show();
}

const onChooseImage = () => {
    
    document.getElementById('file-image').value = '';
    document.getElementById('file-image').click();
}

// const onSelectFile = (e) => {
    
//     if (e.currentTarget.files.length === 0) {
//         return;
//     }

//     const file = e.currentTarget.files[0]
//     if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
//         alert('File type must be image (.png, .jpg).')
//         return
//     }
//     if (file.size / 1048576 > 10) {
//         alert('Max file size 5MB.')
//         return
//     }

//     Store.img= URL.createObjectURL(file)
//     Store.mdl_crop_profile.show();
// }


</script>