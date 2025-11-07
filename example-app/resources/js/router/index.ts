// resources/js/router/index.ts
import { createRouter, createWebHistory, type NavigationGuard, type LocationQueryRaw, RouteRecordRaw, RouteLocationRaw, RouteLocationNormalized } from 'vue-router';
import { AuthRoutes } from '../domains/Auth/routes';
import { TicketRoutes } from '../domains/Tickets/routes';
import { AgentRoutes } from '../domains/Agents/routes';
import { CommentRoutes } from '../domains/Comments/routes';
import { CategoryRoutes } from '../domains/Categories/routes';
import ForbiddenPage from '../services/components/ForbiddenPage.vue';
import { getLoggedInUser, isLoggedIn } from '../domains/Auth/store';
import { UsersRoutes } from '../domains/Users/routes';

// --- Router instance ---
export const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', redirect: '/login', name: 'root' },
        ...AuthRoutes,
        ...UsersRoutes,
        ...TicketRoutes,
        ...AgentRoutes,
        ...CommentRoutes,
        ...CategoryRoutes,
        { path: '/forbidden', component: ForbiddenPage, name: 'forbidden' },
    ],
});

export const addRoutes = (routes: RouteRecordRaw[]) => {
    for (const route of routes) router.addRoute(route);
};

// --- Helper functions ---
export const goToRoute = (name: string, id?: number, query?: LocationQueryRaw) => {
    if (onPage(name) && !query && !id) return;
    router.push(createRoute(name, id, query));
};

export const goToOverviewPage = (domainName: string) => {
    router.push({ name: domainName });
};

const createRoute = (name: string, id?: number, query?: LocationQueryRaw) => {
    const route: RouteLocationRaw = {name};
    if (id) route.params = {id};
    if (query) route.query = query;
    return route;
};


// Middleware
const beforeRouteMiddleware: Array<
    (to: RouteLocationNormalized, from: RouteLocationNormalized) => boolean | RouteLocationRaw | undefined
> = [
    (to, from) => {
        const fromQuery = from.query.from;
        if (fromQuery && typeof fromQuery === 'string') {
            if (fromQuery === to.fullPath) return false; // cancel navigation
            return { path: fromQuery }; // redirect properly
        }
        return undefined; //
    },
];

// Global guard
router.beforeEach((to, from) => {
    for (const middlewareFunc of beforeRouteMiddleware) {
        const result = middlewareFunc(to, from);
        if (result) return result; // redirect or cancel
    }
    return true; // allow navigation
});

/** checks if the given string is in the current routes name */
const onPage = (pageName: string) => router.currentRoute.value.name?.toString().includes(pageName);

/** go back one page */
export const goBack = () => router.back();
