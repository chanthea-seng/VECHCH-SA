<template>
    <div class="container">
        <div class="sec-title">
            <h5 class="text-color-800">ព័ត៌មានអ្នកជំងឺ</h5>
        </div>
        <div class="row">
            <form action="">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label text-color-800">ឈ្មោះសមីខ្លួន <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="" type="text" placeholder="ឈ្មោះសមីខ្លួន" aria-label=""
                                v-model="bookingfrm.name" :class="{ 'is-invalid': validation?.name?.$error }">
                            <div class="invalid-feedback" v-if="validation?.name?.$error">
                                {{ validation.name.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label text-color-800">ឈ្មោះជាអក្សរឡាតាំង <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="" type="text" placeholder="ឈ្មោះជាអក្សរឡាតាំង" aria-label=""
                                v-model="bookingfrm.local_name"
                                :class="{ 'is-invalid': validation?.local_name?.$error }">
                            <div class="invalid-feedback" v-if="validation?.local_name?.$error">
                                {{ validation.local_name.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="form-label text-color-800">ថ្ងៃ ខែ ឆ្នាំកំណើត <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="" type="date" placeholder="ថ្ងៃខែឆ្មាំកំណើត" aria-label=""
                                v-model="bookingfrm.dob" :class="{ 'is-invalid': validation?.dob?.$error }">
                            <div class="invalid-feedback" v-if="validation?.dob?.$error">
                                {{ validation.dob.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="sec-title mb-3 text-color-800">
                            <span>ភេទ <span class="text-danger">*</span></span>
                        </div>

                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="option1"
                                    :value="2" v-model="bookingfrm.gender" @blur="validation.gender.$touch()" />
                                <label class="form-check-label" for="option1">
                                    ស្រី
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="option2"
                                    :value="1" v-model="bookingfrm.gender" @blur="validation.gender.$touch()" />
                                <label class="form-check-label" for="option2">
                                    ប្រុស
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback d-block" v-if="validation?.gender?.$error">
                            {{ validation.gender.$errors[0].$message }}
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label text-color-800">លេខទូរស័ព្ទ <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="" type="text" placeholder="លេខទូរស័ព្ទ" aria-label=""
                                v-model="bookingfrm.phone_number"
                                :class="{ 'is-invalid': validation?.phone_number?.$error }">
                            <div class="invalid-feedback" v-if="validation?.phone_number?.$error">
                                {{ validation.phone_number.$errors[0].$message }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label for="" class="form-label text-color-800">អ៊ីម៉ែល <span
                                    class="text-danger">*</span></label>
                            <input class="form-control" id="" type="text" placeholder="អ៊ីម៉ែល" aria-label=""
                                v-model="bookingfrm.email" :class="{ 'is-invalid': validation?.email?.$error }">
                            <div class="invalid-feedback" v-if="validation?.email?.$error">
                                {{ validation.email.$errors[0].$message }}
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckDefault"
                                v-model="bookingfrm.checkbox" :class="{ 'is-invalid': validation?.checkbox?.$error }" />
                            <label class="form-check-label" for="flexCheckDefault">
                                ខ្ញុំបានអាននិងយល់ព្រមលើ <RouterLink to="/policyPrivacy" class="text-color-800">គោលការណ៍ឯកជន</RouterLink>
                            </label>
                            <div class="invalid-feedback" v-if="validation?.checkbox?.$error">
                                {{ validation?.checkbox?.$errors[0]?.$message }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="message-alert my-3">
            <p class="text-color-600"><span><i class="fa-regular fa-circle-exclamation"></i></span>
                រាល់ការកក់របស់លោកអ្នកត្រូវបានធ្វើឡើងដោយបណ្ដោះអាសន្ន
                ដោយត្រូវរង់ចាំការបញ្ជាក់ដោយអ្នកជំនាញក្នុងរយៈពេល24ម៉ោង</p>
        </div>
    </div>
</template>
<script setup>
defineProps({
    bookingfrm: { type: Object, required: true },
    validation: { type: Object, required: true },
});


</script>