import Overview from '../Comments/pages/Overview.vue';
import Show from '../Comments/pages/Show.vue';
import Create from '../Comments/pages/Create.vue';
import Edit from '../Comments/pages/Edit.vue';

export const CommentRoutes =  [
    { path: '/tickets', component: Overview, name: 'ticket.overview' },
    { path: '/tickets/:id', component: Show, name: 'ticket.show' },
    { path: '/tickets/create', component: Create, name: 'ticket.create' },
    { path: '/tickets/:id/edit', component: Edit, name: 'ticket.edit' },
];