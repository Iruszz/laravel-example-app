import EmailVerification from './pages/EmailVerification.vue';
import LoginPage from './pages/LoginPage.vue';
import PasswordResetRequest from './pages/PasswordResetRequest.vue';
import RegisterPage from './pages/RegisterPage.vue';
import ResetPasswordPage from './pages/ResetPasswordPage.vue';

export const AuthRoutes =  [
    { path: '/login', component: LoginPage, name: 'login.overview', meta: { hideNavbar: true, canSeeWhenLoggedIn: false,}},
    { path: '/register', component: RegisterPage, name: 'register.overview', meta: { hideNavbar: true, canSeeWhenLoggedIn: false,}},
    { path: '/verify-email', component: EmailVerification, name: 'emailVerification.overview', meta: { hideNavbar: true, canSeeWhenLoggedIn: false,} },
    { path: '/password-reset-request', component: PasswordResetRequest, name: 'password-reset-request.overview', meta: { hideNavbar: true, canSeeWhenLoggedIn: false,}},
    { path: '/password-reset/:token', component: ResetPasswordPage, name: 'auth.reset-password', meta: { hideNavbar: true, canSeeWhenLoggedIn: false,}},
];