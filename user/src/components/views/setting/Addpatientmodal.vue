<template>
    <div class="setting addpatient">

        <div class="modal fade" id="mdl-add-patient" tabindex="-1" aria-labelledby="mdl-add-patientLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0 pt-4 px-4 pb-0">
                        <div>
                            <h5 class="modal-title fs-5 mb-0 pb-0" id="mdl-add-patientLabel">បញ្ចូលព័ត៌មានអ្នកជំងឺ</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mt-0  p-4 pt-2">
                        <p style="font-size: 14px ;">បន្ថែម
                                ឬកែសម្រួលព័ត៌មានអំពីអ្នកជំងឺផ្សេងៗដើម្បីមានភាពងាយស្រួលក្នុងការបំពេញព័ត៌មាននៅពេលធ្វើការកក
                            </p>
                        <form action="" class="mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">នាមត្រកូល<span style="color: #B90000;">*</span> </label>
                                        <input class="form-control-global" id="last_name"
                                            placeholder="នាមត្រកូល" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">នាមខ្លួន<span style="color: #B90000;">*</span> </label>
                                        <input class="form-control-global" id="first_name"
                                            placeholder="នាមខ្លួន" type="text">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">ថ្ងៃ ខែ ឆ្នាំកំណើត<span style="color: #B90000;">*</span> </label>
                                        <input class="form-control-global" id="dob" type="text"
                                            placeholder="ថ្ងៃខែឆ្នាំកំណើត">
                                    </div>
                                </div>
                                <div class="col-6">
                                    
                                    <label for="gender" class="form-label">ភេទ<span style="color: #B90000;">*</span> </label><br>
                                    <input type="radio" id="female" class="form-check-input" value="female" name="gender">
                                    <label for="female" class="form-label ms-2 me-4">ស្រី</label>
                                    <input type="radio" class="form-check-input" id="male" value="male" name="gender">
                                    <label for="male"  class="form-label ms-2">ប្រុស</label>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">លេខទូរស័ព្ទ<span style="color: #B90000;">*</span> </label>
                                        <input class="form-control-global" id="phone" type="text"
                                            placeholder="លេខទូរស័ព្ទ">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">អ៊ីមែល<span style="color: #B90000;">*</span> </label>
                                        <input class="form-control-global" id="email" type="text"
                                            placeholder="អ៊ីមែល">
                                    </div>
                                </div>
                                <div class="col-12 mt-2  d-flex gap-2">
                                    <a role="button" class="btn-bg-650 btn-delete mb-0" data-bs-dismiss="modal">បោះបង់</a>
                                    <a role="button" class="btn-bg-650   mb-0  ">រក្សាទុក</a>
                                </div>
                            </div>

                        </form>

                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import { onMounted } from 'vue';
import { Modal } from 'bootstrap';
import { historyStore } from '@/stores/historyStore';

const HistoryStore = historyStore();

onMounted(() => {
    HistoryStore.mdl_add_patient = Modal.getOrCreateInstance(document.getElementById('mdl-add-patient'));
})

</script>