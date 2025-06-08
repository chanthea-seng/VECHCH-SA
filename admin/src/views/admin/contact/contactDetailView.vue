<template>
  <div class="main">
    <loadingView v-if="pageLoading" />

    <div class="container-fluid bg-grey">
      <div class="row justify-content-between position-relative">
        <div class="sidebar-container position-relative p-0">
          <sideBar class="position-sticky top-0" />
        </div>
        <div class="sidecontent-container pt-3">
          <div class="row">
            <Navhead />
            <hr />
            <div class="contact-detail-container bg-white p-4 rounded-4">
              <div class="section-title mb-3">
                <h5 class="text-color-900">
                  <i class="fa-light fa-envelope-open-text fs-4"></i>
                  User message
                </h5>
              </div>

              <div class="row pb-5">
                <div class="col-9" v-if="detail">
                  <div
                    class="d-flex justify-content-between align-items-center mb-4"
                  >
                    <div class="d-flex column-gap-3 align-items-center">
                      <img
                        :src="detail.user.avatar"
                        class="avatar-control"
                        alt="user-avatar"
                      />
                      <span class="fw-medium">{{ detail.name }}</span>
                    </div>
                    <small>{{ detail.submit_short }}</small>
                  </div>
                  <div class="col-12 pb-5 mb-5">
                    <p>
                      {{ detail.message }}
                      <!-- Helloo! This is my first time writing an message :v. I’m a
                      foreigner and wonder if the hospital is comfortable to
                      examine. For check up service, do I need to bring my
                      passport or any kind of identication with me? I heard many
                      good things from a friend, so give me some discount OwO. -->
                    </p>
                  </div>
                  <hr />
                  <p class="">Reply your heart warm message</p>

                  <div class="textarea-wrapper">
                    <textarea
                      placeholder="Reply..."
                      id="autoTextarea"
                      v-model="useContactStore.contactMessage"
                    ></textarea>
                    <a
                      role="button"
                      @click="useContactStore.onClickSend(detail.id)"
                      class="reply-btn"
                    >
                      <i class="bi bi-reply"></i>
                    </a>
                  </div>
                </div>
                <div class="col-3">
                  <div class="card user-detail border-0 mb-4" v-if="detail">
                    <div
                      class="card-header p-0 mb-1 border-0 bg-transparent d-flex column-gap-3 align-items-center"
                    >
                      <img
                        :src="detail.user.avatar"
                        class="avatar-control"
                        alt=""
                      />
                      <div class="align-content-center">
                        <small>User name</small>
                        <p class="fw-medium">{{ detail.user.fullname }}</p>
                      </div>
                    </div>
                    <div class="card-body bg-transparent p-0">
                      <ul class="list-group fw-medium">
                        <li class="list-group-item d-flex">
                          <label for="" class="w-50">Receive</label
                          ><span class="w-50"> {{ detail.submit_date }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                          <label for="" class="w-50">Agenda</label
                          ><span class="w-50 text-uppercase"
                            >{{ detail.status }}
                          </span>
                        </li>
                        <li class="list-group-item d-flex">
                          <label for="" class="w-50">Email</label
                          ><span class="w-50">{{ detail.email }}</span>
                        </li>
                        <li class="list-group-item d-flex">
                          <label for="" class="w-50">Phone</label
                          ><span class="w-50">{{ detail.phone }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import sideBar from "@/components/layouts/sideBar.vue";
import Navhead from "@/components/layouts/header.vue";
import loadingView from "@/components/loadingView.vue";
import { computed, onMounted, nextTick, ref } from "vue";
import { contactStore } from "@/stores/contactStore";

const useContactStore = contactStore();
const detail = computed(() => useContactStore.contactDetail);

const pageLoading = ref(true);
onMounted(async () => {
  try {
    pageLoading.value = true;

    await useContactStore.getContactDetail();

    nextTick(() => {
      const textarea = document.getElementById("autoTextarea");
      if (textarea) {
        textarea.addEventListener("input", function () {
          this.style.height = "auto";
          this.style.height = this.scrollHeight + "px";
        });
      }
    });
  } catch (error) {
  } finally {
    pageLoading.value = false;
  }
});
</script>
