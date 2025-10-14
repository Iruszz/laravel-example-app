import Overview from '../Tickets/pages/Overview.vue';
import Show from '../Tickets/pages/Show.vue';
import Create from '../Tickets/pages/Create.vue';
import Edit from '../Tickets/pages/Edit.vue';
import Assign from './pages/Assign.vue';

export const TicketRoutes =  [
    { path: '/tickets', component: Overview, name: 'tickets.overview' },
    { path: '/tickets/:ticket', component: Show, name: 'ticket.show' },
    { path: '/tickets/create', component: Create, name: 'ticket.create' },
    { path: '/tickets/:id/edit', component: Edit, name: 'ticket.edit' },
    { path: '/tickets/:id/assign', component: Assign, name: 'ticket.assign' },

];