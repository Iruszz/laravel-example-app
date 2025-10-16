import { storeModuleFactory } from '../../services/store';
import { computed } from 'vue';
import axios from 'axios';

export const PROJECT_DOMAIN_NAME = 'users';

export const baseProjectStore = storeModuleFactory(PROJECT_DOMAIN_NAME);

export const userStore = {
    getters:  {
        ...baseProjectStore.getters,
        getAllAgents: computed(() => baseProjectStore.getters.all.value.filter(user => user.is_admin)),

    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions,
        updateAgent: async (id, updatedAgent) => {
            const { data } = await axios.put(`/api/admins/${id}`, updatedAgent);
            if (!data) return;
            baseProjectStore.setters.setAll(data);
        },
    },
};