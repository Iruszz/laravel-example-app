import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

// state
const admins = ref([]);

// getters
export const getAllAdmins = computed(() => admins.value);

// actions
export const fetchAdmins = async () => {
    const {data} = await getRequest('/admins');
    if(!data) return;
    admins.value = data;
};

export const createAdmin = async (newAdmin) => {
    const {data} = await axios.post('/api/admins', newAdmin);
    if(!data) return
    admins.value = data;
};

export const getAdminById = (id) => computed(() => admins.value.find(admin => admin.id == id));

export const updateAdmin = async (id, updatedAdmin) => {
    const { data } = await axios.put(`/api/admins/${id}`, updatedAdmin);
    if (!data) return;
    admins.value = data;
};

export const deleteAdmin = async (id) => {
    await axios.delete(`/api/admins/${id}`);
    admins.value = admins.value.filter(admin => admin.id !== id);
};
