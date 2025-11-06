import { storeModuleFactory } from '../../services/store';
import type { User } from '../User/types';
import { computed } from 'vue';
import axios from 'axios';

export const PROJECT_DOMAIN_NAME = 'users';

export const baseProjectStore = storeModuleFactory<User>(PROJECT_DOMAIN_NAME);

export const userStore = {
    getters:  {
        ...baseProjectStore.getters,
        // getAllAgents: computed(() => {
        //     return (baseProjectStore.getters.all.value as User[]).filter(user => user.is_admin);
        // }),
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