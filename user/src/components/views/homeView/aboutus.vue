<template>
  <div class="aboutus">
    <loadingView v-if="pageLoading" />

    <section class="hero">
      <div class="container">
        <div class="row align-items-center rounded-4 g-0 overflow-hidden">
          <div class="col-7 align-items-center">
            <div class="content ps-5" style="margin-top: -40px !important">
              <h4 class="mb-3" style="width: 80%">
                យើងផ្តល់ឱ្យអ្នកនូវសេវាកម្មថែទាំជាមួយឧបករណ៍វេជ្ជសាស្ត្រចុងក្រោយបង្អស់និងជាមួយនឹងក្រុមគ្រូពេទ្យយ៉ាងមានជំនាញ
              </h4>
              <p class="mb-4">
                បើសិនជាអ្នកត្រូវការទំនាក់ទំនងមកយើងខ្ញុំ
                សូមមេត្តាផ្តល់ព័ត៌មានតាមដូចគំរូខាងក្រោម ក្រុមការងារផ្នែកសេវាកម្ម
                អតិថិជនរបស់យើងខ្ញុំ នឹងទាក់ទងលោកអ្នក
              </p>
              <RouterLink to="/contact" role="button" class="btn-bg-650"
                >ទំនាក់ទំនង
              </RouterLink>
            </div>
          </div>
          <div class="col-5">
            <div class="img-hero position-relative mx-auto w-100 d-flex">
              <img
                src="/src/assets/images/auth/homePage/hero_banner_about.png"
                width="210px"
                alt=""
              />
              <div
                class="bg-white d-flex align-items-center tag rounded-3 z-3 position-absolute"
              >
                <i class="fa-solid fa-bolt me-2 fs-5 text-warning"></i>
                <p class="mb-0 fw-medium">សេវារហ័ស និងមានប្រសិទ្ធភាព</p>
              </div>
              <div
                class="bg-white d-flex tag t2 rounded-3 align-items-center z-3 position-absolute"
              >
                <i class="fa-solid fa-clock me-2 fs-5 text-warning"></i>
                <p class="mb-0 fw-medium">ធ្វើការ 24/7</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="choose">
      <div class="container">
        <div class="row g-5">
          <div class="col-4 position-relative">
            <div class="w-100 h-100">
              <img
                src="/src/assets/images/auth/homePage/third.jpg"
                class="w-100 object-fit-cover h-100 border-radius"
                alt=""
              />
            </div>
          </div>
          <div class="col-8">
            <div>
              <h4 class="mb-3">
                ហេតុអ្វីជ្រើសរើសប្រើប្រាស់សេវាកម្មមន្ទីពេទ្យរបស់យើង?
              </h4>
              <p class="mb-3">
                ជាមួយនឹងការប្តេជ្ញាចិត្តចំពោះឧត្តមភាពការថែទាំដោយផ្តោតលើអ្នកជំងឺនិងការជឿនលឿនផ្នែកវេជ្ជសាស្រ្ដដ៏ទំនើបយើងទទួលបានការជឿទុកចិត្តពីមនុស្សជាច្រើនដែលកំពុងស្វែងរកសេវាកម្មថែទាំសុខភាពដ៏ល្អបំផុត។នេះជាមូលហេតុដែលអ្នកគួរជ្រើសរើសប្រើ
                ប្រាស់សាវាកម្មមន្ទីពេទ្យរបស់យើង៖
              </p>
              <div class="mb-3 d-flex">
                <div class="col-1 me-3 icon text-center">
                  <i class="fa-duotone fa-regular fa-check text-color-600"></i>
                </div>
                <p class="mb-0">
                  ក្រុមវេជ្ជបណ្ឌិតគិលានុបដ្ឋាយិកានិងអ្នកឯកទេសដែលមានជំនាញខ្ពស់របស់យើងបានប្តេជ្ញាចិត្តក្នុងការផ្តល់នូវដំណោះស្រាយថែទាំសុខភាពដ៏ល្អបំផុត។
                </p>
              </div>
            </div>
            <div class="d-flex flex-row">
              <div class="w-75 pe-4">
                <div class="mb-3 d-flex">
                  <div class="col-1 me-3 icon text-center">
                    <i
                      class="fa-duotone fa-regular fa-check text-color-600"
                    ></i>
                  </div>
                  <p class="mb-0">
                    យើងមានបំពាក់ដោយបច្ចេកវិជ្ជាវេជ្ជសាស្រ្ដដ៏ទំនើប
                    ដើម្បីធានាបាននូវការធ្វើរោគវិនិច្ឆ័យត្រឹមត្រូវ
                    និងការព្យាបាលប្រកបដោយប្រសិទ្ធភាព។
                  </p>
                </div>
                <div class="mb-3 d-flex">
                  <div class="col-1 me-3 icon text-center">
                    <i
                      class="fa-duotone fa-regular fa-check text-color-600"
                    ></i>
                  </div>
                  <p class="mb-0">
                    ជាមួយនឹងសេវាសង្គ្រោះបន្ទាន់24/7និងគ្រឿងបរិក្ខារICUកម្រិតខ្ពស់យើងតែងតែត្រៀមខ្លួនជាស្រេចក្នុងការផ្តល់ការថែទាំសង្គ្រោះជីវិត
                  </p>
                </div>
                <div class="mb-3 d-flex">
                  <div class="col-1 me-3 icon text-center">
                    <i
                      class="fa-duotone fa-regular fa-check text-color-600"
                    ></i>
                  </div>
                  <p class="mb-0">
                    យើងបន្តខិតខំប្រឹងប្រែងសម្រាប់ការច្នៃប្រឌិត ការស្រាវជ្រាវ
                    និងស្តង់ដារខ្ពស់បំផុតក្នុងការថែទាំសុខភាព
                  </p>
                </div>
              </div>
              <div class="w-50">
                <img
                  src="/src/assets/images/aboutUs/abtUs.jpg"
                  class="abt-img border-radius"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="thanks d-flex align-items-center">
      <div class="container">
        <div class="partern position-relative z-3">
          <div class="px-5 py-5 border-radius bg-white box-shadow">
            <h4 class="text-center fkhmermoul">សេចក្ដីថ្លែងអំណរគុណ</h4>
            <div
              class="px-5 d-flex gap-4 my-4 align-items-center justify-content-center"
            >
              <div style="width: 180px">
                <img
                  src="/src/assets/images/auth/cbrd-logo (2).png"
                  class="w-100"
                  alt=""
                />
              </div>
              <div style="width: 450px">
                <img
                  src="/src/assets/images/auth/Logo_MPTC.png"
                  class="w-100"
                  alt=""
                />
              </div>
              <div style="width: 160px">
                <img
                  src="/src/assets/images/auth/ant-logo (2).jpg"
                  class="w-100"
                  alt=""
                />
              </div>
            </div>
            <p class="text-center px-3">
              ជាដំបូងក្រុមយើងខ្ញុំ សូមអរគុណទៅកាន់ ក្រសួងប្រៃសណីយ៍និងទូរគមនាគមន៍
              ដែលបានផ្ដល់ឱកាសអាហារូបរណ៌បណ្តុះបណ្តាលសិស្សនិស្សិតលើមុខជំនាញ <br />
              <span
                >1. Mobile App (Flutter), 2. Laravel Web Development, 3. Node JS
                Web Development</span
              ><br />
              ។អាហារូបករណ៌នេះផងដែរបានជួយជំរុញការសិក្សារបស់និស្សិតអាហារូករណ៌ទាំងអស់ឱ្យមានឱកាសសិក្សានិងពង្រឹងនូវជំនាញដែលខ្លួនស្រឡាញ់ក្រោមការឧបត្ថម្ភរបស់ក្រសួងប្រៃសណីយ៍និងទូរគមនាគមន៍។
              ជាមួយគ្នាផងដែរ
              ក្រុមយើងខ្ញុំក៏សូមថ្លែងអំណរអរគុណយ៉ាងជ្រាលជ្រៅទៅកាន់់​
              បណ្តុះបណ្តាលបច្ចេកវិទ្យាអាន-ANT និង លោកគ្រូអ្នកគ្រូទាំងអស់
              ដែលបានយកចិត្តទុកដាក់បង្ហាត់បង្រៀនណែនាំ
              និងផ្តល់ជាមតិល្អៗនិងមានសារៈសំខាន់ដែលធ្វើឱ្យក្រុមយើងខ្ញុំអាចសម្រេចសមិទ្ធផលវេបសាយមួយនេះបាន។
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="team">
      <div class="container">
        <h4 class="text-center">សមាជិកក្រុមទាំងអស់របស់យើង</h4>
        <br /><br />
        <div class="row gy-5 mt-5 pt-5 mx-auto" style="width: 80%">
          <div class="col-4">
            <div
              class="member position-relative d-flex flex-column justify-content-center align-items-center"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/vuthy.png"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">ឃីម វុទ្ធី-Khim Vuthy</h4>
              <p class="mb-1">Frontend Developer</p>
              <div class="socail">
                <a
                  href="https://t.me/kvuthy"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/V-Dever"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div
              class="member position-relative d-flex flex-column justify-content-center align-items-center"
              style="margin-top: -160px"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/manet.jpg"
                  class="img-fluid border-cicle"
                  alt=""
                />
              </div>
              <!-- <div class="border-pf"></div> -->

              <h4 class="mt-3 mb-1 fs-6">
                រ័ត្ន អង្គារម៉ាណែត-Roth Angkeamanet
              </h4>
              <p class="mb-1">Frontend Developer</p>
              <div class="socail">
                <a
                  href="https://t.me/rothangkeamanet"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/roth-angkeamanet-759a19328/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/rothangkeamanet"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div
              class="member d-flex flex-column justify-content-center align-items-center"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/mara.jpg"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">យូរ ម៉ារ៉ា-You Mara</h4>
              <p class="mb-1">Frontend Developer</p>
              <div class="socail">
                <a
                  href="https://t.me/You_mara"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/you-mara-3aa265361/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/mama-19"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div
              class="member d-flex flex-column justify-content-center align-items-center"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/thea.jpg"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">សេង ចន្ទ័ធា-Seng Chanthea</h4>
              <p class="mb-1">Backend Developer</p>
              <div class="socail">
                <a
                  href="https://t.me/sothea_369"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/chanthea-seng-b00467280/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/wh04m1-dev"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div
              class="member d-flex flex-column justify-content-center align-items-center"
              style="margin-top: -160px"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/narith.jpg"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">ប៉ិម បញ្ញារិទ្ធ-Pim Panharith</h4>
              <p class="mb-1">Project Planing</p>
              <div class="socail">
                <a
                  href="https://t.me/PanharithPim"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/pimpanharith/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/GGHosttttt"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div
              class="member d-flex flex-column justify-content-center align-items-center"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/oda.jpg"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">នង អូរដា-Nong Oda</h4>
              <p class="mb-1">UI Designer</p>
              <div class="socail">
                <a
                  href="https://t.me/odanong"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/nong-oda-2b00a3327/"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/NongOda"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-4 mx-auto">
            <div
              class="member d-flex flex-column justify-content-center align-items-center"
              style="margin-top: -160px"
            >
              <div class="pf-img box-shadow">
                <img
                  src="/src/assets/images/Teammember/seyha.jpg"
                  class="img-fluid"
                  alt=""
                />
              </div>
              <h4 class="mt-3 mb-1 fs-6">ផាត សីហា-Phat Seyha</h4>
              <p class="mb-1">Backend Developer</p>
              <div class="socail">
                <a
                  href="https://t.me/phatseyha"
                  target="_blank"
                  class="text-decoration-none fs-4"
                >
                  <i class="fa-brands fa-telegram"></i>
                </a>
                <a
                  target="_blank"
                  href="https://www.linkedin.com/in/phat-seyha-790212361?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app"
                  class="text-decoration-none mx-4"
                  ><i class="fa-brands fa-linkedin fs-4"></i
                ></a>
                <a
                  href="https://github.com/PHATSEYHA"
                  target="_blank"
                  class="text-decoration-none text-dark"
                >
                  <i class="fa-brands fa-github fs-4"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { onMounted, ref } from "vue";
import loadingView from "@/views/loading/loadingView.vue";
const pageLoading = ref(true);
onMounted(() => {
  setTimeout(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
    pageLoading.value = false;
  }, 1500);
});
</script>
