<script setup lang="ts">
import { onMounted, nextTick } from 'vue';
import { ticketStore } from '..';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import { setMessage, destroyMessage } from '../../../services/error';
import Status from '../components/Status.vue';
import { initFlowbite } from 'flowbite';

destroyMessage();

const fetchTickets = async () => {
    try {
        await ticketStore.actions.getAll();
    } catch (error: any) {
        if (error.response && error.response.status === 401) {
            setMessage('401 Unauthorized - You are not logged in.');
        } else {
            setMessage('Er is iets misgegaan bij het ophalen van de tickets.');
        }
    }
};

onMounted(async () => {
    await fetchTickets();
    await nextTick(); 
    initFlowbite();
});

const tickets = ticketStore.getters.all;

function formatDate(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
}

const markAsSolved = async (ticketId: number) => {
    await ticketStore.actions.updateStatus(ticketId, 2);
}

const deleteTicket = (id: number) => {
    ticketStore.actions.delete(id);
};

function deleteConfirm(ticketId: number) {
    if (confirm("The ticket is being deleted together with the reviews")) {
        deleteTicket(ticketId);
    }
}

</script>

<template>
    <ErrorMessage />
    <main class="flex-1 flex flex-col overflow-hidden">
        <div v-if="tickets.length > 0" class="flex-1 flex flex-col overflow-hidden mt-10 shadow-md sm:rounded-lg">
            <div class="flex-1 overflow-x-auto">
                <div class="flex h-full items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 px-15 pb-4 bg-white dark:bg-gray-900">
                    <div>
                        <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <span class="sr-only">Action button</span>
                            Action
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
                            </div>
                        </div>
                    </div>
                    <!-- Search -->
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
                    </div>
                </div>

                <!-- Tickets -->
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Title
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Agent
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Create Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ticket in tickets" :key="ticket.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th class="flex items-center px-6 py-4 gap-3">
                                <img class="w-10 h-10 rounded-full object-cover" src="https://flowbite.com/docs/images/examples/image-2@2x.jpg" alt="Jese image">
                                <div class="text-sm font-medium text-gray-800 dark:text-white">{{ ticket.user.name }}</div>
                            </th>
                            <td class="px-6 py-4">
                                <RouterLink
                                    class="text-gray-800 dark:text-white hover:underline"
                                    :to="{ name: 'ticket.show', params: { ticket: ticket.id } }">
                                    {{ ticket.title }}
                                </RouterLink>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="w-10 h-10 rounded-full object-cover" src="https://flowbite.com/docs/images/examples/image-2@2x.jpg" alt="Jese image">
                                    <div class="ps-3">
                                        <div :class="ticket.agent ? 'dark-text-gray-800 dark:text-white' : 'text-gray-500 dark:text-red'">
                                            {{ ticket.agent ? ticket.agent.name : 'No Agent' }}
                                        </div>
                                    </div>  
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-800 dark:text-white">
                                {{ formatDate(ticket.created_at) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <Status :ticket="ticket"/>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    :id="`dropdownDefault-${ticket.id}`"
                                    :data-dropdown-toggle="`dropdown-${ticket.id}`"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-700 dark:text-gray-400 rounded-lg hover:bg-gray-500 hover:text-white focus:outline-none focus:ring-gray-50"
                                > 
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div
                                    :id="`dropdown-${ticket.id}`"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600"
                                >
                                    <ul class="py-2 text-sm font-medium text-gray-700 dark:text-gray-400" aria-labelledby="dropdownMenuIconHorizontalButton">
                                        <li>
                                            <button type="button" class="flex block px-4 py-2 mx-2 gap-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            @click="markAsSolved( ticket.id )">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4.7 4.5 9.3-9"></path>
                                                </svg>
                                                Mark as solved
                                            </button>
                                        </li>
                                        <li>
                                            <RouterLink class="flex block px-4 py-2 mx-2 gap-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                :to="{ name: 'ticket.assign', params: { id: ticket.id } }">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.3-2a6 6 0 0 0 0-6A4 4 0 0 1 20 8a4 4 0 0 1-6.7 3Zm2.2 9a4 4 0 0 0 .5-2v-1a6 6 0 0 0-1.5-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.5Z" clip-rule="evenodd"></path>
                                                </svg>
                                                Assignee
                                            </RouterLink>
                                        </li>
                                        <li>
                                            <RouterLink class="flex block px-4 py-2 mx-2 gap-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                :to="{ name: 'ticket.edit', params: { id: ticket.id } }">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.3 6.2H5a2 2 0 0 0-2 2V19a2 2 0 0 0 2 2h11c1.1 0 2-1 2-2.1V11l-4 4.2c-.3.3-.7.6-1.2.7l-2.7.6c-1.7.3-3.3-1.3-3-3.1l.6-2.9c.1-.5.4-1 .7-1.3l3-3.1Z" clip-rule="evenodd"></path>
                                                    <path fill-rule="evenodd" d="M19.8 4.3a2.1 2.1 0 0 0-1-1.1 2 2 0 0 0-2.2.4l-.6.6 2.9 3 .5-.6a2.1 2.1 0 0 0 .6-1.5c0-.2 0-.5-.2-.8Zm-2.4 4.4-2.8-3-4.8 5-.1.3-.7 3c0 .3.3.7.6.6l2.7-.6.3-.1 4.7-5Z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit Ticket
                                            </RouterLink>
                                        </li>
                                    </ul>
                                    <ul class="py-2 px-2 text-sm font-medium text-gray-700 dark:text-gray-400">
                                        <li>
                                            <button type="button" id="deleteInvoiceButton"
                                                class="flex w-full px-4 py-2 gap-2 rounded-lg text-sm text-red-700 hover:bg-red-100 dark:hover:bg-gray-600 dark:text-red-500"
                                                @click="deleteConfirm(ticket.id)">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8.6 2.6A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4c0-.5.2-1 .6-1.4ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"></path>
                                                </svg>
                                                Delete
                                            </button>                                    
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    
        <div v-else class="relative pb-15 overflow-x-auto shadow-md sm:rounded-lg">
            <div class="relative pb-15 overflow-x-auto shadow-md sm:rounded-lg">
                <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <p>You have not tickets yet</p>
                </div>
            </div>
        </div>
    </main>
</template>