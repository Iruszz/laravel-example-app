import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

// state
const users = ref([]);

// getters
export const getAllUsers = computed(() => users.value);

// actions
export const fetchUsers = async () => {
    const {data} = await getRequest('/users');
    if(!data) return;
    users.value = data;
};


export const registerUser = async (newUser) => {
    const {data} = await axios.post('/api/register', newUser);
    if(!data) return
    users.value = data;
};


export const getUserById = (id) => computed(() => users.value.find(user => user.id == id));

export const updateUser = async (id, updatedUser) => {
    const { data } = await axios.put(`/api/users/${id}`, updatedUser);
    if (!data) return;
    users.value = data;
};

export const loginUser = async (credentials) => {
    const { data } = await axios.post(`/api/login`, credentials);
    if (!data) return;
    users.value = data;
};


export const deleteUser = async (id) => {
    await axios.delete(`/api/users/${id}`);
    users.value = users.value.filter(user => user.id !== id);
};