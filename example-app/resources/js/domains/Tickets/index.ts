import { putRequest } from '../../services/http';
import {storeModuleFactory} from '../../services/store';
import axios from 'axios';
import { New, State, Updatable } from '../../services/store/types';
import { Ticket } from './types';

export const PROJECT_DOMAIN_NAME = 'tickets';

export const baseProjectStore = storeModuleFactory<Ticket>(PROJECT_DOMAIN_NAME);

export const ticketStore = {
    getters:  {
        ...baseProjectStore.getters,
    },
    setters: baseProjectStore.setters,
    actions: {
        ...baseProjectStore.actions,

        updateStatus: async (tickets: State<Ticket>, ticketId: number, statusId: number) => {
            try {
                const { data } = await putRequest(`${PROJECT_DOMAIN_NAME}/${ticketId}`, { status_id: statusId });
                if (!data) return;

                const index = tickets.value.findIndex(t => t.id === data.id);

                if (index !== -1) {
                    tickets.value[index] = data;
                }

                return data;
            } catch (error) {
                console.error('Failed to change status:', error);
            }
        },
    },
};