import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

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
    const {data} = await getRequest('/tickets');
    if(!data) return;
    tickets.value = data;
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