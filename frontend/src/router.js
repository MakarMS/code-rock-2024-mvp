import { createRouter, createWebHistory } from 'vue-router';
import { ref } from 'vue';
import landingRouter from "@/pages/landing/landingRouter.js";
import manufacturerRouter from "@/pages/manufacturer/manufacturerRouter.js";
import axios from "@/axios.js";

const isAuthenticated = ref(false); // Переменная для хранения состояния аутентификации

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        ...landingRouter,
        ...manufacturerRouter
    ]
});

router.beforeEach(async (to, from, next) => {
    try {
        if (to.meta.requiresAuth) {
            const response = await axios.post(`/api/user/auth/${localStorage.getItem('account_type') || 'buyer'}/valid`);
            isAuthenticated.value = response.data.status;
        }
    } catch (error) {
        isAuthenticated.value = false;
    }

    if (!to.meta.requiresAuth || isAuthenticated.value) {
        next();
    } else {
        next({
            path: '/'
        });
    }
});

export default router;
