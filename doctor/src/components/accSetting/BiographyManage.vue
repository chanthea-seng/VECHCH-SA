<template>
    <div class="col-9 mt-4">
      <div class="doctor-wrapper-card">
        <div class="d-flex justify-content-between">
          <span class="title">ជីវប្រវត្តិ</span>
          <button class="bio-btn btn m-0" v-if="!isEditing" @click="editBio">
            <i class="fa-light fa-pen"></i>
          </button>
          <div v-if="isEditing" class="d-flex">
            <primaryBtn label="បោះបង់" @click="cancelEdit" />
            <primaryBtn label="រក្សាទុក" class="ms-2" @click="saveBio" />
          </div>
        </div>
        <div v-if="isEditing">
          <form class="w-100 p-0">
            <textarea
              v-model="bioText"
              class="form-control-global"
              rows="5"
              placeholder="បញ្ចូលព័ត៌មានជីវប្រវត្តិរបស់អ្នក"
            ></textarea>
          </form>
        </div>
        <div v-else class="bio-area">
          <span v-if="!bioText">មិនមានព័ត៌មាន</span>
          <span v-else>{{ bioText }}</span>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  import primaryBtn from "../global/primaryBtn.vue";
  import { useAuthStore } from "@/stores/userAuthStore";
  
  const authStore = useAuthStore();
  const bioText = ref("");
  const isEditing = ref(false);
  
  onMounted(async () => {
    await getBioDoctor();
  });
  
  const editBio = () => {
    isEditing.value = true;
  };
  
  const cancelEdit = () => {
    isEditing.value = false;
  };
  
  const saveBio = async () => {
    try {
      await axios.put(
        "/api/doctor/biography",
        { biography: bioText.value },
        { headers: { Authorization: `Bearer ${authStore.token}` } }
      );
      isEditing.value = false;
    } catch (error) {
    //   console.error("Save error:", error);
    }
  };
  
  const getBioDoctor = async () => {
    try {
      const { data } = await axios.get("/api/doctor/biography", {
        headers: { Authorization: `Bearer ${authStore.token}` },
      });
      bioText.value = data.biography || "";
    } catch (error) {
    //   console.error("Fetch error:", error);
    }
  };
  </script>
  