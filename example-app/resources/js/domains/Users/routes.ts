import Overview from '../Users/pages/Overview.vue';
import Show from '../Tickets/pages/Show.vue';
import Create from '../Tickets/pages/Create.vue';
import Edit from '../Tickets/pages/Edit.vue';
import Assign from '../Agents/pages/Assign.vue';

export const UsersRoutes =  [
    { path: '/users', component: Overview, name: 'users.overview' },
    { path: '/users/:id/edit', component: Overview, name: 'user.edit' },
];