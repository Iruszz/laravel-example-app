import Create from "./pages/Create.vue";
import Edit from "./pages/Edit.vue";
import Overview from "./pages/Overview.vue";
import Show from "./pages/Show.vue";

export const CategoryRoutes =  [
    { path: '/categories', component: Overview, name: 'categories.overview', meta: { requiresAdmin: true } },
    { path: '/categories/:category', component: Show, name: 'category.show', meta: { requiresAdmin: true } },
    { path: '/categories/create', component: Create, name: 'category.create', meta: { requiresAdmin: true } },
    { path: '/categories/:id/edit', component: Edit, name: 'category.edit', meta: { requiresAdmin: true } },
    // { path: '/categories/:id/assign', component: Assign, name: 'category.assign' },
];