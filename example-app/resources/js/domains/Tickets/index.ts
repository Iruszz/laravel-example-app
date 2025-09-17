import {storeModuleFactory} from '../../services/store';

export const PROJECT_DOMAIN_NAME = 'tickets';

export const baseProjectStore = storeModuleFactory(PROJECT_DOMAIN_NAME);

export const ticketStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions
    },
};