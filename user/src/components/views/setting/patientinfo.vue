<template>
    <main class="patienfinfo setting">
        <div class="wrapper bg-white overflow-hidden ">
            <div class=" d-flex bg-white p-3 align-items-center justify-content-between">
                <div>
                    <h5 class=" setting-title text-color-950 ">ព័ត៌មានអ្នកជំងឺផ្សេងៗ</h5>
                    <span class="text-color-gray txt-small ">បន្ថែម
                        ឬកែសម្រួលព័ត៌មានអំពីអ្នកជំងឺផ្សេងៗដើម្បីមានភាពងាយស្រួលក្នុងការបំពេញព័ត៌មាននៅពេលធ្វើការកក</span>
                </div>
                <div>
                    
                            <primaryBtn  label="<i
                            class='fa-regular fa-plus'></i> បន្ថែមអ្នកជំងឺ</a>"/>
                </div>

            </div>

            <div id="delete_item d-none">

                <div id="" class="d-flex  mt-2 p-3  justify-content-between align-items-center alertdelete">
                    <div style="color:#707070 ;">
                        <i class="fa-regular fa-x me-3"></i>
                        <span>ជ្រើសរើស 2(ទាំងអស់)</span>
                    </div>
                    <div>
                        <a role="button" class="btn-bg-650 btn-delete  mb-0">លុបចោល</a>
                    </div>
                </div>
            </div>

            <div class="bg-white  pateintlist p-3 pt-0">

                <table class="table ">
                    <thead>
                        <tr class=" align-middle">
                            <th scope="col ">
                                <button  
                                    class=" border-0 p-0 bg-transparent">
                                    <div class="check-delete">
                                        <i class="fa-duotone text-white opacity-0  fa-solid fa-check"
                                            style="font-size: 13px;"></i>
                                    </div>
                                </button>
                                កាលបរិច្ឆេទបង្កើត
                            </th>
                            <th scope="col">ឈ្មោះ</th>
                            <th scope="col">ភេទ</th>
                            <th scope="col">ថ្ងៃ ខែ ឆ្នាំកំណើត</th>
                            <th scope="col">អាស័យដ្ធានអ៊ីមែល</th>
                            <th scope="col">លេខទូរស័ព្ទ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="patient in PatientStore.patient" :key="patient.id">
                            <td class="">
                                <button v-show="!patient.is_selected" @click="OnclickSelected(patient.id)"
                                    class=" border-0 p-0 bg-transparent">
                                    <div class="check-delete">
                                        <i class="fa-duotone text-white opacity-0  fa-solid fa-check"
                                            style="font-size: 13px;"></i>
                                    </div>
                                </button>
                                <button v-show="patient.is_selected"  @click="OnclickUnselected(patient.id)"  
                                    class=" border-0 p-0">
                                    <div class="check-delete check">
                                        <i class="fa-duotone text-white  fa-solid fa-check"
                                            style="font-size: 13px;"></i>
                                    </div>
                                </button>
                                {{ patient.create_at }}
                            </td>
                            <td>{{ patient.name }}</td>
                            <td>{{ patient.gender }}</td>
                            <td>{{ patient.dob }}</td>
                            <td>{{ patient.email }}</td>
                            <td>{{ patient.phone }}</td>

                        </tr>


                    </tbody>
                </table>

                <table class="table mx-auto">
                    <tbody class="text-center">
                        <tr class="nodata">
                            <td colspan="6" class="text-center">
                                <div class="d-flex justify-content-center align-items-center" style="width: 220px;">
                                    <img src="/src/assets/images/auth/icon/filedata.jpg" alt="Image" class="img-fluid">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</template>

<script setup>




import { patientStore } from '@/stores/patientinfo';
import primaryBtn from '@/views/primaryBtn.vue';



const PatientStore = patientStore();

const onClickAddPatient = () => {
    PatientStore.mdl_add_patient.show();
}

const OnclickSelected = (id) => {
    let index = PatientStore.patient.findIndex((item) => item.id == id);
    PatientStore.patient[index].is_selected = true;
    document.getElementById('delete_item').style.display = "block";
}
const OnclickUnselected = (id) => {
    let index = PatientStore.patient.findIndex((item) => item.id == id);
    PatientStore.patient[index].is_selected = false;
    document.getElementById('delete_item').style.display = "block";
}










</script>



<!--  -->



