import EmailVerification from './pages/EmailVerification.vue';
import LoginPage from './pages/LoginPage.vue';
import PasswordResetRequest from './pages/PasswordResetRequest.vue';
import RegisterPage from './pages/RegisterPage.vue';
import ResetPasswordPage from './pages/ResetPasswordPage.vue';

export const UsersRoutes =  [
    { path: '/login', component: LoginPage, name: 'login.overview', meta: { hideNavbar: true,}},
    { path: '/register', component: RegisterPage, name: 'register.overview', meta: { hideNavbar: true,}},
    { path: '/verify-email', component: EmailVerification, name: 'emailVerification.overview', meta: { hideNavbar: true,} },
    { path: '/password-reset-request', component: PasswordResetRequest, name: 'password-reset-request.overview', meta: { hideNavbar: true,}},
    { path: '/password-reset/:token', component: ResetPasswordPage, name: 'auth.reset-password', meta: { hideNavbar: true,}},
];