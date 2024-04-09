import DashboardPage from "@/pages/manufacturer/DashboardPage.vue";

export default [
    {
        path: '/manufacturer',
        name: 'Dashboard',
        component: DashboardPage,
        meta: {
            requiresAuth: true
        }
    }
];
