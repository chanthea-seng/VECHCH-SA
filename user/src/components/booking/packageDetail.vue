<template>
  <!-- Modal -->
  <div
    class="modal fade"
    id="mdl-package"
    tabindex="-1"
    aria-labelledby="mdl-package"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header border-0 bg-transparent">
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="sec-title text-color-800">
            <h3>ពិនិត្យសុខភាពទូទៅ</h3>
            <span
              ><i class="fa-regular fa-timer"></i> ចុះផ្សាយនៅថ្ងៃ៖ 12 មករា
              2025</span
            >
          </div>
          <div class="package-detail-content mt-4">
            <p>
              ការពិនិត្យសុខភាពប្រចាំឆ្នាំគឺជាវិធីល្អបំផុតមួយដើម្បីការពារសុខភាពរបស់អ្នក។
              របៀបរស់នៅដែលមានសុខភាពល្អមានន័យថា
              ការជ្រើសរើសត្រឹមត្រូវក្នុងរបបអាហារ និងការហាត់ប្រាណ
              ព្រមទាំងមានការត្រួតពិនិត្យសុខភាពជាទៀងទាត់
              ដើម្បីធានាថារាងកាយរបស់អ្នកដើរលើផ្លូវត្រូវ និងដើម្បីកំណត់បញ្ហា
              ឬបញ្ហាសុខភាពដែលកំពុងកើតមាន។ ជាមួយនឹងការរកឃើញជំងឺ
              ឬលក្ខខណ្ឌទាន់ពេលវេលា ជំងឺជាច្រើនអាចត្រូវបានព្យាបាល
              មុនពេលដែលវាបង្កបញ្ហាធ្ងន់ធ្ងរដល់សុខភាពរបស់អ្នក។
            </p>
            <div class="package-detail-table">
              <p class="mt-5">
                ហើយខាងក្រោមនេះគឺជាប្រភេទនៃកញ្ចប់សម្រាប់ធ្វើការពិនិត្យសុខភាពទៅតាមប្រភេទនៃជំងឺ៖
              </p>
              <div class="package-detail-table-list">
                <table class="table table-bordered package-detail-table">
                  <thead class="table-info">
                    <tr>
                      <th scope="col">ប្រភេទកញ្ចប់</th>
                      <th scope="col">ផ្តល់ជូនសេវាកម្ម</th>
                      <th scope="col">តម្លៃ</th>
                      <th scope="col">អាចរកបាន</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="list in store.packageList" :key="list.id">
                      <td scope="row" class="package-td">{{ list.title }}</td>
                      <td>
                        <ul class="list-unstyled m-0">
                          <li class="package-ul-li">{{ list.item1 }}</li>
                          <li class="package-ul-li">{{ list.item2 }}</li>
                          <li class="package-ul-li">{{ list.item3 }}</li>
                          <li class="package-ul-li">{{ list.item4 }}</li>
                          <li class="package-ul-li">{{ list.item5 }}</li>
                          <li class="package-ul-li">{{ list.item6 }}</li>
                          <li class="package-ul-li">{{ list.item7 }}</li>
                          <li class="package-ul-li">{{ list.item8 }}</li>
                          <li class="package-ul-li">{{ list.item9 }}</li>
                          <li class="package-ul-li">{{ list.item10 }}</li>
                          <li class="package-ul-li">{{ list.item11 }}</li>
                          <li class="package-ul-li">{{ list.item12 }}</li>
                        </ul>
                      </td>
                      <td>
                        <ul class="list-unstyled m-0">
                          <li class="package-ul-li package-price">$23.50</li>
                          <li class="package-ul-li package-price">
                            &#6107;96,350
                          </li>
                        </ul>
                      </td>
                      <td>
                        <button
                          type="button"
                          class="btn btn-booking"
                          @click="store.BookItem(doc)"
                        >
                          កក់ឥឡូវនេះ
                        </button>
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
</template>
<script setup>
import { Modal } from "bootstrap";
import { onMounted } from "vue";
import { appointment } from "@/stores/bookingstore";

const store = appointment();

onMounted(() => {
  store.mdl_packages = Modal.getOrCreateInstance(
    document.getElementById("mdl-package")
  );
  //store.mdl_packages.show();
});
</script>
