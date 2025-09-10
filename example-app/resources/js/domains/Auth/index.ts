import {storeModuleFactory} from '../../services/store';

export const PROJECT_DOMAIN_NAME = 'users';

export const baseProjectStore = storeModuleFactory(PROJECT_DOMAIN_NAME);

export const userStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions
    },
};