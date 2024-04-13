import RoutesPage from "@/pages/manufacturer/RoutesPage.vue";
import ProductsPage from "@/pages/manufacturer/ProductsPage.vue";
import PointsPage from "@/pages/manufacturer/PointsPage.vue";
import OrdersPage from "@/pages/manufacturer/OrdersPage.vue";

export default [
    {
        path: '/manufacturer',
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
    },
    {
        path: '/manufacturer/orders',
        name: 'OrdersManufacturer',
        component: OrdersPage,
        meta: {
            authRequired: true
        }
    }
];
