import axios from 'axios';
import { destroyErrors, destroyMessage, setErrorBag, setMessage} from '../error';

const http = axios.create({
    baseURL: import.meta.env.VITE_API_URL || '/api',
    headers: {
        'Content-Type': 'application/json'
    }
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
        if (error.response && error.response.status === 422) {
            setErrorBag(error.response.data.errors);
            setMessage(error.response.data.message);
            console.log(error.response.data.message);
        }
        return Promise.reject(error);
    }
);

export const getRequest = (endpoint) => http.get(endpoint);
export const postRequest = (endpoint, data) => http.post(endpoint, data);
export const putRequest = (endpoint, data) => http.put(endpoint, data);
export const deleteRequest = (endpoint) => http.delete(endpoint);