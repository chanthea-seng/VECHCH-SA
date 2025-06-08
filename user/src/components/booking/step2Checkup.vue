<template>
    <section class="choose-option" v-if="!store.showhistory">
        <div class="container">
            <div class="sec-title">
                <h5 class="text-color-800">ជ្រើសរើសប្រភេទនៃកញ្ចប់ពិនិត្យសុខភាព</h5>
                <p class="text-muted">សូមជ្រើសរើសប្រភេទនៃកញ្ចប់ពិនិត្យសុខភាពដែលអ្នកពេញចិត្ត
                    ដើម្បីធ្វើការណាត់ជួបជាមួយអ្នកជំនាញរបស់យើង</p>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    <section class="packages" v-if="!store.showhistory">
        <div class="container">
            <div class="sec-title">
                <h5 class="text-color-800">កញ្ចប់ពិនិត្យសុខភាពសម្រាប់អ្នក</h5>
            </div>
            <div class="row g-3">
                <div class="col-12" v-for="packages in store.package" :key="packages.id">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-12 col-md-5">
                                <div class="card-img-package">
                                    <img :src="packages.thumbnail" alt="" class="img-fluid rounded-4">
                                </div>
                            </div>
                            <div class="col-12 col-md-7">
                                <div class="card border-0">
                                    <div class="sec-title">
                                        <h4 class="text-color-800">{{ packages.name }}</h4>
                                        <p>{{ packages.description }} <a href="" class="text-color-800">អានបន្ថែម <i
                                                    class="fa-regular fa-angle-right"></i></a></p>
                                    </div>
                                    <div class="booking-wrapper d-flex  gap-2 align-items-center ">
                                        <span class="text-color-800"> <i class="fa-regular fa-bag-shopping"></i> {{ packages.sub_services_count }}
                                            ប្រភេទ</span>
                                        <button type="button" class="btn btn-booking rounded-3 "
                                            @click="bookPackage(packages.id)">កក់ឥឡូវនេះ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="show-booking" v-if="store.showhistory">
        <div class="container">
            <div class="sec-title">
                <h5 class="text-color-800">ជ្រើសរើសប្រភេទនៃកញ្ចប់ពិនិត្យសុខភាព</h5>
                <p class="text-muted">លោកអ្នកបានជ្រើសរើសប្រភេទកញ្ចប់សម្រាប់ពិនិត្យសុខភាពខាងក្រោម</p>
            </div>
            <div class="row">
                <div class="col-12" v-for="(history, index) in store.bookingHistory" :key="index">
                    <div class="card p-0 p-lg-4 rounded-4">
                        <div class="card-body d-flex justify-content-between">
                            <div class="sec-title">
                                <h6 class="text-color-800">ឈ្មោះប្រភេទកញ្ចប់</h6>
                                <h4 class="text-color-800">{{ store.PackageName }}</h4>
                                <div class="d-flex  gap-0 gap-md-5 flex-column flex-md-row">
                                    <ul class="list-unstyled ">
                                        <li class="package-ul-li">{{ history.description }}</li>

                                    </ul>

                                </div>
                                <div class="price text-color-800">
                                    <h6>តម្លៃ</h6>
                                    <p>$ {{ history.price }}</p>
                                </div>
                            </div>
                            <div class=" d-none d-md-block">
                                <a class="save-icon  mt-1 text-color-800" role="button" @click="store.GoBack">
                                    <span class=""><i class="fa-regular fa-rotate-right"></i></span> ផ្លាស់ប្តូរ
                                </a>
                            </div>
                            <div class="d-block d-md-none">
                                <a class="save-icon  mt-1 text-color-800" role="button" @click="store.GoBack">
                                    <span class=""><i class="fa-regular fa-rotate-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- calender  -->
                <div class="container py-3">
                    <div class="sec-title">
                        <h6 class="datepicker text-color-800">កាលបរិច្ឆេទ</h6>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <!-- <label for="datepicker">Preferred Date:</label> -->
                            <div id="calendar" ref="calendar"></div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 bg-transparent">
                                <div class="sec-title">
                                    <h5 class="text-color-800">ជ្រើសរើសម៉ោង</h5>
                                    <p class="text-muted">សូមជ្រើរើសម៉ោងដែលលោកអ្នកចង់ណាត់ជួប</p>
                                </div>

                                <div v-if="storecalender.selectedDate" class="">
                                    <div class="row g-3">
                                        <div class="col-6" v-for="slot in storecalender.timeSlots" :key="slot">
                                            <div class="time-slots">
                                                <div class="time-slots">
                                                    <button @click="storecalender.setSelectedTime(slot)"
                                                        :class="{ selected: slot === storecalender.selectedTime }, { class: 'btn btn-booking' }">
                                                        {{ slot }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>

                                    </div>
                                </div>
                                <!-- <p v-if="storecalender.selectedDate && storecalender.selectedTime">
                                    Selected Date: {{ storecalender.selectedDate }} <br />
                                    Selected Time: {{ storecalender.selectedTime }}
                                </p> -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="mdl-package" tabindex="-1" aria-labelledby="mdl-package" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen ">
            <div class="container-fluid p-0">
                <div class="modal-content" style="min-height: 100vh;">
                    <div class="container-fluid container-md">
                        <div class="modal-body">
                            <div class="d-flex justify-content-between">
                                <div class="sec-title text-color-800">
                                    <div class="py-3">
                                        <span class=" border-0 p-2 rounded-4 btn-booking">កក់ឥឡូវនេះ</span>
                                    </div>
                                    <h3>ពិនិត្យសុខភាពទូទៅ</h3>
                                    <span><i class="fa-regular fa-timer"></i> ចុះផ្សាយនៅថ្ងៃ៖ 12 មករា 2025</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="package-detail-content mt-4">
                                <p>
                                    ការពិនិត្យសុខភាពប្រចាំឆ្នាំគឺជាវិធីល្អបំផុតមួយដើម្បីការពារសុខភាពរបស់អ្នក។
                                    របៀបរស់នៅដែលមានសុខភាពល្អមានន័យថា ការជ្រើសរើសត្រឹមត្រូវក្នុងរបបអាហារ និងការហាត់ប្រាណ
                                    ព្រមទាំងមានការត្រួតពិនិត្យសុខភាពជាទៀងទាត់ ដើម្បីធានាថារាងកាយរបស់អ្នកដើរលើផ្លូវត្រូវ
                                    និងដើម្បីកំណត់បញ្ហា ឬបញ្ហាសុខភាពដែលកំពុងកើតមាន។ ជាមួយនឹងការរកឃើញជំងឺ
                                    ឬលក្ខខណ្ឌទាន់ពេលវេលា
                                    ជំងឺជាច្រើនអាចត្រូវបានព្យាបាល មុនពេលដែលវាបង្កបញ្ហាធ្ងន់ធ្ងរដល់សុខភាពរបស់អ្នក។
                                </p>
                                <div class="package-detail-table">
                                    <p class="mt-5">
                                        ហើយខាងក្រោមនេះគឺជាប្រភេទនៃកញ្ចប់សម្រាប់ធ្វើការពិនិត្យសុខភាពទៅតាមប្រភេទនៃជំងឺ៖
                                    </p>
                                    <div class="package-detail-list table-responsive">
                                        <table class="table table-bordered package-detail-list">
                                            <thead class="table-info-list">
                                                <tr>
                                                    <th>ប្រភេទកញ្ចប់</th>
                                                    <th>ផ្តល់ជូនសេវាកម្ម</th>
                                                    <th>តម្លៃ</th>
                                                    <th>អាចរកបាន</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbl-list">
                                                <tr v-for="(list, index) in store.packageList" :key="index">
                                                    <td scope="row" class="package-td"> ប្រភេទ {{ index + 1 }} </td>
                                                    <td>
                                                        <ul class="">
                                                            <li class="">{{ list.description }}</li>

                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul class=" m-0">
                                                            <li class="">$ {{ list.price }}</li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-booking"
                                                            @click="store.BookItem(list)">កក់ឥឡូវនេះ</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script setup>
import { appointment } from '@/stores/bookingstore';
import { ref, onMounted, nextTick, watch } from 'vue';
import { Modal } from 'bootstrap';
import axios from 'axios';
import { calenderStore } from '@/stores/calenderstore';
import searchBar from '../layouts/searchBar.vue';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Khmer } from "flatpickr/dist/l10n/km.js";
// import searchDoctor from '../layouts/searchDoctor.vue';

