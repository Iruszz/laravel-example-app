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
    response => response,
    error => {
        if (error.response) {
            if (error.response.status === 422) {
                setErrorBag(error.response.data.errors);
                setMessage(error.response.data.message);
            }
            if (error.response.status === 401) {
                toastStore.add('You must be logged in to access this page.', 'error');
                router.push({ name: 'login.overview' });
            }
            if (error.response.status === 403 && error.response.data.message?.includes('verified')) {
                setMessage('Please verify your email before continuing.');
                router.push({ name: 'emailVerification.overview' });
            }
            if (error.response.status === 403) {
            const code = error.response.data.code;
            if (code === 'TICKET_FORBIDDEN') {
                toastStore.add('You are not authorized to view this ticket.', 'error');
            } else if (code === 'AGENT_ASSIGNMENT_FORBIDDEN') {
                toastStore.add('Only admins can assign agents.', 'error');
            }
            router.push({ name: 'tickets.overview' });
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