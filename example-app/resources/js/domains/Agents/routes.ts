import AgentPage from './pages/AgentPage.vue';
import ForbiddenPage from '../../services/components/ForbiddenPage.vue';

export const AgentRoutes = [
  { path: '/agent', component: AgentPage, name: 'agent.overview', meta: { requiresAdmin: true } },
  { path: '/agent/forbidden', component: ForbiddenPage, name: 'agent.forbidden', meta: { requiresAdmin: true } },
];
