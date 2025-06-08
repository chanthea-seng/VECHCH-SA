import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const setting = defineStore("setting", {
  state: () => ({
    doctors: [],
    doctor: null,
  }),
  actions: {
    async getDoctors() {
      try {
        const res = await axios.get(`/api/auth/me`);
        this.doctors = res.data.data;
        if (this.doctors.length > 0) {
          this.doctor = this.doctors[0];
        }
      } catch (error) {
        // console.error("Error fetching doctors:", error);
      }
    },
  },
});
