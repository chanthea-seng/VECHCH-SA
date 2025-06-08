<template>
  <div class="header bg-white">
    <div class="container-fluid p-0">
      <div class="d-flex contact-header first-header align-items-center">
        <div class="container">
          <div
            class="px-0 d-flex align-items-center position-relative justify-content-between"
          >
            <div class="d-flex">
              <div class="d-flex contact align-items-center me-4">
                <i class="bi me-2 bi-telephone"></i>
                +853 16 123 4567
              </div>
              <div class="d-flex contact align-items-center">
                <i class="bi me-2 bi-envelope"></i>
                vechchsal@gmail.com
              </div>
            </div>
            <div>
              <span class="contact"
                ><i
                  style="font-size: 17px"
                  class="fa-light fa-location-dot me-1"
                ></i>
                54 St 606, Phnom Penh</span
              >
            </div>
            <!-- <div class="navbar-nav position-relative">
              <div class="nav-item dropdown">
                <div
                  class="language border-0 d-flex align-items-center dropdown-toggle"
                  style="cursor: pointer"
                  data-bs-toggle="dropdown"
                >
                  <div class="cam-flage">
                    <img
                      src="/src/assets/images/auth/cambodia-flag.jpg"
                      class="img-fluid"
                      alt=""
                    />
                  </div>
                  <span class="ms-2 language-kh"
                    >ខ្មែរ <i class="fa-regular text-white fa-chevron-down"></i>
                  </span>
                </div>
                <ul class="dropdown-menu px-2">
                  <li>
                    <RouterLink to="/" class="dropdown-item py-1">
                      <img
                        src="/src/assets/images/auth/cambodia-flag.jpg"
                        width="26px"
                        class="img-fluid rounded"
                        alt=""
                      />
                      ភាសាខ្មែរ
                    </RouterLink>
                  </li>
                  <li>
                    <RouterLink to="/" class="dropdown-item">
                      <img
                        src="/src/assets/images/auth/cambodia-flag.jpg"
                        width="26px"
                        class="img-fluid rounded"
                        alt=""
                      />
                      ភាសាអង់គ្លេស
                    </RouterLink>
                  </li>
                </ul>
              </div>
            </div> -->
          </div>
        </div>
      </div>

      <nav
        class="navbar navbar-expand-lg d-flex align-items-center bg-white header-bottom"
      >
        <div class="container">
          <RouterLink to="/" class="navbar-brand overflow-hidden">
            <img
              src="/src/assets/images/auth/new.png"
              alt=""
              class="w-100 h-100 object-fit-cover"
            />
          </RouterLink>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasScrolling"
            aria-controls="offcanvasScrolling"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="offcanvas offcanvas-start d-flex flex-lg-row"
            id="offcanvasScrolling"
          >
            <RouterLink
              to="/"
              class="navbar-brand d-lg-none d-block overflow-hidden"
            >
              <img
                src="/src/assets/images/auth/new.png"
                alt=""
                class="w-100 h-100 object-fit-cover"
              />
            </RouterLink>
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
              <li class="nav-item dropdown dhover">
                <a
                  role="button"
                  class="nav-link dropdown-toggle"
                  aria-expanded="false"
                  data-bs-toggle="dropdown"
                >
                  សេវាកម្ម
                  <i class="fa-regular fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu px-2">
                  <li>
                    <a
                      role="button"
                      @click="checkToken"
                      :class="{ active: $route.name == 'bookAppointment' }"
                      class="dropdown-item py-2"
                    >
                      <i class="fa-light fa-hospital icon-nav"></i>
                      ជំនួបពិគ្រោះជំងឺ
                    </a>
                  </li>
                  <li>
                    <RouterLink
                      to="/package"
                      :class="{ active: $route.name == 'package' }"
                      class="dropdown-item py-2"
                    >
                      <i class="fa-regular fa-hand-holding-heart icon-nav"></i>
                      កញ្ចប់ និងតម្លៃពិនិត្យសុខភាព
                    </RouterLink>
                  </li>
                  <li>
                    <RouterLink
                      to="/transportation"
                      class="dropdown-item py-2 mb-0"
                      :class="{ active: $route.name == 'transportation' }"
                    >
                      <i class="fa-light fa-van-shuttle icon-nav"></i>
                      មធ្យោបាយធ្វើដំណើរ
                    </RouterLink>
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown dhover">
                <a
                  role="button"
                  class="nav-link dropdown-toggle"
                  aria-expanded="false"
                  data-bs-toggle="dropdown"
                >
                  អត្ថបទចំណេះដឹង
                  <i class="fa-regular fa-chevron-down"></i>
                </a>
                <ul class="dropdown-menu px-2">
                  <li>
                    <RouterLink
                      to="/findDisease"
                      :class="{ active: $route.name == 'findDisease' }"
                      class="dropdown-item py-2"
                    >
                      <i class="fa-light fa-virus-covid icon-nav"></i>
                      ស្វែងយល់អំពីជំងឺ
                    </RouterLink>
                  </li>
                  <li>
                    <RouterLink
                      to="/article"
                      :class="{ active: $route.name == 'article' }"
                      class="dropdown-item py-2 mb-0"
                    >
                      <i class="fa-light fa-book-medical icon-nav"></i>
                      សុខភាពសាធារណៈ
                    </RouterLink>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <RouterLink
                  to="/finddoctor"
                  class="nav-link"
                  :class="{ 'nav-link active': $route.name == 'finddoctor' }"
                >
                  ស្វែងរកវេជ្ជបណ្ឌិត
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink
                  to="/aboutus"
                  class="nav-link"
                  :class="{ 'nav-link active': $route.name == 'aboutus' }"
                >
                  អំពីយើង
                </RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink
                  to="/contact"
                  class="nav-link"
                  :class="{ 'nav-link active': $route.name == 'contact' }"
                >
                  ទំនាក់ទំនង
                </RouterLink>
              </li>
            </ul>

            <div class="d-flex navbar-nav align-items-center gap-3">
              <div class="dropdown nav-item pf">
                <div class="d-flex navbar-nav align-items-center gap-2">
                  <a
                    v-show="authStore.token"
                    @click="hiddenOffcanvas"
                    role="button"
                    class="headerAction-btn"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample"
                    ><i class="bi fs-4 bi-bell"></i
                  ></a>
                  <RouterLink
                    to="/chat"
                    v-show="authStore.token"
                    class="headerAction-btn"
                    ><i class="bi fs-4 bi-chat-dots"></i
                  ></RouterLink>
                  <div class="dropdown nav-item pf">
                    <div
                      v-show="!authStore.token"
                      class="profile dropdown-toggle"
                      style="cursor: pointer"
                      data-bs-toggle="dropdown"
                    >
                      <img
                        src="@/assets/images/auth/no_photo.jpg"
                        width="30px"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                    </div>
                    <div
                      v-show="authStore.token"
                      class="profile dropdown-toggle"
                      style="cursor: pointer"
                      data-bs-toggle="dropdown"
                    >
                      <img
                        :src="userstore.users.avatar"
                        width="30px"
                        class="w-100 h-100 object-fit-cover"
                        alt=""
                      />
                    </div>

                    <ul class="dropdown-menu px-2" style="margin-left: -180px">
                      <li v-show="authStore.token">
                        <RouterLink
                          to="/account"
                          :class="{ active: $route.name == 'account' }"
                          class="text-decoration-none d-flex pb-2 mb-1"
                          style="border-bottom: 1.4px solid #ededed"
                        >
                          <div class="profile me-2">
                            <img
                              :src="userstore.users.avatar"
                              width="30px"
                              class="w-100 h-100 object-fit-cover"
                              alt=""
                            />
                          </div>
                          <div v-if="authStore.token">
                            <h5 class="mb-0 pb-0 text-color-950">
                              {{ userstore.users.fullname }}
                              <!-- {{ authStore.userData?.user?.fullname }} -->
                            </h5>
                            <span
                              class="fw-medium text-color-950 txt-small email"
                              >{{ userstore.users.email }}</span
                            >
                          </div>
                        </RouterLink>
                      </li>

                      <li v-show="authStore.token">
                        <RouterLink
                          to="/account"
                          :class="{ active: $route.name == 'account' }"
                          class="dropdown-item py-1"
                        >
                          <i class="bi bi-gear me-2 fs-5"></i>
                          គ្រប់គ្រងគណនី
                        </RouterLink>
                      </li>
                      <li v-show="authStore.token">
                        <RouterLink
                          to="/appointment"
                          :class="{ active: $route.name == 'appointment' }"
                          class="dropdown-item py-1"
                        >
                          <i class="bi bi-calendar2-event fs-5 me-2"></i>
                          កាលណាត់ជួប
                        </RouterLink>
                      </li>
                      <li v-show="authStore.token">
                        <RouterLink
                          to="/save"
                          :class="{ active: $route.name == 'save' }"
                          class="dropdown-item py-1"
                        >
                          <i class="bi bi-bookmarks fs-5 me-2"></i>
                          ការរក្សាទុករបស់ខ្ញុំ
                        </RouterLink>
                      </li>

                      <li v-show="!authStore.token">
                        <RouterLink
                          to="/register"
                          :class="{ active: $route.name == 'register' }"
                          class="dropdown-item py-1"
                        >
                          <i class="bi bi-person-add fs-4 me-2"></i>
                          បង្កើតគណនី
                        </RouterLink>
                      </li>

                      <li v-show="!authStore.token">
                        <RouterLink
                          to="/login"
                          :class="{ active: $route.name == 'login' }"
                          class="dropdown-item d-flex align-items-center py-1"
                        >
                          <i class="bi bi-box-arrow-in-right fs-4 me-2"></i>
                          ចូលប្រើប្រាស់
                        </RouterLink>
                      </li>

                      <li v-show="authStore.token">
                        <a
                          @click="onCLickOpenLogout"
                          to="/"
                          :class="{ active: $route.name == 'register' }"
                          class="dropdown-item py-1"
                        >
                          <i class="bi bi-box-arrow-left fs-5 me-2"></i>
                          ចាកចេញ
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div
        style="z-index: -2"
        class="bg-transparent wrap_noti position-relative"
      >
        <div
          class="offcanvas notificate offcanvas-end"
          tabindex="-1"
          id="offcanvasExample"
          aria-labelledby="offcanvasExampleLabel"
        >
          <div
            class="offcanvas-header position-relative pb-0 px-0 d-flex align-items-start flex-column"
          >
            <h5
              class="offcanvas-title text-start text-color-900 px-3 mb-1"
              id="offcanvasExampleLabel"
            >
              ការជូនដំណឹង
            </h5>
            <div
              class="appointment notification-list-group justify-content-center px-3 pt-0 d-flex gap-2"
            >
              <input
                type="radio"
                checked
                name="inotificate"
                value=""
                id="all"
                class="d-none inotificate"
                v-model="notificationstore.filter.type"
                @change="notificationstore.getNotification()"
              />
              <label for="all" class="label-noti px-2 d-flex"
                >ទាំងអស់
                <span class="ms-1" v-if="notificationstore.unread">
                  {{ notificationstore.unread || "" }}
                </span></label
              >

              <input
                type="radio"
                name="inotificate"
                value="0"
                class="d-none inotificate"
                id="date"
                v-model="notificationstore.filter.type"
                @change="notificationstore.getNotification()"
              />
              <label for="date" class="label-noti px-2"
                >បញ្ជាក់ការណាត់ជួប</label
              >

              <input
                type="radio"
                name="inotificate"
                value="1"
                class="d-none inotificate"
                id="prescription"
                v-model="notificationstore.filter.type"
                @change="notificationstore.getNotification()"
              />
              <label for="prescription" class="label-noti px-2"
                >លិខិតវេជ្ជបញ្ជា</label
              >
            </div>
            <div class="border-bottom"></div>
          </div>
          <div class="offcanvas-body p-0">
            <ul class="list-group" v-if="notificationstore.notification">
              <li
                v-for="notification in notificationstore.notification"
                :key="notification.id"
                class="list-group-item rounded-0"
                :class="notification.is_read == 0 ? 'read-not' : 'bg-white'"
              >
                <a
                  role="button"
                  @click="onClickDetail(notification)"
                  class="text-decoration-none"
                >
                  <div class="d-flex column-gap-2">
                    <div
                      class="rounded-circle px-2 overflow-hidden align-content-center"
                      :class="
                        notification.is_read == 0
                          ? 'icon-read-not'
                          : 'bg-color-700'
                      "
                      style="width: 45px; height: 45px"
                    >
                      <img
                        :src="
                          notification.is_read == 0
                            ? './../assets/images/auth/logo_green.png'
                            : './../assets/images/auth/logo_white.png'
                        "
                        class="img-fluid"
                        alt=""
                      />
                    </div>
                    <div class="col-10">
                      <p class="mb-0">
                        <span v-if="notification.type == 0">
                          {{ notification.title }}
                          អ្នកត្រូវបានកំណត់ការ ណាត់ជាមួយលោកវេជ្ជបណ្ឌិត
                          <span class="fw-semibold">
                            {{ notification.book?.doctor?.local_fullname }}
                          </span>
                        </span>
                        <span v-else> {{ notification.message }} </span>
                      </p>
                      <span style="font-size: 13px">{{
                        notification.created_at
                      }}</span>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
            <p v-else class="text-center fw-medium text-color-800 mt-4">
              គ្មានការជូនដំណឹង <i class="fa-light fa-bell"></i>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- modal log out  -->

  <div
    class="modal mdl-logout fade"
    id="mdl-confirm-logout"
    tabindex="-1"
    aria-labelledby="mdl-confirm-logoutLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div
          class="modal-header d-flex text-center border-0 pt-4 px-4 pb-0"
        ></div>
        <div class="modal-body mt-0 p-4 pt-0">
          <div class="wrapper text-center my-3">
            <p class="mb-1 text-center fw-medium text-color-1000 fs-5">
              <!-- តើអ្នកប្រាកដថា​ ចង់ចាកចេញគណនីរបស់អ្នកមែនទេ? -->
              ចង់ចាកចេញគណនី
            </p>
            <!-- <span
              >ប្រសិនបើអ្នកចង់លុបគណនីរបស់អ្នក ទិន្នន័យ
              ព័ត៌មានទាំងអស់របស់អ្នកនិងត្រូវលុបជាអចិន្ត្រៃយ៌</span
            > -->
            <span class="fs-6">
              តើអ្នកប្រាកដថា​ ចង់ចាកចេញគណនីរបស់អ្នកមែនទេ?
            </span>
          </div>
          <div class="mx-auto text-center">
            <a
              role="button"
              class="btn-bg-650 btn-delete mb-0 mt-0 me-3"
              data-bs-dismiss="modal"
              >បោះបង់</a
            >
            <a
              role="button"
              @click="onClickLogout()"
              class="btn-bg-650 btn-logout mb-0 px-3"
            >
              ចាកចេញ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    style="width: 1000px; z-index: -2"
    class="bg-transparent wrap_noti position-relative"
    c
  >
    <div
      class="offcanvas offcanvas-end"
      id="offcanvasExample"
      aria-labelledby="offcanvasExampleLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExample">
          Backdrop with scrolling
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body p-0">
        <h5>ការជូនដំណឹង</h5>
        <div class="">
          <!--  input radio -->
          <div class="d-flex gap-5">
            <input type="radio" name="" class="d-none" id="all" />
            <label for="all">ពិគ្រោះប្រឹក្សា</label>

            <input type="radio" name="" class="d-none" id="date" />
            <label for="date">ពិនិត្យសុខភាព</label>

            <input type="radio" name="" class="d-none" id="prescription" />
            <label for="prescription">វ៉ាក់សាំង</label>
          </div>
          <label for="">
            <ul class="list-group">
              <li
                v-for="notification in notificationstore.notification"
                :key="notification.id"
                class="list-group-item"
              >
                <a role="button" class="text-decoration-none">
                  <div class="d-flex">
                    <div class="col me-3">
                      <div
                        class="col rounded-circle d-flex justify-content-center align-items-center overflow-hidden p-3 icon-read-not"
                        style="width: 40px; height: 40px"
                      >
                        <img
                          src="/src/assets/images/auth/homePage/bone_prob2.jpg"
                          alt="vcs-logo"
                          class="img-fluid"
                        />
                      </div>
                    </div>
                    <div>
                      <p class="mb-0 limit-line-2">
                        {{ notification.short_desc }}
                      </p>
                      <span style="font-size: 13px">{{
                        notification.time
                      }}</span>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </label>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {
  computed,
  onMounted,
  onUnmounted,
  reactive,
  ref,
  registerRuntimeCompiler,
} from "vue";
import { Offcanvas } from "bootstrap";
import { notificationStore } from "@/stores/storenotification";
import { useAuthStore } from "@/stores/authTokenStore";
import router from "@/router";
import { userStore } from "@/stores/userStore";
import { Modal } from "bootstrap";
import axios from "axios";
import { medicalRecordStore } from "@/stores/medicalRecordStore";
const notificationstore = notificationStore();
const hiddenOffcanvas = () => {
  document.getElementById("body-wrapper").style.padding = 0;
  document.getElementById("body-wrapper").style.overflow = "auto";
};

