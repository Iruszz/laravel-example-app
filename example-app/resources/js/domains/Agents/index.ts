import { storeModuleFactory } from '../../services/store';
import { computed } from 'vue';

export const ADMIN_DOMAIN_NAME = 'agents';

export const AgentStore = storeModuleFactory(ADMIN_DOMAIN_NAME);

export const agentStore = {
    getters:  {
        ...AgentStore.getters,
    },
    setters: AgentStore.setters,
    actions: {
        ...AgentStore.actions
    },
};
