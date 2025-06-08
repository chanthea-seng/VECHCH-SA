<template>
    <section class="payment">
        <div class="container">
            <div class="sec-title">
                <h5 class="text-color-800">វីធីបង់ប្រាក់</h5>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="px-5 ">
                        <div class="card-scan p-5 box-shadow rounded-4">
                        <img src="/src//assets//img/qrcode.jpg" alt="" class="img-fluid">
                    </div> 
                    </div>
                    <div>
                        <div class="mt-3 px-4">
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
                            <input type="file" class="d-none" id="file" @change="seletedFile($event)"  accept="image/*,application/pdf">
                        </div>
                        <div class="px-4">
                            <div class="file-show  border mt-2 rounded-4" v-if="Appointment.fileShow.file">
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
                </div>
                <div class="col-12 col-md-6" v-for="invoice in Appointment.bookingHistory" :key="invoice.id">
                    <div class="card p-4">
                        <div class="card-title">
                            <h5 class="text-color-800">សេវាកម្មពិនិត្យសុខភាព</h5>
                        </div>
                        <div class="card-body ">
                            <div class="d-flex justify-content-between">
                                <span>ឈ្មោះប្រភេទកញ្ចប់</span>
                                <p>កញ្ចប់វាយតម្លៃសុខភាពបេះដូង</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>កាលបរិច្ឆេទ</span>
                                <p>{{ invoice.appointment_time }}</p>
                                <p>{{calender.selectedDate + " " + calender.selectedTime}}</p>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>បញ្ចុះតម្លៃ</span>
                                <p>0.00</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>តម្លៃសរុប</span>
                                <p>$ {{ invoice.price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>
<script setup>
import { appointment } from '@/stores/bookingstore';
import { calenderStore } from '@/stores/calenderstore';

const calender = calenderStore();
const Appointment = appointment();

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