const selectedTab = computed(() => notificationstore.filter.type);

const authStore = useAuthStore();
const userstore = userStore();
const useMedicalRecord = medicalRecordStore();
const onClickDetail = async (obj) => {
  if (obj.is_read == 0) {
    await notificationstore.onClickRead(obj.id);
  }
  switch (obj.type) {
    case 0:
      router.push("/appointment");
      break;
    case 1:
      useMedicalRecord.getMedicalrecordDetailId(obj.book.id);
      break;

    default:
      break;
  }
};

onMounted(async () => {
  let lastScrollPosition = 0;
  const headerTop = document.querySelector(".first-header");
  const headerBottom = document.querySelector(".header-bottom");
  const notificate = document.querySelector(".notificate");

  if (!headerTop || !headerBottom) return;

  headerBottom.style.transform = "translateY(45.31px)";
  notificate.style.transform = "translateY(110px)";

  const handleScroll = () => {
    const currentScrollPosition = window.scrollY;

    if (currentScrollPosition > lastScrollPosition) {
      headerTop.style.transform = "translateY(-100%)";
      headerBottom.style.transform = "translateY(0%)";
      notificate.style.transform = "translateY(64.69px)";
      // notificate.style.marginTop = "64.69px";
    } else {
      headerTop.style.transform = "translateY(0)";
      headerBottom.style.transform = "translateY(45.31px)";
      notificate.style.transform = "translateY(110px)";
      // notificate.style.marginTop = "110px";
    }

    lastScrollPosition = currentScrollPosition;
  };
  // =========================================
  //   notificationstore.getNotification();
  // notificationstore.listenToNotifications();
  //   console.log(notificationstore.notification.notifications)
  // =========================================

  // notificationStore.addNotification({
  //   id: 6,
  //   short_desc: "New notification from WebSocket",
  //   time: "Just now",
  // });

  window.addEventListener("scroll", handleScroll);

  // Cleanup the event listener when the component is unmounted
  onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
  });
  // await userstore.onLoadData();
  // await authStore.loadToken();
  // if (authStore.token) {
  // Only load user data if token exists
  // await authStore.loadData();
  // }
  // userstore.users;
  authStore.loadToken();
  if (authStore.token) {
    await userstore.onLoadData();
    notificationstore.getNotification();
  }
});

