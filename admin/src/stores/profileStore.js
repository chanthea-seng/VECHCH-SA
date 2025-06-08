import { defineStore } from "pinia";
export const profileStore = defineStore("view/profile", {
    state: () => ({
        username: 'Chan narith',
        email: "channarith@gmail.com",
        role: "admin",
    }),
})