import {storeModuleFactory} from '../../services/store';
import { postRequest } from '../../services/http'
import { computed } from 'vue';
import { Note } from './types'

export const PROJECT_DOMAIN_NAME = 'notes';

export const baseProjectStore = storeModuleFactory<Note>(PROJECT_DOMAIN_NAME);

export const noteStore = {
    getters:  {
        ...baseProjectStore.getters,
        getNotesByTicketId: (ticketId: number) =>
            computed(() =>
                Object.values(baseProjectStore.getters.all.value).filter(
                (notes: any) => notes.ticket_id === ticketId)
            ),
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions,
    },
};