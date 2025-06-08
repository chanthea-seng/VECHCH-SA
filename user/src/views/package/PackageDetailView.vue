<template>
  <Navbar />
  <loadingView v-if="packagestore.loading" />
  <main class="package-detail article">
    <div class="container pt-5 mt-4">
      <span class="text-white bg-color-800 rounded-3 px-3 py-2 box-shadow">
        {{
          packagestore.service.service_type == 1
            ? "កញ្ចប់ពិនិត្យសុខភាព"
            : "កញ្ចប់វ៉ាក់សាំង"
        }}
      </span>
      <h3 class="mt-4">{{ packagestore.service.local_name }}</h3>
      <div class="package-time mb-3">
        <i class="bi bi-alarm me-2"></i>
        <span class="fw-medium"
          >ចុះផ្សាយនៅថ្ងៃ៖ {{ packagestore.service.local_created_at }}</span
        >
      </div>
      <div class="row">
        <div class="col-md-8">
          <div class="package-detail-image">
            <div
              class="card rounded-0 border-0"
              v-if="
                packagestore.service.service_images &&
                packagestore.service.service_images.length > 0
              "
            >
              <img
                :src="packagestore.service.service_images[0].url"
                class="img-fluid rounded"
                alt=""
                style="height: 60vh; object-position: center"
              />
            </div>
            <div
              class="row mt-3 package-detail-image-list"
              v-if="
                packagestore.service.service_images &&
                packagestore.service.service_images.length > 0
              "
            >
              <div
                v-for="(
                  image, index
                ) in packagestore.service.service_images.slice(1)"
                :key="index"
                class="col-md-3"
              >
                <div class="card position-relative">
                  <img :src="image.url" class="img-fluid rounded" alt="" />
                  <div
                    v-if="index == 4"
                    class="package-picture d-flex align-items-center justify-content-center text-light"
                  >
                    +{{ packagestore.service.service_images.length - 4 }} images
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="package-detail-info">
            <h4 class="mb-3">ប្រភេទកញ្ចប់ពិនិត្យសុខភាពផ្សេងៗ</h4>
            <div>
              <a
                role="button"
                class="package-link mb-1 d-flex align-items-center"
                v-for="service in packagestore.allServices"
                :key="service.id"
                :class="service.id == packagestore.service.id ? 'active' : ' '"
                @click="packagestore.onClickDetailSameRoute(service.id)"
              >
                <span>{{ service.local_name }}</span>
                <i class="bi bi-chevron-right ms-auto"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="package-detail-content mt-4">
        <p>
          {{ packagestore.service.local_description }}
        </p>
        <div class="package-detail-appointment">
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
                <tr
                  v-for="(item, index) in packagestore.service.sub_services"
                  :key="item.id"
                >
                  <td scope="row" class="package-td">
                    ប្រភេទទី {{ index + 1 }}
                  </td>
                  <td>
                    <ul class="list-unstyled m-0">
                      <li
                        v-for="(title, index) in item.local_description.split(
                          ','
                        )"
                        :key="index"
                        class="package-ul-li"
                      >
                        {{ title }}
                      </li>
                    </ul>
                  </td>

                  <td>
                    <ul class="list-unstyled m-0">
                      <li class="package-ul-li package-price">
                        <span> $ {{ item.price }} </span>
                      </li>
                      <li class="package-ul-li package-price">
                        <span>&#6107; {{ item.price * 4100 }} </span>
                      </li>
                    </ul>
                  </td>

                  <td>
                    <button
                      type="button"
                      @click="packagestore.onClickBook(item.id)"
                      class="btn btn-first"
                    >
                      កក់ឥឡូវនេះ
                    </button>
                  </td>
                </tr>

                <!-- <tr
                  v-for="item in packagestore.service.sub_services"
                  :key="item.id"
                >
                  <td scope="row" class="package-td">ប្រភេទទី១</td>
                  <td>
                    <ul class="list-unstyled m-0">
                      <li class="package-ul-li">គ្រាប់ឈាម ស ក្រហម (CBC)</li>
                      <li class="package-ul-li">
                        ខ្លាញ់​ក្នុង​សសៃ​ឈាម Triglycerides
                      </li>
                      <li class="package-ul-li">
                        ខ្លាញ់បេះដូង Total Cholesterol
                      </li>
                      <li class="package-ul-li">ខ្លាញ់ល្អ HDL Cholesterol</li>
                      <li class="package-ul-li">
                        ខ្លាញ់អាក្រក់ LDL Cholesterol
                      </li>
                      <li class="package-ul-li">ជាតិប្រៃ Albumin</li>
                      <li class="package-ul-li">ជាតិកាល់​ស្យូម Calcium</li>
                      <li class="package-ul-li">ជាតិអេឡិកត្រូលីត Ionogramme</li>
                      <li class="package-ul-li">មុខងារតំរងនោម (BUN)</li>
                      <li class="package-ul-li">ជាតិស្ករ Glucose</li>
                      <li class="package-ul-li">មុខងារតំរងនោម Creatinine</li>
                      <li class="package-ul-li">អាស៊ីតអ៊ុយរីក Uric acid</li>
                      <li class="package-ul-li">
                        ជាតិប្រូតេអ៊ីន Protein, total
                      </li>
                      <li class="package-ul-li">
                        មុខងារថ្លើម Transaminase (AST, ALT)
                      </li>
                      <li>មុខងារថ្លើម GGT</li>
                    </ul>
                  </td>
                  <td>
                    <ul class="list-unstyled m-0">
                      <li class="package-ul-li package-price">$23.50</li>
                      <li class="package-ul-li package-price">&#6107;96,350</li>
                    </ul>
                  </td>
                  <td>
                    <button type="button" class="btn btn-first">
                      កក់ឥឡូវនេះ
                    </button>
                  </td>
                </tr> -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="package-detail-other-selection mt-5"></div>
      <div class="package-detail-principles-rules mt-5 mb-5">
        <h5 class="mb-3">
          ច្បាប់ និងគោលការណ៍សម្រាប់ការកក់កញ្ចប់ពិនិត្យមន្ទីរពេទ្យ
        </h5>
        <div class="package-detail-principles-rules-content">
          <div class="rules-delete-reservation mb-4 d-flex">
            <div class="rule-me">
              <i class="bi bi-info-circle me-2"></i>ការលុបចោលការកក់
            </div>
            <div class="rule-right">
              ការទូទាត់ដែលបានធ្វើឡើងសម្រាប់កញ្ចប់ពិនិត្យមន្ទីរពេទ្យគឺមិនអាចដកវិញបានទេ
              ដោយមិនគិតពីហេតុផលសម្រាប់ការលុបចោល
            </div>
          </div>
          <div class="rules-delete-reservation mb-4 d-flex">
            <div class="rule-me">
              <i class="bi bi-calendar2-plus me-2"></i
              >កំណត់ពេលឡើងវិញនៃការពិនិត្យសុខភាព
            </div>
            <div class="rule-right">
              ការណាត់ជួបសម្រាប់កញ្ចប់ពិនិត្យមិនអាចកំណត់ពេលឡើងវិញបានទេបន្ទាប់ពីបានបញ្ជាក់អ្នកជំងឺត្រូវតែធ្វើការសម្រេចចិត្តអោយបានត្រឹមត្រូវមុនពេលធ្វើការកក់កញ្ចប់ពិនិត្យសុខភាពនីយមួយៗ
            </div>
          </div>
          <div class="rules-delete-reservation mb-4 d-flex">
            <div class="rule-me">
              <i class="bi bi-paperclip me-2"></i>ឯកសារដែលត្រូវភ្ចាប់តាម
            </div>
            <div class="rule-right">
              សម្រាប់ការណាត់ជួបពិនិត្យអ្នកជំងឺត្រូវភ្ជាប់ឯកសារការបញ្ជាក់ឌីជីថលនៃការណាត់ជួប
              ឬការកក់កញ្ចប់
            </div>
          </div>
          <div class="rules-delete-reservation rules-card d-flex">
            <div class="rule-me">
              <i class="bi bi-credit-card-2-front me-2"></i
              >យើងទទួលការបង់ប្រាក់តាមរយៈ
            </div>
            <div class="rule-right">ធានាគា ABA</div>
          </div>
        </div>
      </div>
      <div class="package-contact-info mb-3">
        <div class="row">
          <div class="col-5">
            <div class="card border-0 bg-transparent">
              <h5>សម្រាប់ព័ត៌ទំនាក់ទំនងបន្ថែម៖</h5>
              <div class="contact-info-icon mt-4">
                <ul class="m-0 p-0 list-unstyled">
                  <li class="mb-3">
                    <i class="bi bi-telephone-inbound me-3"></i>
                    <span>+855 987654321 (សង្គ្រោះបន្ទាន់)</span>
                  </li>
                  <li class="mb-3">
                    <i class="bi bi-telephone-inbound me-3"></i>
                    <span>+855 123456789</span>
                  </li>
                  <li class="mb-3">
                    <i class="bi bi-envelope me-3"></i>
                    <span>consultsphere@gmail.com</span>
                  </li>
                  <li class="mb-3">
                    <i class="bi bi-geo-alt me-3"></i>
                    <span>54 St 606, Phnom Penh</span>
                  </li>
                </ul>
                <div class="package-map">
                  <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.7186053829864!2d104.88750180996851!3d11.572018988581847!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109519e0c9b2109%3A0x8b8d35d80b920ffc!2sANT%20Technology%20Training%20School!5e0!3m2!1sen!2skh!4v1737711929318!5m2!1sen!2skh"
                    width="600"
                    height="450"
                    style="border: 0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                  ></iframe>
                </div>
              </div>
            </div>
          </div>
          <div class="col-7">
            <div class="card border-0 bg-transparent">
              <div class="faq">
                <h5 class="mb-4">សំណួរដែលគេ​បានសួរច្រើន​</h5>
                <div class="accordion" id="accordionExample">
                  <div class="accordion-item border-0 shadow-none mb-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                      >
                        ហេតុអ្វីការពិនិត្យសុខភាពបង្ការមានសារៈសំខាន់?
                      </button>
                    </h2>
                    <div
                      id="collapseOne"
                      class="accordion-collapse collapse"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        ការពិនិត្យសុខភាពបង្ការជួយរកឃើញជំងឺឬបញ្ហាសុខភាពនៅដំណាក់កាលដំបូង
                        មុនពេលវានៅកម្រិតធ្ងន់ធ្ងរឡើង ជំងឺដូចជាមហារីក (cancer),
                        ជំងឺបេះដូង (heart disease), ឬជំងឺទឹកនោមផ្អែម (diabetes)
                        អាចត្រូវបានគ្រប់គ្រងឬព្យាបាលបានប្រសើរជាងនេះបើវាត្រូវបានរកឃើញកាន់តែលឿន។
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item border-0 shadow-none mb-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                      >
                        តើការពិនិត្យសុខភាពធ្វើឡើងដោយរបៀបណា?
                      </button>
                    </h2>
                    <div
                      id="collapseTwo"
                      class="accordion-collapse collapse"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <span>
                          ការពិនិត្យសុខភាពត្រូវបានអនុវត្តដោយវេជ្ជបណ្ឌិតឯកទេស
                          ដោយផ្អែកលើការចូលប្រើសេវាកម្មរបស់អ្នក។
                          បន្ទាប់ពីអ្នកធ្វើការកក់ពេលវេលា តាមរយៈគេហទំព័រ
                          ឬកម្មវិធី
                          អ្នកនឹងត្រូវបានស្នើឲ្យមកជួបវេជ្ជបណ្ឌិតនៅកន្លែងកំណត់។
                          វេជ្ជបណ្ឌិតនឹងធ្វើការសួរព័ត៌មានទូទៅ ស្វែងយល់អំពីអាការៈ
                          បំពេញការត្រួតពិនិត្យរាងកាយ
                          និងអាចផ្ដល់ការធ្វើតេស្តបន្ថែមបើចាំបាច់។ បន្ទាប់មក
                          អ្នកនឹងទទួលបានលទ្ធផល
                          និងសំណូមពរព្យាបាលតាមស្ថានភាពសុខភាពរបស់អ្នក។
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item border-0 shadow-none mb-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseThree"
                        aria-expanded="false"
                        aria-controls="collapseThree"
                      >
                        តើខ្ញុំគួរយកវេជ្ជបញ្ជា
                        និងថ្នាំដែលមានស្រាប់របស់ខ្ញុំមកជាមួយដែរឬទេ?
                      </button>
                    </h2>
                    <div
                      id="collapseThree"
                      class="accordion-collapse collapse"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <span>
                          បាទ/ចាស អ្នកគួរយកវេជ្ជបញ្ជា
                          និងថ្នាំដែលអ្នកកំពុងប្រើស្រាប់មកជាមួយ
                          នៅពេលទៅពិនិត្យសុខភាព។
                          វាជាការជួយសម្រួលដល់វេជ្ជបណ្ឌិតក្នុងការយល់អំពីប្រវត្តិការព្យាបាលរបស់អ្នក
                          និងជួយបង្ការការប្រើថ្នាំស្ទួន
                          ឬការប្រតិបត្តិគ្នារវាងថ្នាំ។ វេជ្ជបណ្ឌិតអាចផ្លាស់ប្តូរ
                          ឬកែសម្រួលវេជ្ជបញ្ជាដែលមានស្រាប់ ប្រសិនបើចាំបាច់
                          ដើម្បីឲ្យសមស្របនឹងស្ថានភាពសុខភាពបច្ចុប្បន្នរបស់អ្នក។
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item border-0 shadow-none mb-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFour"
                        aria-expanded="false"
                        aria-controls="collapseFour"
                      >
                        ខ្ញុំមានសុខភាពល្អណាស់។
                        ហេតុអ្វីខ្ញុំត្រូវការការពិនិត្យសុខភាព?
                      </button>
                    </h2>
                    <div
                      id="collapseFour"
                      class="accordion-collapse collapse"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <span>
                          ទោះបីអ្នកមានអារម្មណ៍ថាសុខភាពល្អក៏ដោយ
                          ការពិនិត្យសុខភាពទៀងទាត់នៅតែមានសារៈសំខាន់ណាស់។
                          វាជារបៀបមួយដ៏មានប្រសិទ្ធភាពក្នុងការរកឃើញជំងឺឬបញ្ហាសុខភាពបឋមដែលអាចមិនបង្ហាញអាការៈនៅដើមៗ។
                          ការពិនិត្យជាប្រចាំអាចជួយឲ្យអ្នកទទួលបានការព្យាបាលពេលវេលា
                          បង្ការការរីកចម្រើននៃជំងឺ
                          និងរក្សាសុខភាពឲ្យបានល្អជាប្រចាំ។
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="accordion-item border-0 shadow-none mb-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseFive"
                        aria-expanded="false"
                        aria-controls="collapseFive"
                      >
                        តើខ្ញុំអាចទទួលលទ្ធផលនៃការត្រួតពិនិត្យតាមអ៊ីមែល
                        ឬទូរស័ព្ទបានទេ?
                      </button>
                    </h2>
                    <div
                      id="collapseFive"
                      class="accordion-collapse collapse"
                      data-bs-parent="#accordionExample"
                    >
                      <div class="accordion-body">
                        <span></span>
                        បាទ/ចាស អ្នកអាចទទួលលទ្ធផលនៃការត្រួតពិនិត្យតាមរយៈអ៊ីមែល
                        ឬទូរស័ព្ទ បើអ្នកបានជ្រើសរើសជម្រើសនោះនៅពេលកក់ពិនិត្យ។
                        ប្រសិនបើលទ្ធផលត្រូវការការពន្យល់បន្ថែម
                        វេជ្ជបណ្ឌិតអាចទំនាក់ទំនងតាមទូរស័ព្ទ
                        ឬកំណត់ការពិភាក្សាតាមអនឡាញ ដើម្បីបញ្ជាក់លម្អិត។
                        សូមប្រាកដថាអ្នកផ្ដល់ព័ត៌មានទំនាក់ទំនងត្រឹមត្រូវ
                        និងបង្កើនសុវត្ថិភាពលើការទទួលព័ត៌មានផ្ទាល់ខ្លួនរបស់អ្នក។
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="d-flex knowledge justify-content-between align-items-center mb-3 pt-4"
      >
        <h4>ស្វែងយល់បន្ថែមអំពីចំណេះថែទាំសុខភាព</h4>
        <div class="navigation-swiper d-flex align-items-center gap-3">
          <button
            class="custom-prev-btn d-flex align-items-center p-0 border-0 bg-transparent"
          >
            <i class="fa-regular fa-arrow-left fs-5 text-color-950"></i>
          </button>
          <button
            class="custom-next-btn d-flex align-items-center p-0 border-0 bg-transparent"
          >
            <i class="fa-regular fa-arrow-right fs-5 text-color-950"></i>
          </button>
        </div>
      </div>

      <div class="col-12 w-100 bg-grey pb-5">
        <div class="wrapper knowledge article d-flex justify-content-between">
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
                  <div class="img rounded-3 overflow-hidden position-relative">
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
                      <h5 class="mb-0 pb-0 limit-line-2 text-black">
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
  </main>
  <FooterView />
</template>

<script setup="">
import loadingView from "../loading/loadingView.vue";
import Navbar from "@/components/layouts/Navbar.vue";
import FooterView from "@/components/layouts/FooterView.vue";
import { pagekageStore } from "@/stores/packagestore";
import { computed, onMounted, ref } from "vue";
import { Navigation } from "swiper/modules";
import { useRoute } from "vue-router";
import { watch } from "vue";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import { Swiper, SwiperSlide } from "swiper/vue";
import { articleStore } from "@/stores/articalStore";
const articlestore = articleStore();
const packagestore = pagekageStore();
const route = useRoute();
const serviceId = ref(sessionStorage.getItem("serviceId"));
const serviceType = computed(() => packagestore.filter.service_type);
onMounted(() => {
  window.scrollTo({ top: 0, behavior: "smooth" });

  articlestore.onloadArticle();
  packagestore.getServiceDetail();
  packagestore.getAllService(1, serviceType.value, false);
});

watch(serviceId, () => {
  packagestore.getServiceDetail();
});
</script>
