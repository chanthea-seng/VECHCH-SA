    import { defineStore } from "pinia";

    export const patientStore = defineStore('patientinfo', {
        state:() => ({
            
            patient: [
                {id:1,name:'ឈុន​ ស្រួន',gender:'ប្រុស',dob:'04-05-2005',email:'sruonChun@gmail.com',phone:'097 852 7431',create_at: '2025-01-02 11:00PM',is_selected:false},
                {id:2,name:'ឈុន​ ស្រួន',gender:'ប្រុស',dob:'04-05-2005',email:'sruonChun@gmail.com',phone:'097 852 7431',create_at: '2025-01-02 11:00PM',is_selected:false},
                {id:3,name:'ឈុន​ ស្រួន',gender:'ប្រុស',dob:'04-05-2005',email:'sruonChun@gmail.com',phone:'097 852 7431',create_at: '2025-01-02 11:00PM',is_selected:false},
                {id:4,name:'ឈុន​ ស្រួន',gender:'ប្រុស',dob:'04-05-2005',email:'sruonChun@gmail.com',phone:'097 852 7431',create_at: '2025-01-02 11:00PM',is_selected:false},
                {id:5,name:'ឈុន​ ស្រួន',gender:'ប្រុស',dob:'04-05-2005',email:'sruonChun@gmail.com',phone:'097 852 7431',create_at: '2025-01-02 11:00PM',is_selected:false},


            
            ],
            mdl_add_patient:null,

        }),
        actions:{

        }
    })