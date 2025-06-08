<template>
  <main class="invoicePage medical-record bg-main">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid">
      <div class="row g-0">
        <div class="col-2 p-0">
          <sidebar />
        </div>
        <div v-if="med" class="col-10 p-0">
          <navhead />

          <div class="title mt-5 mb-4">
            <div
              class="position-relative d-flex flex-column align-items-center justify-content-center"
            >
              <h3 class="text-center">កំណត់ត្រាពិគ្រោះវេជ្ជសាស្ត្រ</h3>
              <span class="pay-Date"
                >កាលបរិច្ឆេទចេញលទ្ធផល៖ {{ med?.created_at }}</span
              >
            </div>
          </div>
          <div class="ps-4">
            <div class="invoice-detail mt-3">
              <div class="d-flex align-items-start justify-content-between">
                <div class="wrapper">
                  <img src="@/assets/image/logo-vcs.png" class="logo" alt="" />
                  <ul class="list-group">
                    <li class="list-group-item">
                      ទីតាំង/
                      <span class="english"
                        >Location: #86B Street 313, Phnom Penh</span
                      >
                    </li>
                    <li class="list-group-item">
                      ទំនាក់ទំនង/
                      <span class="english"
                        >Tell: +855 987654321/+855 123456789</span
                      >
                    </li>
                    <li class="list-group-item">
                      អាសយដ្ធានអ៊ីមែល/<span class="english"
                        >Email Address: vechchsal@gmail.com</span
                      >
                    </li>
                  </ul>
                </div>
                <div class="wrapper right">
                  <ul class="list-group">
                    <li class="list-group-item">
                      លេខសម្គាល់/<span class="english fw-semibold"
                        >Record No: {{ med.invoice }}</span
                      >
                    </li>
                    <li class="list-group-item">
                      កាលបរិច្ឆេទណាត់/<span class="english"
                        >Date: {{ med?.booking?.appointment }}</span
                      >
                    </li>
                  </ul>
                </div>
              </div>
              <div
                class="d-flex flex-column align-items-center justify-content-center my-4"
              >
                <span class="title-invoice">កំណត់ត្រាពិគ្រោះវេជ្ជសាស្ត្រ</span>
                <span class="english eng-title"
                  >MEDICAL CONSULTATION RECORD</span
                >
              </div>
              <div class="medical-user-info my-4">
                <p style="line-height: 40px">
                  ឈ្មោះ/ <strong class="fw-medium">Name</strong>:
                  <span class="user-info">
                    {{ med?.booking.local_name }}
                  </span>
                  ឈ្មោះអង់គ្លេស/ <strong class="fw-medium">English Name</strong>
                  <span class="user-info">
                    {{ med?.booking.name }}
                  </span>
                  ភេទ/ <strong class="fw-medium">Gender</strong>
                  <span class="user-info">
                    {{
                      med?.booking.gender === 1
                        ? "ប្រុស"
                        : med?.booking.gender === 2
                        ? "ស្រី"
                        : med?.booking.gender === 3
                        ? "ផ្សេងទៀត"
                        : "មិនស្គាល់"
                    }}
                  </span>
                  អាយុ/ <strong class="fw-medium">Age</strong>
                  <span class="user-info">
                    {{ med?.booking.dob }}
                  </span>
                  លេខទូរសព្ទ/ <strong class="fw-medium">Phone Number</strong>
                  <span class="user-info">
                    {{ med?.booking.phone_number }}
                  </span>
                  អាសយដ្ឋានអ៊ីមែល/
                  <strong class="fw-medium">Email Address</strong>
                  <span class="user-info">
                    {{ med?.booking.email }}
                  </span>
                </p>
              </div>
              <div>
                <table class="medical-record-tbl">
                  <thead>
                    <th>ពិនិត្យសុខភាព/Examination</th>
                    <th>លិទ្ធផល/Result</th>
                    <th>ធម្មតា/Normal</th>
                    <th>ខុសប្រក្រដី/Abnormal</th>
                  </thead>
                  <tbody>
                    <tr v-for="data in med?.examinations" :key="data.id">
                      <td class="checkup-name">{{ data.name }}</td>
                      <td class="result-medical">{{ data.result }}</td>
                      <td>
                        <input
                          type="checkbox"
                          class="custom-checkbox"
                          :checked="data.status === 'Normal'"
                          disabled
                        />
                      </td>
                      <td>
                        <input
                          type="checkbox"
                          class="custom-checkbox"
                          :checked="data.status === 'Abnormal'"
                          disabled
                        />
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table
                  class="medical-record-tbl mt-4"
                  v-if="med?.prescriptions"
                >
                  <thead>
                    <th>ថ្នាំ/Medication</th>
                    <th>កម្រិតថ្នាំ/Dosage</th>
                    <th>ភាពញឹកញាប់/ធrequency</th>
                    <th>រយៈពេល/Duration</th>
                  </thead>
                  <tbody>
                    <tr v-for="data in med?.prescriptions" :key="data.id">
                      <td class="checkup-name">{{ data.medication }}</td>
                      <td class="result-medical">{{ data.dosage }}</td>
                      <td class="result-medical">{{ data.frequency }}</td>
                      <td class="result-medical">{{ data.duration }}</td>
                    </tr>
                  </tbody>
                </table>
                <table
                  class="medical-record-tbl mt-4"
                  v-if="med?.prescriptions"
                >
                  <thead>
                    <th>ថ្នាំ/Medication</th>
                    <th>កម្រិតថ្នាំ/Dosage</th>
                    <th>ភាពញឹកញាប់/ធrequency</th>
                    <th>រយៈពេល/Duration</th>
                  </thead>
                  <tbody>
                    <tr v-for="data in med?.prescriptions" :key="data.id">
                      <td class="checkup-name">{{ data.medication }}</td>
                      <td class="result-medical">{{ data.dosage }}</td>
                      <td class="result-medical">{{ data.frequency }}</td>
                      <td class="result-medical">{{ data.duration }}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="mt-4" v-if="med?.message">
                  <p>កំណត់ចំណាំរបស់វេជ្ជបណ្ឌិត/Doctor’s Note:</p>
                  <span v-html="med.message" class="fw-medium"> </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import loadingView from "@/components/global/loadingView.vue";
import { useAuthStore } from "@/stores/userAuthStore";
import sidebar from "@/components/global/sidebar.vue";
import navhead from "@/components/global/navhead.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
import router from "@/router";
const authStore = useAuthStore();

const med = ref(null);

async function getmedicalRecordDetail() {
  authStore.loadToken();
  try {
    const selectId = sessionStorage.getItem("selectId");
    if (selectId) {
      const res = await axios.get(`/api/medical-records/${selectId}`, {
        headers: {
          Authorization: "Bearer " + authStore.token,
        },
      });
      med.value = res.data.data;
    } else {
      router.go(-1);
    }
  } catch (error) {
    router.go(-1);
  }
}
const pageLoading = ref(true);
onMounted(async () => {
  try {
    await getmedicalRecordDetail();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
