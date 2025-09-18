import {storeModuleFactory} from '../../services/store';

export const PROJECT_DOMAIN_NAME = 'categories';

export const baseProjectStore = storeModuleFactory(PROJECT_DOMAIN_NAME);

export const categoryStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions
    },
};