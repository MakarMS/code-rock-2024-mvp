import DashboardPage from "@/pages/manufacturer/DashboardPage.vue";
import RoutesPage from "@/pages/manufacturer/RoutesPage.vue";
import ProductsPage from "@/pages/manufacturer/ProductsPage.vue";
import StatisticsPage from "@/pages/manufacturer/StatisticsPage.vue";

export default [
    {
        path: '/manufacturer',
        name: 'Dashboard',
        component: DashboardPage,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/manufacturer/routes',
        name: 'Routes',
        component: RoutesPage,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/manufacturer/products',
        name: 'Products',
        component: ProductsPage,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/manufacturer/statistics',
        name: 'Statistics',
        component: StatisticsPage,
        meta: {
            requiresAuth: true
        }
    }
];
