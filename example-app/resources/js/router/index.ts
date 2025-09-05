import { createRouter, createWebHistory } from 'vue-router';
import { UsersRoutes } from '../domains/Auth/routes';
import { ExampleRoutes } from '../domains/Example/routes';

export const router = createRouter({
    history: createWebHistory(),
    routes: [{ path: '/', redirect: '/login' }, ...UsersRoutes, ...ExampleRoutes],
});