<template>
  <loadingView v-if="articlestore.loading" />
  <section class="w-100 py-0 my-0 mt-3 homepage hero position-relative">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <div class="col-7">
          <div class="pe-5 z-3 position-relative">
            <h3 class="text-white">
              សេវាកម្មរបស់យើង ផ្តល់នូវវិសាលភាពទូលំទូលាយ
              នៃការវិភាគរោគវិនិច្ឆ័យទៅតាមផ្នែក
            </h3>
            <p class="fw-medium text-white">
              "ក្តីសង្ឃឹម ការព្យាបាល និងការប្ដេជ្ញាចិត្តចំពោះសុខុមាលភាពរបស់អ្នក។
              សូមស្វាគមន៍មកកាន់ Vechch Sal ដែលការថែទាំប្រកបដោយក្តីមេត្តា
              បំពេញតាមឧត្តមភាពផ្នែកវេជ្ជសាស្ត្រ"
            </p>
            <primaryBtn label="ទទួលសេវាកម្ម" :click-event="onClickBooking" />
          </div>
        </div>
        <div class="col-4">
          <div class="doctor">
            <img
              src="/src/assets/images/auth/homePage/doctor-preparing-routine-medical-check.png"
              height="400px"
              alt=""
            />
          </div>
        </div>
      </div>
    </div>

    <div class="ocean">
      <div class="wave"></div>
      <div class="wave"></div>
      <div class="wave"></div>
    </div>
  </section>

  <section class="service home mt-0 pt-5 position-relative">
    <div class="container">
      <div class="row">
        <div class="col-10 mx-auto">
          <div class="text-center">
            <span class="section-title-tag">សេវាកម្ម</span>
            <h4 class="sc-title my-3">សេវាកម្មសុខភាពសម្រាប់អ្នក</h4>
            <p>
              ក្រុមដែលខិតខំប្រឹងប្រែងរបស់យើងធានានូវសុខុមាលភាពរបស់អ្នកជាមួយនឹងគ្រឿងបរិក្ខារទំនើប
              ការណែនាំប្រកបដោយវិជ្ជាជីវៈ និងវិធីសាស្រ្តដំបូងដោយអ្នកជំងឺ។
              ទទួលបានបទពិសោធន៍ពីការថែទាំសុខភាពប្រកបដោយគុណភាពដែលត្រូវបានរចនាឡើងដើម្បីផ្តល់ថាមពលដល់ការធ្វើដំណើររបស់អ្នកទៅកាន់សុខភាពកាន់តែប្រសើរ។
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="our-service">
      <div class="container">
        <div class="row">
          <div class="col-4">
            <RouterLink to="/finddoctor" class="card card-service">
              <div class="card-body border-0">
                <div class="d-flex align-items-center">
                  <div class="icon">
                    <img
                      src="/src/assets/images/auth/icon/find_doctor.png"
                      class="overflow-hidden"
                      alt=""
                    />
                  </div>
                  <h5 class="ms-3 mb-0">ស្វែងរកវេជ្ជបណ្ដិត</h5>
                </div>
                <div
                  class="icon-continu box-shadow d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-arrow-down-left text-white fs-5"></i>
                </div>
                <p class="mt-3 mb-0 text-color-gray">
                  លោកអ្នកអាចស្វែងរកវេជ្ជបណ្ឌិតដែលប្រកបដោយវិជ្ជាជីវ: និង
                  ​ឯកទេសព្យាបាលទៅតាមជំនាញនីមួយៗបានយ៉ាងងាយស្រួល
                </p>
              </div>
            </RouterLink>
          </div>
          <div class="col-4">
            <RouterLink to="/package" class="card card-service">
              <div class="card-body border-0">
                <div class="d-flex align-items-center">
                  <div class="icon">
                    <img
                      src="/src/assets/images/auth/icon/check-up.png"
                      class="overflow-hidden"
                      alt=""
                    />
                  </div>
                  <h5 class="ms-3 mb-0">កញ្ចប់ និងតម្លៃពិនិត្យសុខភាព</h5>
                </div>
                <div
                  class="icon-continu box-shadow d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-arrow-down-left text-white fs-5"></i>
                </div>
                <p class="mt-3 mb-0 text-color-gray">
                  លោកអ្នកនឹងទទួលបានការពិនិត្យសុខភាពជាកញ្ចប់
                  ដែលអាចធានាបាននូវទាំងគុណភាពនិងតម្លៃព្រមទាំងសុវត្ថិភាពឯកជនភាព
                </p>
              </div>
            </RouterLink>
          </div>
          <div class="col-4">
            <a @click="onClickBooking()" class="card card-service">
              <div class="card-body border-0">
                <div class="d-flex align-items-center">
                  <div class="icon">
                    <img
                      src="/src/assets/images/auth/icon/vaccination.png"
                      class="overflow-hidden"
                      alt=""
                    />
                  </div>
                  <h5 class="ms-3 mb-0">ជំនួបពិគ្រោះជំងឺ</h5>
                </div>
                <div
                  class="icon-continu box-shadow d-flex justify-content-center align-items-center"
                >
                  <i class="bi bi-arrow-down-left text-white fs-5"></i>
                </div>
                <p class="mt-3 mb-0 text-color-gray">
                  លោកអ្នកនឹងទទួលបានការណែនាំនិងការថែទាំសុខភាពផ្ទាល់ខ្លួនពីអ្នកជំនាញថែទាំសុខភាពដែលមានបទពិសោធន៍ច្រើនឆ្នាំ
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="medical-special">
    <div class="container">
      <div class="row">
        <div class="col-6">
          <div>
            <span class="section-title-tag">ឯកទេសព្យាបាល</span>
            <h4 class="sc-title my-3">ជំនាញឯកទេសព្យាបាលជំងឺរបស់មជ្ឈមណ្ឌលយើង</h4>
            <p class="mb-0 text-color-text">
              មន្ទីរពេទ្យរបស់យើងផ្តល់សេវាសុខភាពពិសេសនៅទូទាំងនាយកដ្ឋានផ្សេងៗរួមទាំងការធ្វើរោគវិនិច្ឆ័យកម្រិតខ្ពស់ការព្យាបាលឯកទេសនិងការថែទាំផ្ទាល់ខ្លួនហើយយើងធានាបាននូវការព្យាបាលគឺនឹងទទួលបានយ៉ាងប្រសិតភាពរួមជាមួយនឹងសម្ភារៈបរិក្ខារទំនើប
              និងក្រុមគ្រូពេទ្យជំនាញ។
            </p>
          </div>
        </div>
        <div class="col-6 speclial-list">
          <ul class="nav justify-content-around">
            <li class="nav-item justify-content-between">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/brain.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">ប្រព័ន្ធប្រសាទ</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/ribbon.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">មហារីក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/heart.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">បេះដូង</p>
              </RouterLink>
            </li>

            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/x-ray.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">ឆ្អឹងសន្លាក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/operating-room.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">វះកាត់ទូទៅ</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/love.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">សម្រាលទារក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/eye-test.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">កែវភ្នែក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/bacteria.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">មហារីក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/Ear.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">ត្រចៀក</p>
              </RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="" class="nav-link col">
                <img
                  src="/src/assets/images/auth/icon/ThreeDots.png"
                  class="medical-icon"
                  alt=""
                />
                <p class="mb-0 text-color-950 fw-medium mt-2">ផ្សេងៗទៀត</p>
              </RouterLink>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <section class="whychoose">
    <div class="container">
      <div class="row g-0 rounded-4">
        <div class="col-5">
          <div class="position-relative z-3">
            <span class="section-title-tag">ហេតតុអ្វីជ្រើសរើសយើង</span>
            <h4 class="sc-title my-3">
              សុខភាពរបស់លោកអ្នក គឺជាកាតព្វកិច្ច ចម្បងរបស់យើង
            </h4>
            <p class="text-color-text mb-4">
              យើងព្យាបាលអ្នកជំងឺគ្រប់រូបដោយសេចក្តីថ្លៃថ្នូរ ការគោរព
              និងការថែទាំផ្ទាល់ខ្លួន
              ដោយធានាថាអ្នកគ្រប់គ្នាទទួលបានការយកចិត្តទុកដាក់ដែលសាកសមនឹងទទួលបាន
            </p>
            <!-- <RouterLink to="" class="btn-bg-650">អានបន្ថែម</RouterLink> -->
            <primaryBtn :click-event="onClickAboutUs" label="អានបន្ថែម" />
			
          </div>
        </div>
        <div class="col-7 position-relative z-3 overflow-hidden">
          <div class="doctor">
            <img
              src="/src/assets/images/auth/homePage/doctor.png"
              class="img-fluid"
              alt=""
            />
          </div>
          <div class="list-reson box-shadow bg-white">
            <ul class="nav d-flex flex-column p-3">
              <li
                class="nav-item text-color-text d-flex align-items-center fw-medium"
              >
                <i class="bi bi-check-lg me-2 text-color-700 fs-3"></i>
                សេវាសង្គ្រោះបន្ទាន់ 24/7
              </li>
              <li
                class="nav-item text-color-text d-flex align-items-center fw-medium"
              >
                <i class="bi bi-check-lg me-2 text-color-700 fs-3"></i>
                វេជ្ជបណ្ឌិតដែលមានបទពិសោធន៍ខ្ពស់
              </li>
              <li
                class="nav-item text-color-text d-flex align-items-center fw-medium"
              >
                <i class="bi bi-check-lg me-2 text-color-700 fs-3"></i>
                គ្រឿងបរិក្ខារទំនើបៗ
              </li>
              <li
                class="nav-item text-color-text d-flex align-items-center fw-medium"
              >
                <i class="bi bi-check-lg me-2 text-color-700 fs-3"></i>
                ប្រើប្រាស់បច្ចេកវិទ្យាវេជ្ជសាស្រ្តចុងក្រោយបំផុត
              </li>
              <li
                class="nav-item text-color-text d-flex align-items-center fw-medium"
              >
                <i class="bi bi-check-lg me-2 text-color-700 fs-3"></i>
                បរិស្ថានផាសុកភាព និងអនាម័យ
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="package">
    <div class="container">
      <div class="text-center">
        <span class="section-title-tag">កញ្ចប់ និងតម្លៃពិនិត្យសុខភាព</span>
        <h4 class="sc-title my-3 text-center mx-auto" style="width: 420px">
          កញ្ចប់សុខភាពសម្រាប់គ្រប់តម្រូវការរបស់អ្នក រួមទាំងការផ្តល់ជូនពិសេស
        </h4>
        <p class="text-color-text">
          រីករាយជាមួយការបញ្ចុះតម្លៃផ្តាច់មុខ និងការផ្តល់ជូនពិសេស
          ដើម្បីធ្វើឱ្យការថែទាំសុខភាពប្រកបដោយគុណភាពអាចប្រើប្រាស់បានសម្រាប់អ្នក
          និងគ្រួសាររបស់អ្នក
        </p>
      </div>
      <div class="row">
        <div class="col-5 mx-auto">
          <ul
            class="nav nav-pills mb-3 d-flex align-items-center justify-content-center"
            id="service-tabs"
            role="tablist"
          >
            <li class="tab-item" role="presentation">
              <button
                class="nav-link active"
                id="tab-health-check"
                data-bs-toggle="pill"
                data-bs-target="#tab-content-health-check"
                type="button"
                role="tab"
                aria-controls="tab-content-health-check"
                aria-selected="true"
              >
                ពិនិត្យសុខភាព
              </button>
            </li>
            <li class="tab-item" role="presentation">
              <button
                class="nav-link"
                id="tab-vaccine"
                data-bs-toggle="pill"
                data-bs-target="#tab-content-vaccine"
                type="button"
                role="tab"
                aria-controls="tab-content-vaccine"
                aria-selected="false"
              >
                ចាក់វ៉ាកសាំង
              </button>
            </li>
          </ul>
        </div>
        <div class="tab-content" id="service-tabContent">
          <div
            class="tab-pane fade show active"
            id="tab-content-health-check"
            role="tabpanel"
            aria-labelledby="tab-health-check"
            tabindex="0"
          >
            <div class="row mt-2">
              <div
                class="col-4"
                v-for="service in useStorePackage.tabServiceCheck"
                :key="service.id"
              >
                <a
                  @click="useStorePackage.onClickDetail(service.id)"
                  class="card pb-2 card-package box-shadow"
                >
                  <div class="overflow-hidden wrapper-img">
                    <img
                      :src="service.thumbnail"
                      class="card-img-top"
                      alt="..."
                    />
                  </div>
                  <div class="card-body">
                    <h5 class="limit-line-1 text-color-950">
                      {{ service.local_name }}
                    </h5>
                    <p class="limit-line-3">{{ service.local_description }}</p>
                    <div
                      class="d-flex align-items-center justify-content-between"
                    >
                      <span>
                        {{ service.local_created_at }}
                      </span>
                      <div>
                        <span
                          class="d-block fw-medium text-color-800"
                          style="font-size: 14px"
                        >
                          <i
                            class="bi ms-4 me-1 bi-bag-plus text-color-800 fs-5"
                          ></i>
                          {{ service.sub_services_count }}
                          ប្រភេទ
                        </span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div
                class="col-12 d-flex align-items-center justify-content-center"
              >
                <div class="text-center mt-5">
                  <!-- <RouterLink to="/package" class="btn-bg-800"></RouterLink> -->
                  <primaryBtn label="មើលបន្ថែម" :click-event="onClickPackage" />
                </div>
              </div>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="tab-content-vaccine"
            role="tabpanel"
            aria-labelledby="tab-vaccine"
            tabindex="0"
          >
            <div class="row mt-2">
              <div
                class="col-4"
                v-for="service in useStorePackage.tabServiceVaccine"
                :key="service.id"
              >
                <a
                  @click="useStorePackage.onClickDetail(service.id)"
                  class="card pb-2 card-package box-shadow"
                >
                  <div class="overflow-hidden wrapper-img">
                    <img
                      :src="service.thumbnail"
                      class="card-img-top"
                      alt="..."
                    />
                  </div>
                  <div class="card-body">
                    <h5 class="limit-line-1 text-color-950">
                      {{ service.local_name }}
                    </h5>
                    <p class="limit-line-3">{{ service.local_description }}</p>
                    <div
                      class="d-flex align-items-center justify-content-between"
                    >
                      <span>
                        {{ service.local_created_at }}
                      </span>
                      <div>
                        <span
                          class="d-block fw-medium text-color-800"
                          style="font-size: 14px"
                        >
                          <i
                            class="bi ms-4 me-1 bi-bag-plus text-color-800 fs-5"
                          ></i>
                          {{ service.sub_services_count }}
                          ប្រភេទ
                        </span>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-12">
                <div class="d-flex justify-content-center mt-5">
                  <!-- <RouterLink to="/package" class="btn-bg-800"></RouterLink> -->
                  <primaryBtn label="មើលបន្ថែម" :click-event="onClickPackage" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="knowledge health article">
    <div class="container">
      <div class="row">
        <div
          class="sec-title mb-3 align-items-end d-flex justify-content-between"
        >
          <div>
            <span class="section-title-tag">ព័ត៌មានសុខភាព</span>
            <h4 class="sc-title mt-3 mb-0 pb-0">
              ស្វែងយល់បន្ថែមអំពីចំណេះថែទាំសុខភាព
            </h4>
          </div>

          <div class="navigation-swiper d-flex align-items-center gap-3">
            <button class="custom-prev-btn p-0 border-0 bg-transparent">
              <i class="fa-regular fa-arrow-left fs-5 text-color-950"></i>
            </button>
            <button class="custom-next-btn p-0 border-0 bg-transparent">
              <i class="fa-regular fa-arrow-right fs-5 text-color-950"></i>
            </button>
          </div>
        </div>

        <div class="col-12">
          <div class="wrapper d-flex justify-content-between">
            <swiper
              :spaceBetween="24"
              :loop="true"
              :centeredSlides="false"
              :pagination="{
                clickable: true,
              }"
              :navigation="{
                prevEl: '.custom-prev-btn',
                nextEl: '.custom-next-btn',
              }"
              :modules="[Navigation]"
              :breakpoints="{
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
              }"
              class="mySwiper"
            >
              <swiper-slide
                v-for="article in articlestore.article"
                :key="article.id"
              >
                <div class="col-12 h-100">
                  <a
                    role="button"
                    @click="articlestore.getArticle(article.id)"
                    class="card border-0 news box-shadow text-decoration-none overflow-hidden h-100"
                  >
                    <div
                      class="img rounded-3 overflow-hidden position-relative"
                    >
                      <img
                        :src="article.thumbnail"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                      <div class="tag">
                        {{ article.category?.local_name }}
                      </div>
                    </div>
                    <div
                      class="card-body pt-2 position-relative d-flex flex-column flex-wrap justify-content-between"
                    >
                      <div>
                        <h5 class="mb-0 pb-0 limit-line-2">
                          {{ article.title }} 
                        </h5>

                        <p
                          class="my-2 text-color-gray limit-line-2"
                          style="font-size: 15px"
                        >
                          {{ article.short_description }}
                        </p>
                      </div>

                      <div
                        class="d-flex align-items-center justify-content-between"
                      >
                        <div
                          class="txt-small text-color-text fw-medium"
                          style="font-size: 14px"
                        >
                          <i class="bi bi-clock"></i>
                          {{ article.updated_at }}
                        </div>
                        <div
                          class="text-color-gray d-flex align-items-center justify-content-end"
                        >
                          <i class="bi bi-eye me-1"></i>
                          <span class="fw-medium" style="font-size: 14px">{{
                            article.view
                          }}</span>
                          <!-- <div v-if="authStore.token">
                              <a
                                @click.stop.prevent="
                                  article.is_save
                                    ? articlestore.onRemoveArticle(article.id)
                                    : articlestore.onSaveArticle(article.id)
                                "
                                role="button"
                                class="save"
                              >
                                <i
                                  class=""
                                  :class="
                                    article.is_save
                                      ? 'bi bi-bookmarks-fill text-color-warning'
                                      : 'bi bi-bookmarks text-color-gray'
                                  "
                                ></i>
                              </a>
                            </div> -->
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              </swiper-slide>
            </swiper>
          </div>
        </div>
      </div>

      <!-- <div class="row">
                <div class="col-3">
                    <card class="card">
                        <RouterLink to="" class="overflow-hidden wrapper-img">
                            <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                class="w-100  object-fit-cover h-100" alt="...">
                        </RouterLink>
                        <div class="card-body px-0">
                            <RouterLink to="" class="card-title ">ចៀសវាង​កំហុស​ឆ្គង​ទាំង​៥​នេះ​
                                ដើម្បី​ឲ្យ​សន្លាក់​មាន​សុខភាព​ល្អ​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                            </RouterLink>
                            <p class="limit-line-2 text-color-text">ការរ​លាក​សន្លាក់​ជា​ធម្មតា​វា​ធ្វើ​អោយ​មានការ​ឈឺចាប់
                                និង​មិន​អាច​ធ្វើ​ចលនា​បាន​ល្អ​លើ​សន្លាក់​ណា​ដែល​មាន​បញ្ហា​នេះ</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex">
                                    <RouterLink to="" class="profile">
                                        <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                            class="w-100 h-100 object-fit-cover" alt="...">
                                    </RouterLink>
                                    <div class="ms-2">
                                        <span class=" fw-medium">John Smith</span>
                                        <p class="mb-0 txt-small text-color-small">12 មករា 2025</p>
                                    </div>
                                </div>
                                <a role="button" class="btn-save">
                                    <i class="bi bi-bookmarks fs-4 me-2 text-color-gray opacity-75"></i>

                                </a>
                            </div>
                        </div>
                    </card>
                </div>
                <div class="col-3">
                    <card class="card">
                        <RouterLink to="" class="overflow-hidden wrapper-img">
                            <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                class="w-100  object-fit-cover h-100" alt="...">
                        </RouterLink>
                        <div class="card-body px-0">
                            <RouterLink to="" class="card-title ">ចៀសវាង​កំហុស​ឆ្គង​ទាំង​៥​នេះ​
                                ដើម្បី​ឲ្យ​សន្លាក់​មាន​សុខភាព​ល្អ​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                            </RouterLink>
                            <p class="limit-line-2 text-color-text">ការរ​លាក​សន្លាក់​ជា​ធម្មតា​វា​ធ្វើ​អោយ​មានការ​ឈឺចាប់
                                និង​មិន​អាច​ធ្វើ​ចលនា​បាន​ល្អ​លើ​សន្លាក់​ណា​ដែល​មាន​បញ្ហា​នេះ</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex">
                                    <RouterLink to="" class="profile">
                                        <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                            class="w-100 h-100 object-fit-cover" alt="...">
                                    </RouterLink>
                                    <div class="ms-2">
                                        <span class=" fw-medium">John Smith</span>
                                        <p class="mb-0 txt-small text-color-small">12 មករា 2025</p>
                                    </div>
                                </div>
                                <a role="button" class="btn-save">
                                    <i class="bi bi-bookmarks fs-4 me-2 text-color-gray opacity-75"></i>

                                </a>
                            </div>
                        </div>
                    </card>
                </div>
                <div class="col-3">
                    <card class="card">
                        <RouterLink to="" class="overflow-hidden wrapper-img">
                            <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                class="w-100  object-fit-cover h-100" alt="...">
                        </RouterLink>
                        <div class="card-body px-0">
                            <RouterLink to="" class="card-title ">ចៀសវាង​កំហុស​ឆ្គង​ទាំង​៥​នេះ​
                                ដើម្បី​ឲ្យ​សន្លាក់​មាន​សុខភាព​ល្អ​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                            </RouterLink>
                            <p class="limit-line-2 text-color-text">ការរ​លាក​សន្លាក់​ជា​ធម្មតា​វា​ធ្វើ​អោយ​មានការ​ឈឺចាប់
                                និង​មិន​អាច​ធ្វើ​ចលនា​បាន​ល្អ​លើ​សន្លាក់​ណា​ដែល​មាន​បញ្ហា​នេះ</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex">
                                    <RouterLink to="" class="profile">
                                        <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                            class="w-100 h-100 object-fit-cover" alt="...">
                                    </RouterLink>
                                    <div class="ms-2">
                                        <span class=" fw-medium">John Smith</span>
                                        <p class="mb-0 txt-small text-color-small">12 មករា 2025</p>
                                    </div>
                                </div>
                                <a role="button" class="btn-save">
                                    <i class="bi bi-bookmarks fs-4 me-2 text-color-gray opacity-75"></i>

                                </a>
                            </div>
                        </div>
                    </card>
                </div>
                <div class="col-3">
                    <card class="card">
                        <RouterLink to="" class="overflow-hidden wrapper-img">
                            <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                class="w-100  object-fit-cover h-100" alt="...">
                        </RouterLink>
                        <div class="card-body px-0">
                            <RouterLink to="" class="card-title ">ចៀសវាង​កំហុស​ឆ្គង​ទាំង​៥​នេះ​
                                ដើម្បី​ឲ្យ​សន្លាក់​មាន​សុខភាព​ល្អ​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                            </RouterLink>
                            <p class="limit-line-2 text-color-text">ការរ​លាក​សន្លាក់​ជា​ធម្មតា​វា​ធ្វើ​អោយ​មានការ​ឈឺចាប់
                                និង​មិន​អាច​ធ្វើ​ចលនា​បាន​ល្អ​លើ​សន្លាក់​ណា​ដែល​មាន​បញ្ហា​នេះ</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex">
                                    <RouterLink to="" class="profile">
                                        <img src="/src/assets/images/auth/homePage/heart-disease.jpg"
                                            class="w-100 h-100 object-fit-cover" alt="...">
                                    </RouterLink>
                                    <div class="ms-2">
                                        <span class=" fw-medium">John Smith</span>
                                        <p class="mb-0 txt-small text-color-small">12 មករា 2025</p>
                                    </div>
                                </div>
                                <a role="button" class="btn-save">
                                    <i class="bi bi-bookmarks fs-4 me-2 text-color-gray opacity-75"></i>

                                </a>
                            </div>
                        </div>
                    </card>
                </div>
            </div> -->
    </div>
  </section>
  <section class="faq">
    <div class="container">
      <div class="text-center">
        <h4 class="sc-title my-3">សំណួរដែលសួរញឹកញាប់</h4>
        <p class="text-color-text text-center mb-4 mx-auto" style="width: 73%">
          ទាំងនេះគឺជាសំណួរដែលគេសួរញឹកញាប់បំផុត
          ដើម្បីជួយអ្នកឱ្យយល់កាន់តែច្បាស់អំពីសេវាកម្មរបស់យើង
          ចាប់ពីការកក់ការណាត់ជួបរហូតដល់ការយល់ដឹងអំពីប្រភេទនៃការថែទាំដែលយើងផ្តល់ជូនយើងបានចងក្រងចម្លើយដើម្បីធានាថាអ្នកមានបទពិសោធន៍គ្មានថ្នេរ។
        </p>
      </div>
      <div class="row">
        <div class="col-6 mx-auto">
          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed mb-0"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseOne"
                  aria-expanded="false"
                  aria-controls="flush-collapseOne"
                >
                  តើខ្ញុំកក់ការណាត់ជួបជាមួយវេជ្ជបណ្ឌិតដោយរបៀបណា?
                </button>
              </h2>
              <div
                id="flush-collapseOne"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body text-color-text">
                  អ្នកអាចកក់ការណាត់ជួបតាមរយៈប្រព័ន្ធកក់អនឡាញរបស់យើងដែលមាននៅលើគេហទំព័រ។
                  គ្រាន់តែជ្រើសរើសវេជ្ជបណ្ឌិតកាលបរិច្ឆេទនិងពេលវេលាដែលអ្នកពេញចិត្តហើយបំពេញដំណើរការនេះ។
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button mb-0 collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseTwo"
                  aria-expanded="false"
                  aria-controls="flush-collapseTwo"
                >
                  តើខ្ញុំអាចចូលប្រើកំណត់ត្រាវេជ្ជសាស្រ្តរបស់ខ្ញុំតាមអ៊ីនធឺណិតបានទេ?
                </button>
              </h2>
              <div
                id="flush-collapseTwo"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body text-color-text">
                  អ្នកអាចកក់ការណាត់ជួបតាមរយៈប្រព័ន្ធកក់អនឡាញរបស់យើងដែលមាននៅលើគេហទំព័រ។
                  គ្រាន់តែជ្រើសរើសវេជ្ជបណ្ឌិតកាលបរិច្ឆេទនិងពេលវេលាដែលអ្នកពេញចិត្តហើយបំពេញដំណើរការនេះ។
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed mb-0"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseThree"
                  aria-expanded="false"
                  aria-controls="flush-collapseThree"
                >
                  តើមន្ទីរពេទ្យផ្តល់សេវាសង្គ្រោះបន្ទាន់ទេ?
                </button>
              </h2>
              <div
                id="flush-collapseThree"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body text-color-text">
                  អ្នកអាចកក់ការណាត់ជួបតាមរយៈប្រព័ន្ធកក់អនឡាញរបស់យើងដែលមាននៅលើគេហទំព័រ។
                  គ្រាន់តែជ្រើសរើសវេជ្ជបណ្ឌិតកាលបរិច្ឆេទនិងពេលវេលាដែលអ្នកពេញចិត្តហើយបំពេញដំណើរការនេះ។
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed mb-0"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapsefoure"
                  aria-expanded="false"
                  aria-controls="flush-collapsefoure"
                >
                  តើមន្ទីរពេទ្យផ្តល់សេវាសង្គ្រោះបន្ទាន់ទេ?
                </button>
              </h2>
              <div
                id="flush-collapsefoure"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body text-color-text">
                  អ្នកអាចកក់ការណាត់ជួបតាមរយៈប្រព័ន្ធកក់អនឡាញរបស់យើងដែលមាននៅលើគេហទំព័រ។
                  គ្រាន់តែជ្រើសរើសវេជ្ជបណ្ឌិតកាលបរិច្ឆេទនិងពេលវេលាដែលអ្នកពេញចិត្តហើយបំពេញដំណើរការនេះ។
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { RouterLink } from "vue-router";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import router from "@/router";
import { Navigation } from "swiper/modules";
import primaryBtn from "@/views/primaryBtn.vue";
import { articleStore } from "@/stores/articalStore";
import { pagekageStore } from "@/stores/packagestore";
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/authTokenStore";
import LoadingView from "@/views/loading/loadingView.vue";
const authStore = useAuthStore();
const articlestore = articleStore();
const useStorePackage = pagekageStore();
const onClickPackage = () => {
  router.push("/package");
};
const onClickAboutUs = () => {
  router.push("/aboutus");
};
const onClickBooking = () => {
  authStore.loadToken();
  if (!authStore.token) {
    // alert(authStore.token);
    router.push("/login");
  } else {
    // alert(authStore.token);
    router.push("/book-appointment");
  }
};
onMounted(async () => {
  window.scrollTo({ top: 0, behavior: "smooth" });

  articlestore.filter.per_page = 8;
  await articlestore.onloadArticle();
  await useStorePackage.getTabService(1, 3);
  await useStorePackage.getTabService(2, 3);
});

const onSavearticle = (id) => {
  let index = articlestore.article.findIndex((item) => item.id == id);
  articlestore.article[index].is_save = true;
};
const onResetSavearticle = (id) => {
  let index = articlestore.article.findIndex((item) => item.id == id);
  articlestore.article[index].is_save = false;
};
</script>
