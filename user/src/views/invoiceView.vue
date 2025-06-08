<template>
  <main class="invoicePage">
    <Navbar />
    <loadingView v-if="appoint.loading" />
    <div class="container">
      <div
        class="row g-0 p-0 align-items-center justify-content-center"
        v-if="appointment"
      >
        <div class="col-10">
          <div class="title">
            <div
              class="position-relative d-flex flex-column align-items-center justify-content-center"
            >
              <h3 class="text-center">ព័ត៌មានលម្អិតវិក័យប័ត្រ</h3>
              <primaryBtn
                :click-event="onClickDownload"
                class="position-absolute end-0 top-0"
                label="<i class='fa-light fa-file-pdf'></i>
                ទាញយក"
              />
            </div>
            <span class="pay-Date"
              >កាលបរិច្ឆេទបង់ប្រាក់៖ {{ appointment?.submit }}</span
            >
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
                      >Record No: {{ appointment.invoice }}</span
                    >
                  </li>
                  <li class="list-group-item">
                    កាលបរិច្ឆេទណាត់/<span class="english"
                      >Date:{{ appointment.appointment }}</span
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div
              class="d-flex flex-column align-items-center justify-content-center mt-4"
            >
              <span class="title-invoice">បង្កាន់ដៃបង់ប្រាក់</span>
              <span class="english eng-title">PAYMENT RECEIPT</span>
              <span class="bring-invoice"
                >សូមយកបង្កាន់ដៃតាមខ្លួននៅពេលអ្នកធ្វើដំណើរមកទីនេះ</span
              >
              <span class="english bring-invoice"
                >Please bring your receipt with you when you travel here.</span
              >
            </div>
            <div class="user-detail d-flex justify-content-between mt-4">
              <ul class="list-group">
                <li class="list-group-item">
                  <span class="label"
                    >ឈ្មោះសមីខ្លួន<span class="english">/Name</span></span
                  >
                  <span class="value">:{{ appointment.local_name }}</span>
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >ឈ្មោះអក្សរឡាតាំង<span class="english"
                      >/English Name</span
                    ></span
                  >
                  <span class="value">:{{ appointment.name }}</span>
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >ភេទ<span class="english">/Gender</span></span
                  >
                  <!-- <span v-if=""></span> -->
                  <span class="value"
                    >:
                    {{
                      appointment.gender == 1
                        ? "ប្រុស"
                        : appointment.gender == 2
                        ? "ស្រី"
                        : appointment.gender == 3
                        ? "ផ្សេងទៀត"
                        : "មិបស្គាល់"
                    }}
                  </span>
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >ខែឆ្នាំកំណើត<span class="english"
                      >/Date of birth</span
                    ></span
                  >
                  <span class="value">:{{ appointment.birth }}</span>
                </li>
              </ul>
              <ul class="list-group">
                <li class="list-group-item">
                  <span class="label"
                    >លេខទូរស័ព្ទ<span class="english">/Phone Number</span></span
                  >
                  <span class="value"
                    >: +885 {{ appointment.phone_number }}</span
                  >
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >អាសយដ្ធានអុីមែល<span class="english"
                      >/Email Address</span
                    ></span
                  >
                  <span class="value">:{{ appointment.email }}</span>
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >វិធីសាស្ត្របង់ប្រាក់<span class="english"
                      >/Payment Method</span
                    ></span
                  >
                  <span class="value">:QR Code</span>
                </li>
                <li class="list-group-item">
                  <span class="label"
                    >ប្រភេទសេវាកម្ម<span class="english"
                      >/Type of Service</span
                    ></span
                  >
                  <span v-if="appointment.service_type == 0" class="value"
                    >: ពិគ្រោះប្រឹក្សា
                  </span>
                  <span v-else-if="appointment.service_type == 1" class="value"
                    >: ពិនិត្យសុខភាព
                  </span>
                  <span v-else>: វ៉ាក់សាំង </span>
                </li>
              </ul>
              <!-- <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="label">ឈ្មោះសមីខ្លួន<span class="english">/Name</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">ឈ្មោះអក្សរឡាតាំង<span class="english">/English Name</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">ភេទ<span class="english">/Gender</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">ខែឆ្នាំកំណើត<span class="english">/Date of birth</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="label">លេខទូរស័ព្ទ<span class="english">/Phone Number</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">អាសយដ្ធានអុីមែល<span class="english">/Email Address</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">វិធីសាស្ត្របង់ប្រាក់<span class="english">/Payment Method</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="label">ប្រភេទសេវាកម្ម<span class="english">/Type of Service</span></span>
                                    <span class="value">:ប៉ិម បញ្ញារិទ្ធ</span>
                                </li>
                            </ul> -->
            </div>
            <div
              class="detail-service d-flex flex-row justify-content-between my-4"
            >
              <table
                class="table service table-striped table-borderless align-middle"
              >
                <thead class="table-dark">
                  <tr>
                    <th>
                      ប្រភេទសេវាកម្ម<span class="english"
                        >/Type of Service</span
                      >
                    </th>
                  </tr>
                </thead>
                <tbody v-if="appointment.service_type != 0">
                  <tr
                    v-for="(
                      title, index
                    ) in appointment.sub_service?.description.split(',')"
                    :key="index"
                  >
                    {{
                      title
                    }}
                  </tr>
                  <!--                                     
                                    <tr>
                                        <td>1</td>
                                        <td>{{ appointment.sub_service ? appointment.sub_service.name : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ appointment.sub_service ? appointment.sub_service.name : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>{{ appointment.sub_service? appointment.sub_service.name : 'N/A' }}</td>
                                    </tr>
 -->
                </tbody>
              </table>
              <div class="payment-wrapper p-0">
                <table class="table payment table-borderless">
                  <thead class="table-dark">
                    <tr>
                      <th colspan="2" class="text-center">
                        ប្រភេទសេវាកម្ម<span class="english"
                          >/Type of Service</span
                        >
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="1">
                        តម្លៃសរុបទាំងអស់<span class="english">/Sub Total</span>
                      </td>
                      <td class="english">
                        ${{
                          appointment.sub_service
                            ? appointment.sub_service.price
                            : "0"
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        បញ្ចុះតម្លៃ<span class="english">/Promotion</span>
                      </td>
                      <td class="english">$0</td>
                    </tr>
                    <tr>
                      <td>តម្លៃសរុប<span class="english">/Total</span></td>
                      <td class="english">
                        ${{
                          appointment.sub_service
                            ? appointment.sub_service.price
                            : "0"
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        កក់ប្រាក់ចំនួន<span class="english">/Deposit</span>
                      </td>
                      <td class="english">
                        ${{
                          appointment.sub_service
                            ? appointment.sub_service.price
                            : "0"
                        }}
                      </td>
                    </tr>
                    <tr>
                      <td>នៅសល់សមតុល្យ<span class="english">/Balance</span></td>
                      <td class="fw-bold english">$0.0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="patient-note mb-1">
              <div v-if="instruction" class="instruction-container p-0">
                <span class="title"
                  >ការណែនាំមុនពេលពិនិត្យសុខភាព
                  អ្នកជំងឺគួរតែធ្វើតាមការណែនាំទាំងនេះ៖</span
                >
                <div v-html="instruction"></div>
              </div>
              <div v-else>
                <p class="fw-medium text-color-950">មិនមានការណែនាំទេ។.</p>
              </div>
              <!-- <ul class="list-group mt-2">
                <li class="list-group-item">
                  <i class="fa-regular fa-check"></i>
                  ប្រសិនបើតមអាហារត្រូវបានទាមទារ ជៀសវាងការញ៉ាំ ឬផឹកអ្វីទាំងអស់
                  លើកលែងតែទឹករយៈពេល 8-12 ម៉ោងមុនពេលធ្វើតេស្ត។
                  នេះជាធម្មតាត្រូវការសម្រាប់ជាតិស្ករក្នុងឈាម កូលេស្តេរ៉ុល
                  និងការធ្វើតេស្តមេតាបូលីសមួយចំនួន។
                </li>
                <li class="list-group-item">
                  <i class="fa-regular fa-check"></i> ជៀសវាងជាតិកាហ្វេអ៊ីន
                  និងជាតិអាល់កុល – ចៀសវាងការទទួលទានកាហ្វេ តែ អាល់កុល
                  ឬភេសជ្ជៈប៉ូវកម្លាំង យ៉ាងហោចណាស់ 12-24 ម៉ោងមុនពេលពិនិត្យ
                  ព្រោះវាអាចប៉ះពាល់ដល់លទ្ធផលតេស្ត។
                </li>
                <li class="list-group-item">
                  <i class="fa-regular fa-check"></i> ផឹកទឹកឱ្យបានគ្រប់គ្រាន់
                  លុះត្រាតែមានការណែនាំផ្សេង
                  ព្រោះការខះជាតិទឹកអាចប៉ះពាល់ដល់ការធ្វើតេស្តឈាម និងសំណាកទឹកនោម។
                </li>
                <li class="list-group-item">
                  <i class="fa-regular fa-check"></i>
                  ធ្វើតាមការណែនាំរបស់វេជ្ជបណ្ឌិតរបស់អ្នកអំពីថាតើត្រូវលេបថ្នាំមុនពេលធ្វើតេស្ត
                  ជាពិសេសសម្រាប់ជំងឺទឹកនោមផ្អែម ឬសម្ពាធឈាម។
                </li>
                <li class="list-group-item">
                  <i class="fa-regular fa-check"></i>
                  ប្រសិនបើវេជ្ជបណ្ឌិតបានផ្តល់ការណែនាំអំពីរបបអាហារជាក់លាក់មុនពេលពិនិត្យ
                  សូមអនុវត្តតាមពួកគេដោយប្រុងប្រយ័ត្ន។
                </li>
              </ul> -->
            </div>
            <div
              v-if="
                appointment.is_complete == 0 && appointment.booking_status != 3
              "
              class="cancel-appointment d-flex align-items-center justify-content-between flex-row"
            >
              <span
                >ប្រសិនបើអ្នកត្រូវការលុបចោលការណាត់ជួបពិនិត្យសុខភាពរបស់អ្នក
                សូមជូនដំណឹងមកយើងតាមរយៈចុចប៊ូតុងមួយនេះ</span
              >
              <button
                @click="onCancelBooking(appointment.id)"
                class="btn-bg-650"
              >
                បោះបង់
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalCancelbooking />
    <FooterView />
  </main>
</template>

<script setup>
import loadingView from "./loading/loadingView.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { appointmentStore } from "@/stores/appointmentstore";
import { computed, onMounted, ref } from "vue";
import axios from "axios";
import { useAuthStore } from "@/stores/authTokenStore";
import { Modal } from "bootstrap";
import ModalCancelbooking from "@/components/layouts/ModalCancelbooking.vue";
import primaryBtn from "./primaryBtn.vue";
import router from "@/router";
const appoint = appointmentStore();
const authStore = useAuthStore();

const appointment = computed(() => appoint.appointmentdetail);
const instruction = ref(null);
onMounted(async () => {
  window.scrollTo({ top: 0, behavior: "smooth" });

  authStore.loadToken();
  if (!authStore.token) {
    router.push("/");
  }
  await appoint.getDetailbookingDetail();
  instruction.value =
    appointment.value?.sub_service?.service?.instruction || null;
});

const onClickDownload = async () => {
  try {
    const id = appointment.value.id;
    if (!id) {
      return;
    }
    const res = await axios.get(`/api/invoice/${id}/downloads`, {
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

const onCancelBooking = async (id) => {
  appoint.selected_id = id;
  appoint.mdl_cancelappoint.show();
};
</script>
