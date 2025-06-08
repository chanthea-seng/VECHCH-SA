<template>
  <!-- <div class="" style="height: 300px;">hello</div> -->
  <footer class="footers">
    <div class="bg-color-950 footer py-5">
      <div class="container">
        <div class="d-flex justify-content-between">
          <div class="me-auto" style="width: 35%">
            <RouterLink to="/">
              <img
                class="footer-logo"
                src="../../assets/images/layout_logo/vcs_white_logo.png"
                alt=""
              />
            </RouterLink>
            <p class="text-white mt-4">
              <strong class="fs-5 fw-semibold">វេជ្ជសាល </strong
              >គឺជាគេហទំព័រមួយដែលផ្តល់ជូននូវសេវាកម្មសុខភាពសាធារណៈ
              ដល់អ្នកប្រើប្រាស់អោយមានភាពងាយស្រួលក្នុងការជំនួបពិគ្រោះជាមួយវេជ្ជបណ្ឌិតដែលមានជំនាញច្បាស់លាស់
              និង ផ្តល់ជូននូវកញ្ចប់សេវាកម្មជាច្រើនទៀត។
            </p>
          </div>
          <div class="row" style="width: 63%">
            <div class="col">
              <h5 class="footer-title">សេវាកម្ម</h5>
              <ul class="list-group">
                <li class="list-group-item">
                  <a @click="onClickCheckToken()" class="nav-link cursor-pointer">
                    ជំនួបពិគ្រោះជំងឺ
                  </a>
                </li>
                <li class="list-group-item">
                  <RouterLink to="/finddoctor" class="nav-link">
                    ស្វែងរកវេជ្ជបណ្ឌិត
                  </RouterLink>
                </li>
                <li class="list-group-item">
                  <RouterLink to="/package" class="nav-link">
                    កញ្ចប់ និងតម្លៃពិនិត្យសុខភាព
                  </RouterLink>
                </li>
                <li class="list-group-item">
                  <RouterLink to="/transportation" class="nav-link">
                    មធ្យោបាយធ្វើដំណើរ
                  </RouterLink>
                </li>
              </ul>
            </div>
            <div class="col">
              <h5 class="footer-title">អត្ថទបចំណេះដឹង</h5>
              <ul class="list-group">
                <li class="list-group-item">
                  <RouterLink to="/findDisease" class="nav-link">
                    ស្វែងយល់អំពីជំងឺ
                  </RouterLink>
                </li>
                <li class="list-group-item">
                  <RouterLink to="/article" class="nav-link">
                    សុខភាពសាធារណៈ
                  </RouterLink>
                </li>
              </ul>
            </div>
            <div class="col contact-us">
              <h5 class="footer-title">ទំនាក់ទំនងតាមរយៈ</h5>
              <ul class="list-group">
                <li class="list-group-item">
                  <i class="bi bi-telephone"></i>
                  +855 16 123 4567
                </li>
                <li class="list-group-item">
                  <i class="bi bi-envelope"></i>
                  vechchesalHospital@gmail.com
                </li>
                <li class="list-group-item">
                  <i class="bi bi-geo-alt"></i>
                  #86B Street 313, Phnom Penh
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-2 copyright">
      <div class="container">
        <div class="d-flex justify-content-between">
          <div class="">
            <span class="txt-small"
              >Copyright © 2025 Vichesal. All right reserved</span
            >
          </div>
          <div class="">
            <ul class="nav d-flex align-items-center">
              <li
                class="txt-small me-4 nav-item position-relative text-color-gray ruleteam"
              >
                គោលការណ៏ឯកជន
              </li>
              <li class="nav-item">
                <RouterLink to="" class="nav-link">
                  <i
                    class="bi bi-facebook"
                    style="color: #106bff !important"
                  ></i>
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink to="" class="nav-link">
                  <i class="bi bi-twitter" style="color: #239ee8"></i>
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink to="" class="nav-link">
                  <i class="bi bi-linkedin" style="color: #1469c7"></i>
                </RouterLink>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>
<script setup>
import { useAuthStore } from "@/stores/authTokenStore";
import router from "@/router";
const authStore = useAuthStore();
const onClickCheckToken = () => {
  authStore.loadToken();
  if (!authStore.token) {
    router.push("/login");
    return;
  }
  router.push("/book-appointment");
};
</script>
