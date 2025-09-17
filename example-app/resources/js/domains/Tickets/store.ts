import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

// state
const tickets = ref([]);

// getters
export const getAllTickets = computed(() => tickets.value);

// actions
export const fetchTickets = async () => {
    const {data} = await getRequest('/tickets');
    if(!data) return;
    tickets.value = data;
};

export const createTicket = async (newTicket) => {
    const {data} = await axios.post('/api/tickets', newTicket);
    if(!data) return
    tickets.value = data;
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