// onMounted(async () => {
//   await userstore.onLoadData();
//   await authStore.loadToken();
//   if (authStore.token) { // Only load user data if token exists
//     await userstore.onLoadData();
//   }
//   console.log();
//   (userstore.users);

// });

const checkToken = async () => {
  await authStore.loadToken();
  if (!authStore.token) {
    // alert(authStore.token);
    router.push("/login");
  } else {
    // alert(authStore.token);
    router.push("/book-appointment");
  }
};

// let token = authStore.loadToken.token;

const onCLickOpenLogout = () => {
  Modal.getOrCreateInstance(
    document.getElementById("mdl-confirm-logout")
  ).show();
  document.getElementById("body-wrapper").style.padding = 0;
  document.getElementById("body-wrapper").style.overflow = "auto";
};
const onClickLogout = async () => {
  try {
    authStore.loadToken();
    if (authStore.token) {
      const res = await axios.post(
        `/api/auth/logout`,
        {}, // No request body
        {
          headers: {
            Authorization: "Bearer " + authStore.token,
          },
        }
      );

      authStore.clearToken();
      Modal.getOrCreateInstance(
        document.getElementById("mdl-confirm-logout")
      ).hide();
      router.push("/");
    }
  } catch (error) {
    console.error("Logout error", error);
  }
};
</script>
