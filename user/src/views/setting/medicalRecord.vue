<template>
  <main class="setting medical-record">
    <Navbar />
    <div class="container py-4 mt-5">
      <div class="row">
        <div class="col-3">
          <sidebarProfileSetting />
        </div>
        <div class="col-9">
          <h5 class="setting-title text-color-950">ក្រដាសវេជ្ជបញ្ជា</h5>
          <span class="mb-3"
            >រាល់ទីន្នន័យផ្សេងៗដែលទាក់ទងនិងសុខភាពរបស់អ្នកក្រោយការពិនិត្យនឹងត្រូវបានរក្សាទុកនៅទីនេះ</span
          >
          <div class="wrapper p-3 pt-2 bg-white mt-3">
            <table
              class="table align-middle table-striped table-borderless m-0"
            >
              <thead class="fw-medium">
                <tr class="table-light">
                  <th>អត្តលេខ</th>
                  <th>ឈ្មោះអ្នកជំងឺ</th>
                  <th>ឈ្មោះឡាតាំង</th>
                  <th>ឈ្មោះគ្រូពេទ្យ</th>
                  <th>កាលបរិច្ឆេទ</th>
                  <th>សកម្មភាព</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-if="
                    medStore.medaicalrecods &&
                    medStore.medaicalrecods.length === 0
                  "
                >
                  <td colspan="6" class="text-center">
                    <p class="m-0 fw-medium text-color-900 pt-3 fs-5">
                      មិនមានកំណត់ត្រាវេជ្ជសាស្ត្រ
                      <i class="fa-light fa-notes-medical"></i>
                    </p>
                  </td>
                </tr>
                <tr
                  v-for="(record, index) in medStore.medaicalrecods"
                  :key="record.id"
                >
                  <td>{{ index + 1 }}</td>
                  <td>{{ record.booking.local_name }}</td>
                  <td>{{ record.booking.name }}</td>
                  <td>{{ record.doctor.fullname }}</td>
                  <td>{{ record.created_at }}</td>
                  <td>
                    <div class="btn-action">
                      <a
                        @click="medStore.getMedicalrecordDetailId(record.id)"
                        role="button"
                      >
                        <i class="fa-light fa-eye"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <FooterView />
  </main>
</template>

<script setup>
import Navbar from "@/components/layouts/Navbar.vue";
import sidebarProfileSetting from "@/components/layouts/sidebarProfileSetting.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { medicalRecordStore } from "@/stores/medicalRecordStore";
import { onMounted } from "vue";
const medStore = medicalRecordStore();

onMounted(async () => {
  await medStore.getmedicalRecord();
});
</script>
