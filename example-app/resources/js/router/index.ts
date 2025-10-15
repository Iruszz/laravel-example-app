import { createRouter, createWebHistory } from 'vue-router';
import { UsersRoutes } from '../domains/Auth/routes';
import { TicketRoutes } from '../domains/Tickets/routes';
import { AgentRoutes } from '../domains/Agents/routes';
import { CommentRoutes } from '../domains/Comments/routes';

export const router = createRouter({
    history: createWebHistory(),
    routes: [{ path: '/', redirect: '/login' }, ...UsersRoutes, ...TicketRoutes, ...AgentRoutes, ...CommentRoutes],
});

router.beforeEach(async (to, from, next) => {
    if (to.name === 'agent.overview') {
        try {
            const res = await fetch('/api/user', { credentials: 'include' });
            const data = await res.json();
            if (data && data.is_admin) {
                next();
            } else {
                next({ name: 'agent.forbidden' });
            }
        } catch (err) {
            next({ name: 'agent.forbidden' });
        }
    } else {
        next();
    }
});