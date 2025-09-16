import AdminPage from './pages/AdminPage.vue';
import ForbiddenPage from './pages/ForbiddenPage.vue';

export const AdminRoutes = [
  { path: '/admin', component: AdminPage, name: 'admin.overview' },
  { path: '/admin/forbidden', component: ForbiddenPage, name: 'admin.forbidden' },
];
