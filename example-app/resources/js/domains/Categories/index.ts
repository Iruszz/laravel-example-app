import {storeModuleFactory} from '../../services/store';
import { Category } from './types';

export const PROJECT_DOMAIN_NAME = 'categories';

export const baseProjectStore = storeModuleFactory<Category>(PROJECT_DOMAIN_NAME);

export const categoryStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions
    },
};