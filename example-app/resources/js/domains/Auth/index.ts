import { storeModuleFactory } from '../../services/store';
import { computed } from 'vue';
import axios from 'axios';
import { LoggedInUser } from './types';

export const PROJECT_DOMAIN_NAME = 'auth';

export const baseProjectStore = storeModuleFactory<LoggedInUser>(PROJECT_DOMAIN_NAME);

export const authStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions,
        // async fetchCurrentUser() {
        //     const { data } = await axios.get('/api/me');
        //     baseProjectStore.setters.setCurrent(data);
        //     return data;
        // },
        // updateAgent: async (id: number, updatedAgent: Partial<User>) => {
        //     const { data } = await axios.put(`/api/admins/${id}`, updatedAgent);
        //     if (!data) return;
        //     baseProjectStore.setters.setAll(data);
        // },
    },
};