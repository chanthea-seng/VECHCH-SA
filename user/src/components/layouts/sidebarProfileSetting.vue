<template>
  <main class="sidebar setting">
    <div
      class="py-2 wrapper bg-white d-flex flex-column align-content-between border-radius"
      style="height: 500px"
    >
      <ul class="nav flex-column mb-auto overflow-hidden">
        <div class="m-4 mt-3 mb-2 fw-medium text-color-800">
          <i class="bi bi-person"></i>
          គណនី
        </div>
        <li class="nav-item">
          <div class="text-decoration-none ps-4 d-flex">
            <div
              class="me-3 overflow-hidden rounded-circle"
              style="width: 42px; height: 42px"
            >
              <img
                :src="
                  userstore.users.avatar
                    ? userstore.users.avatar
                    : '/src/assets/images/auth/no_photo.jpg'
                "
                class="w-100 h-100 object-fit-cover"
                alt=""
              />
              <!-- :src="userstore.users.avatar ? userstore.users.avatar : '/src/assets/images/auth/no_photo.jpg'" -->
            </div>
            <div>
              <h5 class="mb-0 text-color-950" style="font-size: 17px">
                {{ userstore.users.fullname }}
              </h5>
              <span class="text-color-950 fw-medium" style="font-size: 13px">{{
                userstore.users.email
              }}</span>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <RouterLink
            to="/account"
            class="nav-link"
            :class="{ active: $route.name === 'account' }"
          >
            <i
              :class="
                $route.name === 'account'
                  ? 'fa-duotone fa-light fa-house'
                  : 'fa-light fa-house'
              "
            ></i>
            ផ្ទាំងគណនី
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink
            to="/profilesetting"
            class="nav-link"
            :class="{ active: $route.name === 'profilesetting' }"
          >
            <i
              :class="
                $route.name === 'profilesetting'
                  ? ' fa-solid fa-gear'
                  : 'fa-light fa-gear'
              "
            ></i>
            គ្រប់គ្រងគណនី
          </RouterLink>
        </li>
        <!-- <li class=" nav-item">
                    <RouterLink to="/patientinfo" class="nav-link" :class="{'active' : $route.name === 'patientinfo'}">
                        <i :class="$route.name === 'patientinfo'? 'bi bi-people-fill': 'bi bi-people'"></i>
                        ព័ត៌មានអ្នកជំងឺផ្សេងៗ
                    </RouterLink>
                </li> -->
        <li class="nav-item">
          <RouterLink
            to="/appointment"
            class="nav-link"
            :class="{ active: $route.name === 'appointment' }"
          >
            <i
              :class="
                $route.name === 'appointment'
                  ? 'bi bi-calendar2-range-fill'
                  : 'bi bi-calendar2-range'
              "
            ></i>
            កាលណាត់ជួប
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink
            to="/medical-record-setting"
            class="nav-link"
            :class="{ active: $route.name === 'medicalRecordSetting' }"
          >
            <i
              :class="
                $route.name === 'medical-record-setting'
                  ? 'fa-duotone fa-light fa-file-waveform'
                  : 'fa-light fa-file-waveform'
              "
            ></i>
            ក្រដាសវេជ្ជបញ្ជា
          </RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink
            to="/save"
            class="nav-link"
            :class="{ active: $route.name === 'save' }"
          >
            <i class="bi bi-bookmarks-fill"></i>
            ការរក្សាទុករបស់ខ្ញុំ
          </RouterLink>
        </li>
      </ul>
      <div class="m-2">
        <a role="button" @click="onCLickOpenLogout" class="nav-link log-out">
          <i class="bi bi-box-arrow-left"></i>
          ចាក់ចេញ
        </a>
      </div>
    </div>
    <!-- modal logout -->
    <div
      class="modal mdl-logout fade"
      id="mdl-confirm-logout"
      tabindex="-1"
      aria-labelledby="mdl-confirm-logoutLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header border-0 pt-4 px-4 pb-0">
            <div>
              <h5
                class="modal-title text-color-950 fs-5 mb-0 pb-0"
                id="mdl-confirm-logoutLabel"
              >
                លុបគណនី
              </h5>
            </div>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body mt-0 p-4 pt-0">
            <div class="wrapper my-3">
              <p class="mb-1 fw-medium text-color-1000">
                តើអ្នកប្រាកដថា​ ចង់លុបគណនីរបស់អ្នកមែនទេ?
              </p>
              <span
                >ប្រសិនបើអ្នកចង់លុបគណនីរបស់អ្នក ទិន្នន័យ
                ព័ត៌មានទាំងអស់របស់អ្នកនិងត្រូវលុបជាអចិន្ត្រៃយ៌</span
              >
            </div>
            <div class="">
              <a
                role="button"
                @click="onCLicklogout"
                class="btn-bg-650 btn-logout mb-0 px-3"
              >
                <i class="fa-solid fa-trash"></i> លុបគណនី</a
              >
              <!-- <a role="button" class="btn-bg-650 btn-danger  mb-0  "><i class="fa-duotone fa-solid fa-trash"></i> លុបគណនី</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import { Modal } from "bootstrap";
import { userStore } from "@/stores/userStore";
import { useAuthStore } from "@/stores/authTokenStore";
import { onMounted } from "vue";
import router from "@/router";
const userstore = userStore();
const authStore = useAuthStore();

onMounted(async () => {
  await authStore.loadToken();
  if (!authStore.token) {
    router.push("/");
  }
  await userstore.onLoadData();
  userstore.userfrm.fullname = userstore.users.fullname;
  userstore.userfrm.email = userstore.users.email;
  userstore.avatar.url = userstore.users.avatar;
});

const onCLickOpenLogout = () => {
  Modal.getOrCreateInstance(
    document.getElementById("mdl-confirm-logout")
  ).show();
};
const onCLicklogout = () => {
  authStore.clearToken();
  Modal.getOrCreateInstance(
    document.getElementById("mdl-confirm-logout")
  ).hide();
  router.push("/");
};
</script>
