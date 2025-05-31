import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import Orders from '../views/Orders.vue';
import NotFound from '../views/NotFound.vue';
import { useAuth } from '../composables/useAuth';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { requiresAuth: false }
    },
    {
        path: '/',
        name: 'Dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },
    {
        path: '/orders',
        name: 'Orders',
        component: Orders,
        meta: { requiresAuth: true }
    },
    {
        path: '/:catchAll(.*)',
        name: 'NotFound',
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const { isAuthenticated } = useAuth();
    
    if (to.meta.requiresAuth && !isAuthenticated.value) {
        next({ name: 'Login' });
    } else if (to.name === 'Login' && isAuthenticated.value) {
        next({ name: 'Dashboard' });
    } else {
        next();
    }
});

export default router;