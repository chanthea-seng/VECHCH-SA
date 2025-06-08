import '@/assets/css/style/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import '@/assets/library/font awesome/css/all.css'
import notyf from '@/assets/js/notyf';

import axios from 'axios'

axios.defaults.baseURL = import.meta.env.VITE_API_HOST;
import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(notyf);

app.mount('#app')
