import {createApp, watchEffect} from 'vue';
import App from './App.vue';
import router from './router.js';
import Toast, {POSITION} from 'vue-toastification';
import './style.css';
import 'vue-toastification/dist/index.css';
import en from './locales/en.json';
import ru from './locales/ru.json';
import {createI18n} from 'vue-i18n';
import instance from './axios.js';
import VueAwesomePaginate from "vue-awesome-paginate";
import 'vue-awesome-paginate/dist/style.css';

const i18n = createI18n({
    locale: localStorage.getItem('locale') || 'en',
    fallbackLocale: 'en',
    messages: {'en': en, 'ru': ru},
    legacy: false
});

watchEffect(() => {
    localStorage.setItem('locale', i18n.global.locale.value);
});

const app = createApp(App);
app.config.globalProperties.$http = instance;

app.use(router);
app.use(i18n);
app.use(VueAwesomePaginate);
app.use(Toast, {
    position: POSITION.BOTTOM_RIGHT
});

app.mount('#app');
