import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';
import { authStore } from '../Auth/index';

// state
// const users = ref([]);

// getters
// export const getAllUsers = computed(() => users.value);

// export const getAllAgents = computed(() => userStore.getters.all.value.filter(user => user.is_admin));

// actions
// export const fetchAgents = async () => {
//     const {data} = await getRequest('/admins');
//     if(!data) return;
//     users.value = data;
// };

// export const createAgent = async (newAgent) => {
//     const {data} = await axios.post('/api/admins', newAgent);
//     if(!data) return
//     users.value = data;
// };

// export const getAgentById = (id) => computed(() => users.value.find(admin => admin.id == id));

// export const updateAgent = async (id, updatedAgent) => {
//     const { data } = await axios.put(`/api/admins/${id}`, updatedAgent);
//     if (!data) return;
//     users.value = data;
// };

// export const deleteAgent = async (id) => {
//     await axios.delete(`/api/admins/${id}`);
//     users.value = users.value.filter(admin => admin.id !== id);
// };
