import { createRouter, createWebHistory } from 'vue-router';
import { UsersRoutes } from '../domains/Users/routes';

export const router = createRouter({
    history: createWebHistory(),
    routes: [{ path: '/', redirect: '/users' }, ...UsersRoutes],
});