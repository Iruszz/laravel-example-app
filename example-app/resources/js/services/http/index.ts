import axios from 'axios';
import { destroyErrors, destroyMessage, setErrorBag, setMessage} from '../error';
import { router } from '../../router';
import { toastStore } from '../toast';

const http = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
    headers: {
        'Content-Type': 'application/json'
    },
    withCredentials: true,
    withXSRFToken: true
});

http.interceptors.request.use(
    config => {
        destroyErrors();
        destroyMessage();
        return config;
    },
    error => Promise.reject(error)
);

http.interceptors.response.use(
    response => {
            if (response.status === 200 && response.data.code === 'passwordReset') {
                console.log('test');
                toastStore.add(response.data.message, 'success');
                router.push({ name: 'login.overview' });
            }
            return response;
    },
    error => {
        if (error.response) {
            if (error.response.status === 422) {
                setErrorBag(error.response.data.errors);
                setMessage(error.response.data.message);
            }
            if (error.response.status === 400 && error.response.data.code === 'PASSWORD_RESET_FAILED') {
                toastStore.add(error.response.data.message, 'error');
                router.push({ name: 'password-reset-request.overview' });
            }
            if (error.response.status === 401) {
                toastStore.add('You must be logged in to access this page.', 'error');
                router.push({ name: 'login.overview' });
            }
            if (error.response.status === 403 && error.response.data.message?.includes('verified')) {
                setMessage('Please verify your email before continuing.');
                router.push({ name: 'emailVerification.overview' });
            }
            if (error.response.status === 403 && error.response.data.code === 'TICKET_FORBIDDEN') {
                toastStore.add('You are not authorized to view this ticket.', 'error');
                router.push({ name: 'tickets.overview' });
            }
            if (error.response.status === 403 && error.response.data.code === 'AGENT_ASSIGNMENT_FORBIDDEN') {
                toastStore.add('Only admins can assign agents.', 'error');
                router.push({ name: 'tickets.overview' });
            }
            if (error.response.status === 403 && error.response.data.code === 'COMMENT_FORBIDDEN') {
                const ticketId = error.response.data.ticket_id;
                toastStore.add('You are not authorized to comment on this ticket.', 'error');
                router.push({ name: 'tickets.show', params: { id: ticketId } });
            }
        }
        return Promise.reject(error);
    }
);


export const getRequest = (endpoint: string) => http.get(endpoint);
export const postRequest = (endpoint: string, data: any = {}) => http.post(endpoint, data);
export const putRequest = (endpoint: string, data: any) => http.put(endpoint, data);
export const deleteRequest = (endpoint: string) => http.delete(endpoint);
export { http as axiosInstance };