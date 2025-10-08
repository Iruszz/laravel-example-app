import { createApp } from "vue";
import App from "./App.vue";
import { router } from './router';
import { axiosInstance } from './services/http';
import { initFlowbite } from "flowbite";

const app = createApp(App);

axiosInstance.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      router.push({ name: 'login.overview' });
    }
    return Promise.reject(error);
  }
);

app.use(router);
app.mount('#app');
