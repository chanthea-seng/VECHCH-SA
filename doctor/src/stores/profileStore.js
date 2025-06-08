import { defineStore } from "pinia";
import { ref } from "vue";
import axios from "axios";

export const useProfile = defineStore("viewprofile", {
  state: () => ({
    mdlForm: null,
    country: "",
    university: "",
    degree: "",
    major: "",
    start: "",
    end: "",
    edu: ref([
      {
        id: 1,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
        verified: 1,
      },
      {
        id: 2,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
        verified: 0,
      },
      {
        id: 3,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
        verified: 2,
      },
    ]),
    work: ref([
      {
        id: 1,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
      },
      {
        id: 2,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
      },
      {
        id: 3,
        country: "Cambodia",
        university: "University of Health Sciences ",
        degree: "Bachlor Degree",
        major: "Dentist",
        start: "Feb 2020",
        end: "Oct 2025",
      },
    ]),
  }),
  actions: {
    // async fetchEducations() {
    //   const token = localStorage.getItem("auth_token");
    //   if (!token) {
    //     console.error("No auth token found! Please log in.");
    //     return;
    //   }

    //   try {
    //     const response = await axios.get(
    //       "http://vcs-backend.test/api/doctor/educations",
    //       {
    //         headers: {
    //           Authorization: `Bearer ${token}`,
    //         },
    //       }
    //     );
    //     console.log("API Response:", response.data);
    //     if (Array.isArray(response.data?.data)) {
		// 	this.edu.value = response.data.data;
		// 	console.log("Education data:", this.edu.value[0].institution_name); // Access the first item's institution_name directly
		//   } else {
    //       console.warn("Education data is not an array.");
    //     }
    //   } catch (error) {
    //     console.error("Error fetching education data:", error.response?.data || error);
    //   }
    // },
  },
});
