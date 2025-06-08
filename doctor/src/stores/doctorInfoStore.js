import { defineStore } from "pinia";
import axios from "axios";

export const doctorInfoStore = defineStore('doctorInfoStore', {
    state: () => ({
        frm:{
            kmName: '',
            engName: '',
            email: '',
            phone: '',
            gender: '',
            speciality: '',
            department: '',
            office: '',
        },
        bio_collapse: null,
        biography: {

        },
        action:{

        }
    })
})