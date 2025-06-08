    import { defineStore } from "pinia";

    export const historyStore = defineStore('historyStore', {
        state:() => ({
            
            patient: [
                {name:'សុខ ស៊ីណាត',id:1, title: 'សុខ​ ស៊ីណាត' , symptom: 'លើសសម្ពាទឈាម',date:'12 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:2, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:3, title: 'សុខ​ ស៊ីណាត' , symptom: 'លើសhguyទឈាមហដហថុេ៧សដស',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:4, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:5, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:6, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:7, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:8, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:9, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:11, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
                {name:'សុខ ស៊ីណាត',id:12, title: 'សុខ​ ស៊ីណាត' , symptom: 'ឈឺក្បាល មិន..',date:'15 មករា​ 2025',time:'13:00 PM',doctor_name:'សុខ​ ស៊ីណាត'},
            
            ],
            mdl_add_patient:null,
            img:'/src/assets/images/auth/homePage/heart-disease.jpg',

        }),
        actions:{

        }
    })