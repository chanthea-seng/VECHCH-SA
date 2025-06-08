<template>
    <section class="choose-option" v-if="!Appointment.showhistory">
        <div class="container">
            <div class="sec-title">
                <h5 class="text-color-800">ជ្រើសរើសមុខងារ</h5>
                <p class="text-muted">សូមជ្រើសរើសមុខងារដែលអ្នកពេញចិត្ត ដើម្បីធ្វើការណាត់ជួបជាមួយអ្នកជំនាញរបស់យើង</p>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-6" v-for="book in option" :key="book.id">
                    <div class="card border-0">
                        <label class="border rounded-4" @click="Appointment.setConsultOption(book.id)"
                            :class="{ 'border-wrapper': Appointment.consult_option === book.id }">
                            <div class="custom-card d-flex justify-content-between p-3 align-items-center">
                                <div class="card-icon">
                                    <img :src="book.icon" alt="" class="img-fluid" />
                                </div>
                                <div class="card-title ms-2 ms-md-4">
                                    <h5 class="m-0">{{ book.title }}</h5>
                                </div>
                                <div class="custom-radio">
                                    <input type="radio" name="custom-radio"
                                        :checked="Appointment.consult_option === book.id" />
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="selected doctor mt-5" v-if="Appointment.consult_option === 1">
                    <div class="sec-title text-color-800">
                        <h5>ជ្រើសរើសវេជ្ជបណ្ឌិត</h5>
                    </div>
                    <div class="tab-wrrapper ">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" v-for="tab in Appointment.tabsOption" :key="tab.id"
                                role="presentation">
                                <button class="nav-link" :class="{ active: Appointment.activeTab === tab.id }"
                                    @click="Appointment.changeTab(tab.id)">
                                    {{ tab.title }}
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div v-if="Appointment.activeTab === 1">
                                <div class="container">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <!-- <searchBar class="col-12" /> -->
                                            <div class="col-12 position-relative">
                                                <div class="search-container d-flex align-items-center">
                                                    <div class="select-wrapper col-3">
                                                        <select name="cate" id="cate"
                                                            class="form-select form-select-global"
                                                            placeholder="ជ្រើសរើសប្រភេទ" @focus="isSelectOpen = true"
                                                            @blur="isSelectOpen = false"
                                                            v-model="store.filter.specialist">
                                                            <option v-for="item in store.specialists" :key="item.id"
                                                                :value="item.id">
                                                                {{ item.local_name }}
                                                            </option>
                                                        </select>
                                                        <i :class="[
                                                            'bi',
                                                            'bi-chevron-down',
                                                            'select-icon',
                                                            { rotate: isSelectOpen },
                                                        ]"></i>
                                                    </div>
                                                    <input type="text" class="form-control bg-transparent"
                                                        placeholder="ស្វែងរកឈ្មោះវេជ្ជបណ្ឌិត" aria-label="Search"
                                                        @focus="showSearch = true" @blur="hideSearch"
                                                        v-model="Appointment.filter.inputSearch" @input="Appointment.getdoctorSearch()" />
                                                    <span class="search-icon position-absolute">
                                                        <i class="fa-regular fa-magnifying-glass"></i>
                                                    </span>
                                                </div>
                                                <div class="card card-search position-absolute z-3" v-if="showSearch"
                                                    @mousedown.prevent>
                                                    <ul class="list-group">
                                                        <li class="list-group-item" v-for="data in store.inputDoctor"
                                                            :key="data.id">
                                                            <a role="button"
                                                                class="d-flex justify-content-between align-items-center text-decoration-none text-color-950"
                                                                @click="store.getInput(data.id)">
                                                                <span>{{ data.user.local_fullname }}</span>
                                                                <div class="dot"></div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" v-for="doc in Appointment.doctors" :key="doc.id">
                                            <div class="card p-0 rounded-4">
                                                <div
                                                    class="card-body d-flex flex-column flex-md-row justify-content-between ">
                                                    <div class="col-9 col-md-10 doctor-card ">
                                                        <div class="row">
                                                            <div class="col-5 col-md-4 doctor-image ">
                                                                <img :src="doc.user.avatar" alt=""
                                                                    class="img-fluid  card-img-top rounded-4">
                                                            </div>
                                                            <div class="col-7 col-md-8 doctor-info my-0 my-lg-2 ">
                                                                <h3 class="text-color-800">វេជ្ជបណ្ឌិត {{
                                                                    doc.user.local_fullname }}</h3>
                                                                <div class="mt-0 mt-lg-3">
                                                                    <span>ឯកទេស</span>
                                                                    <p class="text-color-800 ">{{
                                                                        doc.specialist.local_name }}</p>
                                                                </div>
                                                                <div
                                                                    class="d-flex d-none d-md-block justify-content-between gap-0 gap-lg-5">
                                                                    <div class=" ">
                                                                        <span>មជ្ឈមណ្ឌល</span>
                                                                        <p class="text-color-800 ">{{
                                                                            doc.center.local_name }}</p>
                                                                    </div>
                                                                    <div class="">
                                                                        <span>ភាសា</span>
                                                                        <p class="text-color-800 ">{{
                                                                            doc.user.languages.join(', ') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a role="button" class="btn btn-booking rounded-3"
                                                            @click="Appointment.BookItem(doc)">កក់ឥឡូវនេះ</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="Appointment.activeTab === 2">
                                <div class="container">
                                    <div class="row g-3">
                                        <div class="col-12" v-for="doc in store.SaveDoctorData" :key="doc.id">
                                            <div class="card p-0 rounded-4">
                                                <div
                                                    class="card-body d-flex flex-column flex-md-row justify-content-between ">
                                                    <div class="col-9 col-lg-10 doctor-card ">
                                                        <div class="row ">
                                                            <div class="col-4 doctor-image ">
                                                                <img :src="doc.avatar" alt=""
                                                                    class="img-fluid  card-img-top rounded-4">
                                                            </div>
                                                            <div class="col-8 doctor-info my-0 my-lg-2 ">
                                                                <h3 class="text-color-800">វេជ្ជបណ្ឌិត {{
                                                                    doc.local_fullname }}</h3>
                                                                <div class="mt-0 mt-lg-3">
                                                                    <span>ឯកទេស</span>
                                                                    <p class="text-color-800 ">{{
                                                                        doc?.specialist?.local_name }}</p>
                                                                </div>
                                                                <div
                                                                    class="d-flex d-none d-md-block justify-content-between gap-0 gap-lg-5">
                                                                    <div class=" ">
                                                                        <span>មជ្ឈមណ្ឌល</span>
                                                                        <p class="text-color-800 ">{{
                                                                            doc?.center?.local_name }}</p>
                                                                    </div>
                                                                    <div class="">
                                                                        <span>ភាសា</span>
                                                                        <p class="text-color-800 ">{{ doc?.languages?.join(', ')  }}</p> 

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div>
                                                            <a role="button" class="btn btn-booking rounded-3"
                                                                @click="Appointment.BookItem(doc)">កក់ឥឡូវនេះ</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else-if="Appointment.consult_option == 2">
                    <div class="container">
                        <div class="sec-title mt-3">
                            <h5 class="text-color-800">ស្ថានភាពសុខភាព</h5>
                            <p class="text-color-800">បញ្ហាសុខភាព ឬរោគសញ្ញា*</p>
                            <div class="mb-3">
                                <textarea class="form-control" id="text" rows="4"
                                    v-model="Appointment.bookingfrm.description"
                                    placeholder="សូមពន្យល់ពីបញ្ហាសុខភាព ឬរោគសញ្ហារបស់លោកអ្នក"></textarea>
                            </div>
                        </div>
                        <div>
                            <h5 class="text-color-800">ឯកសារយោង</h5>
                            <div>
                                <a role="button" @click="AddFile()">
                                    <div class="col-12">
                                        <div class="card d-flex justify-content-center align-items-center p-4 dashed">
                                            <div class="card-import-file d-flex align-items-center gap-3">
                                                <span class="fs-2 text-muted">
                                                    <i class="fa-regular fa-file-import"></i>
                                                </span>
                                                <div>
                                                    <span> ឯកសារយោង</span><br>
                                                    <span>3 MB Maximum file size (PDF/JPG/PNG)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <input type="file" class="d-none" id="file" @change="seletedFile($event)"
                                    accept="image/*,application/pdf">
                            </div>
                            <div class="file-show border mt-2 rounded-4" v-if="Appointment.fileShow.file">
                                <div class="p-2 px-3 d-flex justify-content-between">
                                    <a class="file-show" :href="Appointment.fileShow.filePreview" target="_blank">{{
                                        Appointment.fileShow.file }}</a>
                                    <a role="button" @click="RemoveFile">
                                        <i class="fa-regular fa-xmark"></i>
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

                                    <!-- <div v-if="storecalender.selectedDate" class="">
                                        <div class="row g-3">
                                            <div class="col-6" v-for="slot in storecalender.availableSlots" :key="slot">
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
                                    </div> -->
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
        </div>
    </section>
    <section class="show-booking mt-4" v-if="Appointment.showhistory">
        <div class="container" v-if="Appointment.bookingHistory.length > 0">
            <div class="sec-title">
                <h5 class="text-color-800">ជ្រើសរើសវេជ្ជបណ្ឌិត</h5>
                <p class="text-muted">លោកអ្នកបានជ្រើសរើសវេជ្ជបណ្ឌិតខាងក្រោម</p>
            </div>
            <div class="row">
                <div class="col-12" v-for="history in Appointment.bookingHistory" :key="history.id">
                    <div class="card p-0 rounded-4">
                        <div class="card-body d-flex  justify-content-between ">
                            <div class="col-10 doctor-card ">
                                <div class="row ">
                                    <div class="col-4 doctor-image ">
                                        <img :src="history.user?.avatar ?? history.avatar" alt=""
                                            class="img-fluid  card-img-top rounded-4">
                                    </div>
                                    <div class="col-8 doctor-info my-0 my-lg-2 ">
                                        <h3 class="text-color-800">វេជ្ជបណ្ឌិត
                                            {{ history.user?.local_fullname ?? history.local_fullname }}</h3>
                                        <div class="mt-0 mt-lg-3">
                                            <span>ឯកទេស</span>
                                            <p class="text-color-800 ">{{ history?.specialist?.local_name }} </p>
                                        </div>
                                        <div class="d-flex d-none d-md-block justify-content-between gap-0 gap-lg-5">
                                            <div class=" ">
                                                <span>មជ្ឈមណ្ឌល</span>
                                                <p class="text-color-800 ">{{ history?.center?.local_name }}</p>
                                            </div>
                                            <div class="">
                                                <span>ភាសា</span>
                                                <p class="text-color-800 ">{{ (history?.user?.languages ?? history?.languages ?? []).join(', ') }}
 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-end">
                                <div class=" d-none d-md-block">
                                    <a class="save-icon  mt-1 text-color-800" role="button" @click="Appointment.GoBack">
                                        <span class=""><i class="fa-regular fa-rotate-right"></i></span> ផ្លាស់ប្តូរ
                                    </a>
                                </div>
                                <div class="d-block d-md-none">
                                    <a class="save-icon  mt-1 text-color-800" role="button" @click="Appointment.GoBack">
                                        <span class=""><i class="fa-regular fa-rotate-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sec-title mt-3">
                    <h5 class="text-color-800">ស្ថានភាពសុខភាព</h5>
                    <p class="text-color-800">បញ្ហាសុខភាព ឬរោគសញ្ញា*</p>
                    <div class="mb-3">
                        <textarea class="form-control" id="text" rows="4" v-model="Appointment.bookingfrm.description"
                            placeholder="សូមពន្យល់ពីបញ្ហាសុខភាព ឬរោគសញ្ហារបស់លោកអ្នក"></textarea>
                    </div>
                </div>
                <div>
                    <h5 class="text-color-800">ឯកសារយោង</h5>
                    <div>
                        <a role="button" @click="AddFile()">
                            <div class="col-12">
                                <div class="card d-flex justify-content-center align-items-center p-4 dashed">
                                    <div class="card-import-file d-flex align-items-center gap-3">
                                        <span class="fs-2 text-muted">
                                            <i class="fa-regular fa-file-import"></i>
                                        </span>
                                        <div>
                                            <span> ឯកសារយោង</span><br>
                                            <span>3 MB Maximum file size (PDF/JPG/PNG)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <input type="file" class="d-none" id="file" @change="seletedFile($event)"
                            accept="image/*,application/pdf">
                    </div>
                    <div class="file-show border mt-2 rounded-4" v-if="Appointment.fileShow.file">
                        <div class="p-2 px-3 d-flex justify-content-between">
                            <a class="file-show" :href="Appointment.fileShow.filePreview" target="_blank">{{
                                Appointment.fileShow.file }}</a>
                            <a role="button" @click="RemoveFile">
                                <i class="fa-regular fa-xmark"></i>
                            </a>
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
                                        <div class="col-6" v-for="slot in storecalender.availableSlots" :key="slot">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script setup>
import { ref, watch, onMounted, nextTick } from 'vue';
import { appointment } from '@/stores/bookingstore';
import { historySearch } from '@/stores/finddcotorstore';
import { calenderStore } from '@/stores/calenderstore';
import searchBar from '../layouts/searchBar.vue';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Khmer } from "flatpickr/dist/l10n/km.js";


const store = historySearch();
const Appointment = appointment();
const storecalender = calenderStore();
const calendar = ref(null);

const option = Appointment.options;
// const doctors = Appointment.doctors;

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
                onChange: (selectedDates, dateStr) => {
                    if (selectedDates.length > 0) {
                        storecalender.setSelectedDate(dateStr);
                        fetchAvailableSlots(dateStr);
                        // console.log("Selected Date:", dateStr);
                    }
                },
            });
        }
    });
};

