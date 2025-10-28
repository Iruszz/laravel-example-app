import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest, putRequest } from '../../services/http';
import { setMessage, destroyMessage } from '../../services/error';

interface Status {
  id: number;
  title: string;
  user_id: number;
  category_id: number;
  status_id: number;
  created_at?: string;
  updated_at?: string;
}

// state
const status = ref<Status[]>([]);

// getters
export const getAllStatus = computed(() => status.value);

// actions
export const fetchStatus = async () => {
    destroyMessage();

    try {
        const { data } = await getRequest('/status');
        if (!data) return;
        status.value = data;
    } catch (error: any) {
        if (error.response && error.response.status === 401) {
            setMessage('401 Unauthorized - Je bent niet ingelogd.');
        } else {
            setMessage('Er is iets misgegaan bij het ophalen van de status.');
        }
        status.value = [];
    }
};

export const assignAgentToStatus = async (statusId: number, agentId: number) => {
    try {
        const { data } = await putRequest(`/status/${statusId}/assign-agent`, { agent_id: agentId });
        return data;
    } catch (error) {
        console.error('Failed to assign agent:', error);
    }
};

export const addStatus = (status: Status) => {
    status.value = [...status.value, status];
};

export const createStatus = async (newStatus: Omit<Status, 'id'>) => {
    const { data } = await axios.post('/api/status', newStatus);
    if (!data) return;
    addStatus(data);
};

export const getStatusById = (id) => computed(() => status.value.find(status => status.id == id));

export const updateStatus = async (id, updatedStatus) => {
    const { data } = await axios.put(`/api/status/${id}`, updatedStatus);
    if (!data) return;

    const index = status.value.findIndex(t => t.id === data.id);
    if (index !== -1) {
        status.value[index] = { ...data };
    } else {
        status.value.push({ ...data });
    }
};

export const deleteStatus = async (id) => {
    await axios.delete(`/api/status/${id}`);
    status.value = status.value.filter(status => status.id !== id);
};