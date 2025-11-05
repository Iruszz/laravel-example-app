import { putRequest, patchRequest } from '../../services/http';
import { storeModuleFactory } from '../../services/store';
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
        assignAgentToTicket: async (ticketId: number, agentId: number | null) => {
            try {
                const { data } = await putRequest(`${PROJECT_DOMAIN_NAME}/${ticketId}/assign-agent`, { agent_id: agentId });
                return data;
            } catch (error) {
                console.error('Failed to assign agent:', error);
            }
        },
        updateStatus: async (ticketId: number, statusId: number) => {
            const { data } = await putRequest(`${PROJECT_DOMAIN_NAME}/${ticketId}/status`, { status_id: statusId });
            if (!data) return;
            baseProjectStore.setters.setById(data);
        },
    },
};