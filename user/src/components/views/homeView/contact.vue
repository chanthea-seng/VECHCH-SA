<template>
  <div class="contactp position-relative overflow-hidden">
    <section class="hero mt-5 py-5 position-relative z-3">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-8">
            <div class="content px-4 text-center">
              <img
                src="/src/assets/images/auth/Vcs new.png"
                width="60px"
                alt=""
              />
              <h4 class="my-2">ទំនាក់ទំនងមកពួកយើង</h4>
              <p class="text-color-gray fw-medium">
                យើងរីករាយនឹងឮពីអ្នក មិនថាអ្នកមានសំណួរ ត្រូវការជំនួយ
                ឬចង់កក់ការណាត់ជួបទេ ក្រុមការងាររបស់យើងនៅទីនេះដើម្បីជួយលោកអ្នក។
                លោកអ្នកអាចធ្វើការទាក់ទងមកពួកយើងបានគ្រប់ពេលវេលា!
              </p>
            </div>
            <div class="d-flex justify-content-between">
              <div class="feature">
                <i
                  class="fa-duotone fa-solid fa-clock text-color-900 fs-5 me-2"
                ></i>
                សេវាកម្ម 24/7
              </div>
              <div class="feature">
                <i
                  class="fa-sharp-duotone fa-solid fa-bolt text-color-900 fs-5 me-2 opacity-50"
                ></i>
                សេវារហ័ស និងមានប្រសិទ្ធភាព
              </div>
              <div class="feature">
                <i
                  class="fa-duotone fa-solid fa-bed-pulse text-color-900 fs-5 me-2"
                ></i>
                បច្ចេកវិជ្ជាវេជ្ជសាស្ត្រទំនើប
              </div>
              <div class="feature">
                <i
                  class="fa-duotone fa-regular fa-user-doctor fs-5 me-2 text-color-900"
                ></i>
                ក្រុមគ្រូពេទ្យជំនាញ
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="gradient"></div>
    <div class="gradient left"></div>
    <section class="contactinfo position-relative z-3">
      <div class="container">
        <div class="row g-5">
          <div class="col-6">
            <div>
              <h5 class="mb-3">ព័ត៌មានបន្ថែមសម្រាប់ទំនាក់ទំនង</h5>
              <div class="d-flex">
                <div class="wrapper w-50 me-3 mb-3 rounded-3 d-flex">
                  <div class="iconwrap">
                    <i class="bi text-color-700 fs-5 bi-telephone-inbound"></i>
                  </div>
                  <div>
                    <p class="text-color-900 mb-1 fw-medium">
                      លេខទូរស័ព្ទ(សង្គ្រោះបន្ទាន់)
                    </p>
                    <span>+855 987654321</span>
                  </div>
                </div>
                <div class="wrapper w-50 mb-3 rounded-3 d-flex">
                  <div class="iconwrap">
                    <i class="bi text-color-700 fs-5 bi-telephone-inbound"></i>
                  </div>
                  <div>
                    <p class="text-color-900 mb-1 fw-medium">លេខទូរស័ព្ទ</p>
                    <span>+855 987654321</span>
                  </div>
                </div>
              </div>
              <div class="wrapper w-100 mb-3 rounded-3 d-flex">
                <div class="iconwrap">
                  <i class="bi bi-envelope text-color-700 fs-5"></i>
                </div>
                <div>
                  <p class="text-color-900 mb-1 fw-medium">អាស័យដ្ធានអ៊ីមែល</p>
                  <span>vichesalHospital@gmail.com</span>
                </div>
              </div>
              <div class="wrapper w-100 rounded-3 d-flex">
                <div class="iconwrap">
                  <i class="bi bi-geo-alt text-color-700 fs-5"></i>
                </div>
                <div>
                  <p class="text-color-900 mb-1 fw-medium">ទីតាំងមន្ទីពេទ្យ</p>
                  <span>54 St 606, Phnom Penh</span>
                </div>
              </div>
            </div>
            <div
              class="socail position-relative w-100 mt-3 border-radius overflow-hidden"
              style="height: 220px"
            >
              <img
                src="/src/assets/images/auth/homePage/taking-care.jpg"
                class="w-100 h-100 object-fit-cover"
                alt=""
              />
              <div
                class="socail-list d-flex flex-column justify-content-center"
              >
                <h4 class="fs-5 text-white mb-3 text-center">
                  បណ្ដាញសង្គមរបស់យើង
                </h4>
                <div class="text-center">
                  <RouterLink to="" class="text-decoration-none"
                    ><i class="fa-brands fa-facebook text-white fs-3"></i
                  ></RouterLink>
                  <RouterLink to="" class="text-decoration-none"
                    ><i class="fa-brands fa-instagram text-white fs-3"></i
                  ></RouterLink>
                  <RouterLink to="" class="text-decoration-none"
                    ><i class="fa-brands fa-youtube text-white fs-3"></i
                  ></RouterLink>
                  <RouterLink to="" class="text-decoration-none"
                    ><i class="fa-brands fa-linkedin text-white fs-3"></i
                  ></RouterLink>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="contactfrm box-shadow p-4 border-radius bg-white">
              <h5>ទំនាក់ទំនង់ពួកយើងតាមរយៈសារ</h5>

              <form @submit.prevent="sentContact" novalidate>
                <div class="row">
                  <div class="col-6">
                    <div class="mb-3">
                      <label for="first_name" class="form-label">
                        នាមត្រកូល <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        :class="{ 'is-invalid': v$.contactfrm.fname.$error }"
                        id="first_name"
                        placeholder="នាមត្រកូល*"
                        type="text"
                        v-model="contact.contactfrm.fname"
                      />
                      <div
                        v-if="v$.contactfrm.fname.$error"
                        class="invalid-feedback"
                      >
                        {{
                          v$.contactfrm.fname.$errors[0].$message ||
                          "Please enter a valid first name (min 2 characters)"
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label for="last_name" class="form-label">
                        នាមខ្លួន <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        :class="{ 'is-invalid': v$.contactfrm.lname.$error }"
                        id="last_name"
                        placeholder="នាមខ្លួន*"
                        type="text"
                        v-model="contact.contactfrm.lname"
                      />
                      <div
                        v-if="v$.contactfrm.lname.$error"
                        class="invalid-feedback"
                      >
                        {{
                          v$.contactfrm.lname.$errors[0].$message ||
                          "Please enter a valid last name (min 2 characters)"
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="email" class="form-label">
                        អាស័យដ្ធានអ៊ីមែល <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        :class="{ 'is-invalid': v$.contactfrm.email.$error }"
                        id="email"
                        placeholder="អាស័យដ្ធានអ៊ីមែល*"
                        type="email"
                        v-model="contact.contactfrm.email"
                      />
                      <div
                        v-if="v$.contactfrm.email.$error"
                        class="invalid-feedback"
                      >
                        {{
                          v$.contactfrm.email.$errors[0].$message ||
                          "Please enter a valid email address"
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="phone" class="form-label">
                        លេខទូរស័ព្ទ <span class="text-danger">*</span>
                      </label>
                      <input
                        class="form-control"
                        :class="{ 'is-invalid': v$.contactfrm.phone.$error }"
                        id="phone"
                        placeholder="លេខទូរស័ព្ទ*"
                        type="text"
                        v-model="contact.contactfrm.phone"
                      />
                      <div
                        v-if="v$.contactfrm.phone.$error"
                        class="invalid-feedback"
                      >
                        {{
                          v$.contactfrm.phone.$errors[0].$message ||
                          "Please enter a valid phone number (min 10 characters)"
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mb-3">
                      <label for="message" class="form-label">
                        ផ្ញើសារ <span class="text-danger">*</span>
                      </label>
                      <textarea
                        class="form-control"
                        :class="{ 'is-invalid': v$.contactfrm.message.$error }"
                        id="message"
                        placeholder="ផ្ញើសារ*"
                        rows="4"
                        v-model="contact.contactfrm.message"
                      ></textarea>
                      <div
                        v-if="v$.contactfrm.message.$error"
                        class="invalid-feedback"
                      >
                        {{
                          v$.contactfrm.message.$errors[0].$message ||
                          "Please enter a message (min 10 characters)"
                        }}
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <primary-btn
                      class="w-100"
                      label='<span class="text-white fw-medium">ផ្ញើសារ</span>'
                      :click-event="sentContact"
                    />
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="scmap">
      <div class="container">
        <h5 class="fs-4 text-center mb-3">ផែនទី និងទីតាំងមន្ទីពេទ្យ</h5>
        <div class="map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24437.970558703313!2d104.88058998552256!3d11.573139603105494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310951001c8a7b55%3A0xa95ff42ea192073c!2sANT%20Technology%20Training%20School%202!5e0!3m2!1skm!2skh!4v1741340698826!5m2!1skm!2skh"
            width="100%"
            class="border-radius"
            height="450"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </section>
  </div>
</template>
<script setup>
import primaryBtn from "@/views/primaryBtn.vue";
import { useAuthStore } from "@/stores/authTokenStore";
import { useVuelidate } from "@vuelidate/core";
import { required, email, helpers } from "@vuelidate/validators";

import axios from "axios";
import { onMounted, ref } from "vue";

const Token = useAuthStore();

onMounted(() => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

const contact = ref({
  contactfrm: {
    fname: "",
    lname: "",
    email: "",
    phone: "",
    message: "",
  },
});

const rules = {
  contactfrm: {
    fname: {
      required: helpers.withMessage("សូមបញ្ចូលនាមខ្លួន", required),
    },
    lname: {
      required: helpers.withMessage("សូមបញ្ចូលនាមត្រកូល", required),
    },
    email: {
      required: helpers.withMessage("សូមបញ្ចូលអ៊ីមែល", required),
    },
    phone: {
      required: helpers.withMessage("សូមបញ្ចូលលេខទូរស័ព្ទ", required),
    },
    message: {
      required: helpers.withMessage("សូមបញ្ចូលសាររបស់អ្នក", required),
    },
  },
};

const v$ = useVuelidate(rules, contact);
const sentContact = async () => {
  const isValid = await v$.value.$validate();
  if (!isValid) {
    console.log("Validation failed:", v$.value.$errors);
    return;
  }
  Token.loadToken();
  if (!Token.token) {
    return;
  }
  const formdata = new FormData();
  formdata.append("fname", contact.value.contactfrm.fname);
  formdata.append("lname", contact.value.contactfrm.lname);
  formdata.append("email", contact.value.contactfrm.email);
  formdata.append("phone", contact.value.contactfrm.phone);
  formdata.append("message", contact.value.contactfrm.message);
  try {
    const response = await axios.post("/api/contacts", formdata, {
      headers: {
        Authorization: `Bearer ${Token.token}`,
        "Content-Type": "multipart/form-data",
      },
    });
    clearInput();
  } catch (error) {
    // console.log(error);
  }
};
const clearInput = () => {
  contact.value.contactfrm.fname = "";
  contact.value.contactfrm.lname = "";
  contact.value.contactfrm.email = "";
  contact.value.contactfrm.phone = "";
  contact.value.contactfrm.message = "";
  v$.value.$reset();f
};
</script>
