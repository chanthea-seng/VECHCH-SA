import './assets/css/style/main.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-icons/font/bootstrap-icons.min.css'
import '@/assets/library/font awesome/css/all.css'
import "vue3-form-wizard/dist/style.css";
import './assets/css/style/chat.css';
// import 'vuetify/styles';


import { createApp} from 'vue'
import { createPinia } from 'pinia'
// import vuetify from './plugins/vuetify';

import App from './App.vue'
import router from './router'
import axios from 'axios';
import setAuthHeader from './stores/setAuthHeader';

axios.defaults.baseURL = import.meta.env.VITE_API_HOST;
// axios.defaults.baseURL =  import.meta.env.VITE_API_HOSTS

const app = createApp(App)

app.use(createPinia())
app.use(router)
// app.use(vuetify);

app.mount('#app')

if (sessionStorage.token) {
	setAuthHeader(sessionStorage.token);
} else {
	setAuthHeader(false);
}



