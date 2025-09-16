import {storeModuleFactory} from '../../services/store';

export const ADMIN_DOMAIN_NAME = 'admin';

export const AdminStore = storeModuleFactory(ADMIN_DOMAIN_NAME);

export const adminStore = {
    getters:  {
        ...AdminStore.getters,
    },
    setters: AdminStore.setters,
    actions: {
        ...AdminStore.actions
    },
};
