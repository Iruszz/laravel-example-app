import LoginPage from './pages/LoginPage.vue';
import RegisterPage from './pages/RegisterPage.vue';

export const UsersRoutes =  [
    { path: '/login', component: LoginPage, name: 'login.overview' },
    { path: '/register', component: RegisterPage, name: 'register.overview' },
];