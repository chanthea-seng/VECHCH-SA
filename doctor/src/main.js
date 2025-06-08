import './assets/css/style/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import '@/assets/js/globalScript'
import '@/assets/library/font awesome/css/all.css'
import { createApp } from 'vue'
import { createPinia } from 'pinia'

import axios from 'axios'
import App from './App.vue'
import router from './router'
// import echo from './lib/echo'
axios.defaults.baseURL = import.meta.env.VITE_API_HOST
const app = createApp(App)
// app.config.globalProperties.$echo = echo;
app.use(createPinia())
app.use(router)

app.mount('#app')
