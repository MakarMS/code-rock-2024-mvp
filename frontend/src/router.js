import {createRouter, createWebHistory} from 'vue-router';
import {ref} from 'vue';
import landingRouter from "@/pages/landing/landingRouter.js";
import manufacturerRouter from "@/pages/manufacturer/manufacturerRouter.js";
import buyerRouter from "@/pages/buyer/buyerRouter.js";
import axios from "@/axios.js";

const isAuthenticated = ref(false); // Переменная для хранения состояния аутентификации

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        ...landingRouter,
        ...buyerRouter,
        ...manufacturerRouter,
    ]
});

router.beforeEach(async (to, from, next) => {
    if (!localStorage.getItem('account_type')) {
        localStorage.setItem('account_type', 'manufacturer');
    }

    try {
        if (to.meta.authRequired) {
            const response = await axios.post(`/api/user/auth/${localStorage.getItem('account_type') || 'buyer'}/valid`);
            isAuthenticated.value = response.data.status;
        }
    } catch (error) {
        isAuthenticated.value = false;
    }

    if (!isAuthenticated.value) {
        const responseRefreshToken = await axios.post(`/api/user/auth/${localStorage.getItem('account_type')}/refresh`);

        if (responseRefreshToken.data.status !== false) {
            const {jwt_token} = responseRefreshToken.data;
            localStorage.setItem('jwt_token', jwt_token);

            const response = await axios.post(`/api/user/auth/${localStorage.getItem('account_type') || 'buyer'}/valid`);
            isAuthenticated.value = response.data.status;
        }
    }

    if (!to.meta.authRequired || isAuthenticated.value) {
        next();
    } else {
        next({
            path: '/'
        });
    }
});

export default router;