const store = appointment();
const storecalender = calenderStore();
const calendar = ref(null);
// const selectedPackage = ref(null);

const bookPackage = (id) => {

    store.services_id = id;
    axios.get(`/api/services/${id}`)
        .then(res => {
            store.mdl_packages.show();
            // console.log(res.data);
            store.packageList = res.data.data.sub_services;
            store.PackageName = res.data.data.name;
        });

}
const initCalendar = () => {
    nextTick(() => {
        if (calendar.value) {
            if (calendar.value._flatpickr) {
                calendar.value._flatpickr.destroy();
            }

            flatpickr(calendar.value, {
                inline: true,
                dateFormat: "Y-m-d",
                locale: Khmer,
                minDate: "today",
                disable: [
                    ...storecalender.disabledDates,
                    (date) => date.getDay() === 0 || date.getDay() === 6,
                ],
                onChange: (selectedDates) => {
                    if (selectedDates.length > 0) {
                        const selectedDate = selectedDates[0].toLocaleDateString('en-US');
                        storecalender.setSelectedDate(selectedDate);
                        // console.log("Selected Date:", selectedDate);
                    }
                },
            });
        }
    });
};
watch(
    () => store.showhistory, (newVal) => {
        if (newVal) {
            initCalendar();
        }
    }
);


onMounted(() => {
    initCalendar();
    store.mdl_packages = Modal.getOrCreateInstance(document.getElementById('mdl-package'));
    store.getServices();

});

</script>
