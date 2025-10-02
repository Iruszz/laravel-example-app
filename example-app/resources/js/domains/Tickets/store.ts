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
    destroyMessage(); // clear old errors

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

export const addTicket = (ticket) => {
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
    tickets.value = data;
};

export const deleteTicket = async (id) => {
    await axios.delete(`/api/tickets/${id}`);
    tickets.value = tickets.value.filter(ticket => ticket.id !== id);
};