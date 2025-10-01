import Create from './pages/Create.vue';
import Edit from './pages/Edit.vue';

export const CommentRoutes =  [
    { path: '/comments/create', component: Create, name: 'comments.create' },
    { path: '/comments/:id/edit', component: Edit, name: 'comments.edit' },
];