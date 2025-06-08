<template>
  <main class="invoicePage medical-record">
    <loadingView v-if="pageLoading" />

    <Navbar />
    <div class="container">
      <div
        v-if="medStore.recodedetail"
        class="row g-0 p-0 align-items-center justify-content-center"
      >
        <div class="col-10">
          <div class="title">
            <div
              class="position-relative d-flex flex-column align-items-center justify-content-center"
            >
              <h3 class="text-center">កំណត់ត្រាពិគ្រោះវេជ្ជសាស្ត្រ</h3>
              <span class="pay-Date"
                >កាលបរិច្ឆេទចេញលទ្ធផល៖
                {{ medStore.recodedetail?.created_at }}</span
              >
              <primaryBtn
                :click-event="onClickDownload"
                class="position-absolute end-0 top-0"
                label="<i class='fa-light fa-file-pdf'></i>
                ទាញយក"
              />
            </div>
          </div>
          <div class="invoice-detail mt-3 mb-5">
            <div class="d-flex align-items-start justify-content-between">
              <div class="wrapper">
                <img src="../assets/images/auth/new.png" class="logo" alt="" />
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
                      >Record No: {{ medStore.recodedetail.invoice }}</span
                    >
                  </li>
                  <li class="list-group-item">
                    កាលបរិច្ឆេទណាត់/<span class="english"
                      >Date:
                      {{ medStore.recodedetail?.booking?.appointment }}</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div
              class="d-flex flex-column align-items-center justify-content-center my-4"
            >
              <span class="title-invoice">កំណត់ត្រាពិគ្រោះវេជ្ជសាស្ត្រ</span>
              <span class="english eng-title">MEDICAL CONSULTATION RECORD</span>
            </div>
            <div class="medical-user-info my-5">
              <p>
                ឈ្មោះ/ <strong class="fw-medium">Name</strong>:
                <span class="user-info">
                  {{ medStore.recodedetail?.booking.local_name }}
                </span>
                ឈ្មោះអង់គ្លេស/ <strong class="fw-medium">English Name</strong>
                <span class="user-info">
                  {{ medStore.recodedetail?.booking.name }}
                </span>
                ភេទ/ <strong class="fw-medium">Gender</strong>
                <span class="user-info">
                  {{
                    medStore.recodedetail?.booking.gender === 1
                      ? "ប្រុស"
                      : medStore.recodedetail?.booking.gender === 2
                      ? "ស្រី"
                      : medStore.recodedetail?.booking.gender === 3
                      ? "ផ្សេងទៀត"
                      : "មិនស្គាល់"
                  }}
                </span>
                អាយុ/ <strong class="fw-medium">Age</strong>
                <span class="user-info">
                  {{ medStore.recodedetail?.booking.dob }}
                </span>
              </p>
              <p>
                លេខទូរសព្ទ/ <strong class="fw-medium">Phone Number</strong>
                <span class="user-info">
                  {{ medStore.recodedetail?.booking.phone_number }}
                </span>
                អាសយដ្ឋានអ៊ីមែល/
                <strong class="fw-medium">Email Address</strong>
                <span class="user-info">
                  {{ medStore.recodedetail?.booking.email }}
                </span>
              </p>
            </div>
            <div>
              <table class="medical-record-tbl">
                <thead>
                  <th>ពិនិត្យសុខភាព/Examination</th>
                  <th>លិទ្ធផល/Result</th>
                  <th class="text-center">ធម្មតា/Normal</th>
                  <th class="text-center">ខុសប្រក្រដី/Abnormal</th>
                </thead>
                <tbody>
                  <tr
                    v-for="data in medStore.recodedetail?.examinations"
                    :key="data.id"
                  >
                    <td class="checkup-name">{{ data.name }}</td>
                    <td class="result-medical">{{ data.result }}</td>
                    <td class="text-center">
                      <input
                        type="checkbox"
                        class="custom-checkbox"
                        :checked="data.status === 'Normal'"
                      />
                    </td>
                    <td class="text-center">
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
                v-if="medStore.recodedetail?.prescriptions"
              >
                <thead>
                  <th>ថ្នាំ/Medication</th>
                  <th>កម្រិតថ្នាំ/Dosage</th>
                  <th>ភាពញឹកញាប់/ធrequency</th>
                  <th>រយៈពេល/Duration</th>
                </thead>
                <tbody>
                  <tr
                    v-for="data in medStore.recodedetail?.prescriptions"
                    :key="data.id"
                  >
                    <td class="checkup-name">{{ data.medication }}</td>
                    <td class="result-medical">{{ data.dosage }}</td>
                    <td class="result-medical">{{ data.frequency }}</td>
                    <td class="result-medical">{{ data.duration }}</td>
                  </tr>
                </tbody>
              </table>
              <div class="mt-4" v-if="medStore?.recodedetail?.message">
                <p>កំណត់ចំណាំរបស់វេជ្ជបណ្ឌិត/Doctor’s Note:</p>
                <span v-html="medStore.recodedetail?.message" class="fw-medium">
                </span>
              </div>
            </div>
            <!-- <div
              class="cancel-appointment d-flex align-items-center justify-content-between flex-row"
            >
              <span
                >ប្រសិនបើអ្នកត្រូវការលុបចោលការណាត់ជួបពិនិត្យសុខភាពរបស់អ្នក
                សូមជូនដំណឹងមកយើងតាមរយៈចុចប៊ូតុងមួយនេះ</span
              >
              <button class="btn-bg-650">បោះបង់</button>
            </div> -->
          </div>
        </div>
      </div>
    </div>

    <FooterView />
  </main>
</template>

<script setup>
import loadingView from "./loading/loadingView.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { medicalRecordStore } from "@/stores/medicalRecordStore";
import { computed, onMounted, ref } from "vue";
import primaryBtn from "./primaryBtn.vue";
import { useAuthStore } from "@/stores/authTokenStore";
import router from "@/router";
import axios from "axios";
const medStore = medicalRecordStore();
const authStore = useAuthStore();
const pageLoading = ref(true);
onMounted(async () => {
  try {
    window.scrollTo({ top: 0, behavior: "smooth" });

    authStore.loadToken();
    if (!authStore.token) {
      router.push("/");
      return;
    }
    await medStore.getMedicalRecordDetail();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
const onClickDownload = async () => {
  try {
    const id = medStore.recodedetail?.id;
    if (!id) {
      return;
    }
    const res = await axios.get(`/api/medical-record/${id}/downloads`, {
      headers: {
        Authorization: `Bearer ${authStore.token}`,
      },
    });

    const downloadUrl = res.data.download_url;
    if (!downloadUrl) {
      return;
    }
    const link = document.createElement("a");
    link.href = downloadUrl;
    link.target = `_blank`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  } catch (error) {
    let errorMessage = "Failed to download medical record.";
    if (error.response) {
      errorMessage = error.response.data.message || errorMessage;
    } else if (error.request) {
    }
  }
};
</script>
