import { createRouter, createWebHistory } from 'vue-router';
import OrderList from '../components/Order/OrderList.vue';
import OrderForm from '../components/Order/OrderForm.vue';
import ProductForm from '../components/Product/ProductForm.vue';
import ProductList from '../components/Product/ProductList.vue';
import UserList from '../components/User/UserList.vue';
import UserForm from '../components/User/UserForm.vue';
import BuyersList from '../components/User/BuyersList.vue';


const routes = [
    {
        path: '/',
        name: 'OrderList',
        component: OrderList
    },
    {
        path: '/create-order',
        name: 'CreateOrder',
        component: OrderForm
    },
    {
        path: '/edit-order/:id',
        name: 'EditOrder',
        component: OrderForm
    },
    {
        path: '/edit-product/:id',
        name: 'EditProduct',
        component: ProductForm
    },
    {
        path: '/edit-user/:id',
        name: 'EditUser',
        component: UserForm
    },
    {
        path: '/create-product',
        name: 'CreateProduct',
        component: ProductForm
    },
    {
        path: '/create-user',
        name: 'CreateUser',
        component: UserForm
    },
    {
        path: '/products',
        name: 'ProductList',
        component: ProductList
    },
    {
        path: '/users',
        name: 'UserList',
        component: UserList
    },
    {
        path: '/buyers',
        name: 'BuyersList',
        component: BuyersList
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
