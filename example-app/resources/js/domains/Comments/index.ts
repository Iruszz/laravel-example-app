import {storeModuleFactory} from '../../services/store';
import { computed } from 'vue';

export const PROJECT_DOMAIN_NAME = 'comments';

export const baseProjectStore = storeModuleFactory(PROJECT_DOMAIN_NAME);

export const commentStore = {
    getters:  {
        ...baseProjectStore.getters,
        getCommentsByTicketId: (ticketId: number) =>
            computed(() =>
                Object.values(baseProjectStore.getters.all.value).filter(
                (comment: any) => comment.ticket_id === ticketId)
            ),
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions
    },
};