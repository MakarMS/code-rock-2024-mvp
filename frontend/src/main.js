import {createApp, watchEffect} from 'vue';

import App from './App.vue';
import router from './router.js';
import Toast, {POSITION} from 'vue-toastification';
import axios from 'axios';

import './style.css';
import 'vue-toastification/dist/index.css';

import en from './locales/en.json';
import ru from './locales/ru.json';
import {createI18n} from 'vue-i18n';

const i18n = createI18n({
    locale: localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages: {'en': en, 'ru': ru},
    legacy: false
})

watchEffect(() => {
    localStorage.setItem('locale', i18n.global.locale.value);
});

const app = createApp(App);
app.config.globalProperties.$apiDomain = 'http://api.localhost';
axios.defaults.baseURL = app.config.globalProperties.$apiDomain;

app.use(router);
app.use(i18n);
app.use(Toast, {
    position: POSITION.BOTTOM_RIGHT
});

app.config.globalProperties.$http = axios;

app.mount('#app');
