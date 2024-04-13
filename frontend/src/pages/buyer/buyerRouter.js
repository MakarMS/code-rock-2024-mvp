import ProductsPage from "@/pages/buyer/ProductsPage.vue";
import OrdersPage from "@/pages/buyer/OrdersPage.vue";


export default [
    {
        path: '/buyer',
        name: 'ProductsBuyer',
        component: ProductsPage,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/buyer/orders',
        name: 'OrdersPage',
        component: OrdersPage,
        meta: {
            authRequired: true
        }
    }
];