const fetchAvailableSlots = async (date) => {
    if (!date || !Appointment.bookingHistory.length) {
        // console.log('Cannot fetch slots: Missing date or booking history', { date, bookingHistory: Appointment.bookingHistory });
        return;
    }
    const doctorId = Appointment.bookingHistory[0].id;
    // console.log('Fetching slots for doctorId:', doctorId, 'and date:', date);

    const dateTime = new Date(date);
    dateTime.setHours(8, 0, 0, 0);

    if (typeof storecalender.fetchAvailableSlots !== 'function') {
        console.error('fetchAvailableSlots is not a function on storecalender');
        storecalender.error = 'Unable to fetch available slots. Please try again later.';
        return;
    }

    await storecalender.fetchAvailableSlots(doctorId, dateTime.toISOString());
    // console.log('After fetch - availableSlots:', storecalender.availableSlots);
};

watch(
    () => Appointment.showhistory, (newVal) => {
        if (newVal) {
            initCalendar();
        }
    }
);
watch(
    () => Appointment.consult_option,
    (newVal) => {
        if (newVal === 2) {
            initCalendar();
        }
    }
);
onMounted(() => {
    initCalendar();
    Appointment.getAlldoctor();
    store.onloadSave();
    store.getSpecialists();
    Appointment.getdoctorSearch();

});

const AddFile = () => {
    const inputfile = document.getElementById('file');
    inputfile.value = '';
    inputfile.click();
};

const seletedFile = (e) => {
    if (e.target.files.length == 0) {
        return;
    }
    const file = e.target.files[0];

    if (file) {
        Appointment.setFile(file);
        // console.log(Appointment.fileShow);
    }

};
const RemoveFile = () => {
    Appointment.removeFile();
};

</script>
<style>
.file-show {
    color: var(--color-800);
}

.file-show:hover {
    text-decoration: underline;
    transition: 0.5s;
}
</style>
