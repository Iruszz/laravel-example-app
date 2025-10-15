import AgentPage from './pages/AgentPage.vue';
import ForbiddenPage from './pages/ForbiddenPage.vue';

export const AgentRoutes = [
  { path: '/agent', component: AgentPage, name: 'agent.overview' },
  { path: '/agent/forbidden', component: ForbiddenPage, name: 'agent.forbidden' },
];
