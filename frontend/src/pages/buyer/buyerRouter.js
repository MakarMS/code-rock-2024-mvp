import ProductsPage from "@/pages/buyer/ProductsPage.vue";


export default [
    {
        path: '/buyer',
        name: 'ProductsBuyer',
        component: ProductsPage,
        meta: {
            authRequired: true
        }
    }
];
