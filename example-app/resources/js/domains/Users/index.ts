import { User } from './types';
import { storeModuleFactory } from '../../services/store';
import { computed } from 'vue';
// import {createOverviewRoute} from 'services/router/factory';
// import {setTranslation} from 'services/translation';
// import {storeModuleFactory} from 'services/store';
// import OverviewPage from './pages/Overview.vue';

export const USER_DOMAIN_NAME = 'users';

export const baseProjectStore = storeModuleFactory<User>(USER_DOMAIN_NAME);

export const userStore = {
    getters:  {
        ...baseProjectStore.getters,
        getAllAgents: computed(() => {
            return (baseProjectStore.getters.all.value as User[]).filter(user => user.is_admin);
        }),
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions,
    },
};