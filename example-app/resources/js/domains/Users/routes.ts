import Overview from '../Users/pages/Overview.vue';
// import Show from '../Users/pages/Show.vue';
import Create from '../Users/pages/Create.vue';
import Edit from '../Users/pages/Edit.vue';

export const UsersRoutes =  [
    { path: '/users', component: Overview, name: 'users.overview' },
    { path: '/users/:id/edit', component: Edit, name: 'user.edit' },
];