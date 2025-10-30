import {storeModuleFactory} from '../../services/store';
import { postRequest } from '../../services/http'
import { computed } from 'vue';
import { Comment } from './types'

export const PROJECT_DOMAIN_NAME = 'comments';

export const baseProjectStore = storeModuleFactory<Comment>(PROJECT_DOMAIN_NAME);

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
        ...baseProjectStore.actions,
    },
};