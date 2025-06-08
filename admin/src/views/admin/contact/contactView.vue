<template>
  <div class="main">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>
        <div class="sidecontent-container pt-3 position-relative">
          <div
            class="overlay-card py-2 px-4 fs-6"
            :class="{ 'd-block': !!selectedUsers.length }"
          >
            <div class="d-flex justify-content-between align-items-center">
              <span>{{ selectedUsers.length }} selected</span>
              <a role="button" @click="openModal()">
                <span>Delete <i class="bi bi-trash"></i></span>
              </a>
              <a role="button" @click="onClickClear()">
                <span class="fs-4"><i class="bi bi-x"></i></span>
              </a>
            </div>
          </div>
          <div class="row">
            <Navhead />
            <hr />
            <!-- <div class="col-9 p-0 pe-4 mb-4">
              <div class="p-4 rounded-4 bg-white">
                <div>
                  <h5 class="text-gradient">contact from user</h5>
                  <span>Recently received</span>
                </div>
                <table class="contact-table">
                  <tbody>
                    <tr v-for="user in subContacts" :key="user.id">
                      <td style="width: 55%" class="pe-3">
                        <div class="d-flex column-gap-3 align-items-center">
                          <img :src="user.avatar" class="avatar-image" alt="" />
                          <div class="row g-0 align-items-center">
                            <div class="">
                              <span class="text-color-950 fw-medium">{{
                                user.name
                              }}</span>
                              <i class="bi bi-dot"></i>
                              <small>{{ user.date }}</small>
                            </div>
                            <p class="limit-line-1 m-0">{{ user.message }}</p>
                          </div>
                        </div>
                      </td>
                      <td
                        class="text-color-900 fw-medium text-center"
                        style="width: 15%"
                      >
                        <span>{{ user.agenda == 1 ? "QA" : "Feedback" }}</span>
                      </td>
                      <td style="width: 25%">{{ user.date }}</td>
                      <td>
                        <a
                          role="button"
                          class="reply-btn"
                          @click="useContactStore.onClickDetail(user.id)"
                        >
                          <i class="bi bi-reply"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-3 p-0">
              <div class="card contact-card p-3">
                <h5 class="text-color-800 mb-3">Contact From User</h5>
                <div class="card-body p-0 bg-transparent border-0">
                  <ul class="list-group row-gap-4">
                    <li
                      class="list-group-item"
                      v-for="user in useContactStore.contact"
                      :key="user.id"
                    >
                      <div
                        class="d-flex column-gap-3 align-item-center position-relative"
                      >
                        <img :src="user.avatar" alt="" class="avatar-control" />
                        <div class="position-relative">
                          <a
                            role="button"
                            class="reply-btn"
                            @click="
                              useContactStore.useContactStore.onClickDetail(
                                user.id
                              d)
                            "
                          >
                            <i class="bi bi-reply"></i>
                          </a>
                          <div class="d-flex align-items-center">
                            <h6 class="m-0">{{ user.name }}</h6>
                            <i class="bi bi-dot text-grey-small"></i>
                            <small class="text-grey">{{ user.date }}</small>
                          </div>
                          <small class="limit-line-1">
                            {{ user.message }}
                          </small>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div> -->
            <div class="contact-container bg-white p-4 rounded-4">
              <div class="section-title mb-4">
                <h5 class="text-color-900">
                  <i class="fa-light fa-envelope-open-text fs-4"></i> Contact
                  from user
                </h5>
              </div>
              <div>
                <div class="d-flex column-gap-3 align-item-center">
                  <input
                    type="search"
                    class="search-input"
                    placeholder="Search..."
                    v-model="useContactStore.filter.search"
                    @input="useContactStore.getContact()"
                  />
                </div>

                <table class="contact-table">
                  <thead>
                    <tr>
                      <th></th>
                      <th>User</th>
                      <th>Agenda</th>
                      <th>date</th>
                      <th>action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in contacts" :key="user.id">
                      <td>
                        <input
                          class="cus-checkbox"
                          type="checkbox"
                          v-model="selectedUsers"
                          :value="user.id"
                        />
                      </td>
                      <td>
                        <div class="d-flex column-gap-3 align-items-center">
                          <img :src="user.avatar" class="avatar-image" alt="" />
                          <div class="row g-0 align-items-center">
                            <div class="">
                              <span class="text-color-950 fw-medium">{{
                                user.name
                              }}</span>
                              <i class="bi bi-dot"></i>
                              <small>{{ user.submit_date }}</small>
                            </div>
                            <p class="limit-line-1 m-0">{{ user.message }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-color-900 fw-medium">
                        <span>{{ user.agenda == 1 ? "QA" : "Feedback" }}</span>
                      </td>
                      <td>{{ user.submit_short }}</td>
                      <td>
                        <button
                          @click="useContactStore.onClickDetail(user.id)"
                          :class="
                            user.status == 1 ? 'replied-btn' : 'pending-btn'
                          "
                        >
                          <span>
                            {{ user.status == 1 ? "replied" : "pending" }}
                          </span>
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

  <mdlConfirm
    ref="modalRef"
    message="Reminder? Are you sure to delete articles!"
    @confirm="confirmDelete"
  />
</template>

<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import loadingView from "@/components/loadingView.vue";
import Navhead from "@/components/layouts/header.vue";
import mdlConfirm from "@/components/layouts/mdlConfirm.vue";
import axios from "axios";
import { useNotyfStore } from "@/stores/notyfStore";
import { contactStore } from "@/stores/contactStore";
import { useAuthStore } from "@/stores/userAuthStore";
import { computed, onMounted, ref } from "vue";
import MicroPlugin from "tom-select/dist/cjs/contrib/microplugin";

const authStore = useAuthStore();
const notfy = useNotyfStore();
const useContactStore = contactStore();
const selectedUsers = ref([]);
const contacts = computed(() => useContactStore.contacts);

const onClickClear = () => {
  selectedUsers.value = [];
};
const modalRef = ref(null);
const openModal = () => {
  modalRef.value.openModal();
};
const confirmDelete = async () => {
  try {
    const frmData = new FormData();
    frmData.append("contact_ids", JSON.stringify(selectedUsers.value));
    authStore.loadToken();
    const res = await axios.request({
      url: "/api/contacts",
      method: "DELETE",
      data: frmData,
      headers: {
        Authorization: `Bearer ${authStore.token}`,
        "Content-Type": "application/json",
      },
    });
    onClickClear();
    selectedUsers.value = [];
    notfy.success("Delete Success");
    await useContactStore.getContact();
  } catch (error) {
    console.log(error);
    notfy.warning("Fail to delete!");
  }
};

const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;
    useContactStore.filter.per_page = 10;
    await useContactStore.getContact();
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
