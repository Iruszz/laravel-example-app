import { createRouter, createWebHistory } from 'vue-router';
import { UsersRoutes } from '../domains/Auth/routes';
import { TicketRoutes } from '../domains/Tickets/routes';
import { AgentRoutes } from '../domains/Agents/routes';
import { CommentRoutes } from '../domains/Comments/routes';
import { CategoryRoutes } from '../domains/Categories/routes';
import ForbiddenPage from '../services/components/ForbiddenPage.vue';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', redirect: '/login' },
        ...UsersRoutes,
        ...TicketRoutes,
        ...AgentRoutes,
        ...CommentRoutes,
        ...CategoryRoutes,
        
        // Global page
        { path: '/forbidden', component: ForbiddenPage, name: 'forbidden' },
    ],
});

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAdmin) {
        try {
            const res = await fetch('/api/me', { credentials: 'include' });
            const data = await res.json();
            if (data?.is_admin) next();
            else next({ name: 'forbidden' });
        } catch (err) {
            next({ name: 'forbidden' });
        }
    } else {
        next();
    }
});