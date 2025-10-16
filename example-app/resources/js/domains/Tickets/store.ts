import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';
import { setMessage, destroyMessage } from '../../services/error';

interface Ticket {
  id: number;
  title: string;
  user_id: number;
  category_id: number;
  status_id: number;
  created_at?: string;
  updated_at?: string;
}

// state
const tickets = ref<Ticket[]>([]);

// getters
export const getAllTickets = computed(() => tickets.value);

// actions
export const fetchTickets = async () => {
    destroyMessage();

    try {
        const { data } = await getRequest('/tickets');
        if (!data) return;
        tickets.value = data;
    } catch (error: any) {
        if (error.response && error.response.status === 401) {
            setMessage('401 Unauthorized - Je bent niet ingelogd.');
        } else {
            setMessage('Er is iets misgegaan bij het ophalen van de tickets.');
        }
        tickets.value = [];
    }
};

export const assignAgentToTicket = async (ticketId: number, agentId: number) => {
    try {
        const { data } = await axios.patch(`/api/tickets/${ticketId}/assign-agent`, { agent_id: agentId });
        return data;
    } catch (error) {
        console.error('Failed to assign agent:', error);
    }
};

export const addTicket = (ticket: Ticket) => {
    tickets.value = [...tickets.value, ticket];
};

export const createTicket = async (newTicket: Omit<Ticket, 'id'>) => {
    const { data } = await axios.post('/api/tickets', newTicket);
    if (!data) return;
    addTicket(data);
};

export const getTicketById = (id) => computed(() => tickets.value.find(ticket => ticket.id == id));

export const updateTicket = async (id, updatedTicket) => {
    const { data } = await axios.put(`/api/tickets/${id}`, updatedTicket);
    if (!data) return;

    const index = tickets.value.findIndex(t => t.id === data.id);
    if (index !== -1) {
        tickets.value[index] = { ...data };
    } else {
        tickets.value.push({ ...data });
    }
};

export const deleteTicket = async (id) => {
    await axios.delete(`/api/tickets/${id}`);
    tickets.value = tickets.value.filter(ticket => ticket.id !== id);
};