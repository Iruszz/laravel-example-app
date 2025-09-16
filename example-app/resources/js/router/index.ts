import { createRouter, createWebHistory } from 'vue-router';
import { UsersRoutes } from '../domains/Auth/routes';
import { ExampleRoutes } from '../domains/Example/routes';
import { AdminRoutes } from '../domains/Admin/routes';

export const router = createRouter({
    history: createWebHistory(),
    routes: [{ path: '/', redirect: '/login' }, ...UsersRoutes, ...ExampleRoutes, ...AdminRoutes],
});

router.beforeEach(async (to, from, next) => {
    if (to.name === 'admin.overview') {
        try {
            const res = await fetch('/api/user', { credentials: 'include' });
            const data = await res.json();
            if (data && data.is_admin) {
                next();
            } else {
                next({ name: 'admin.forbidden' });
            }
        } catch (err) {
            next({ name: 'admin.forbidden' });
        }
    } else {
        next();
    }
});