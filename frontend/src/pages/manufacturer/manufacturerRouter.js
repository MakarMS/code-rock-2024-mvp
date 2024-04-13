import DashboardPage from "@/pages/manufacturer/DashboardPage.vue";
import RoutesPage from "@/pages/manufacturer/RoutesPage.vue";
import ProductsPage from "@/pages/manufacturer/ProductsPage.vue";
import PointsPage from "@/pages/manufacturer/PointsPage.vue";

export default [
    {
        path: '/manufacturer',
        name: 'Dashboard',
        component: DashboardPage,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/manufacturer/points',
        name: 'Points',
        component: PointsPage,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/manufacturer/routes',
        name: 'Routes',
        component: RoutesPage,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/manufacturer/products',
        name: 'ProductsManufacturer',
        component: ProductsPage,
        meta: {
            authRequired: true
        }
    }
];
