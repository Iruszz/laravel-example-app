<template>
  <!-- <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        
      <div v-for="ticket in tickets" :key="ticket">
        <div class="group relative">
            <img :src="`/assets/ticket-2-svgrepo-com.svg`" alt="ticket" class="dark:hidden aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
            <img :src="`/assets/ticket-2-svgrepo-com-dark.svg`" alt="ticket dark" class="hidden dark:block aspect-square w-full rounded-md bg-gray-800 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />

            <div class="mt-4 flex justify-between">
                <div>
                    <h3 class="text-sm text-gray-700">
                        <RouterLink :to="{ name: 'tickets.show', params: { id: ticket.id } }">
                            <span aria-hidden="true" class="absolute inset-0"></span>
                        </RouterLink>
                        {{ ticket.title }}
                    </h3>
                </div>
                <p class="text-sm font-medium text-gray-900">$14,45</p>
            </div>
        </div>
        <div class="mt-4 flex justify-between">
            <RouterLink :to="{ name: 'tickets.edit', params: { id: ticket.id } }">Edit Ticket</RouterLink>
            <button @click="deleteComfirm(ticket.id)">Delete</button>
        </div>
      </div>
    </div>
  </div> -->



<div class="relative pb-15 overflow-x-auto shadow-md sm:rounded-lg">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
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
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="ticket in tickets" :key="ticket" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <img class="w-10 h-10 rounded-full" src="https://flowbite.com/docs/images/examples/image-2@2x.jpg" alt="Jese image">
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{ ticket.user.name }}</div>
                        <div class="font-normal text-gray-500">{{ ticket.user.email }}</div>
                    </div>  
                </th>
                <td class="px-6 py-4">
                    {{ ticket.title }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                          <div class="h-2.5 w-2.5 rounded-full me-2" :class=" {
                              'bg-green-500': ticket.status.name === 'completed',
                              'bg-yellow-500': ticket.status.name === 'in progress',
                              'bg-gray-500': ticket.status.name === 'to do',
                            }">
                          </div> 
                          {{ ticket.status?.name || 'No status' }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <RouterLink class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                      :to="{ name: 'ticket.edit', params: { id: ticket.id } }">
                        Edit Ticket
                    </RouterLink>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</template>

<script setup>
import { ticketStore } from '..';

ticketStore.actions.getAll();
const tickets = ticketStore.getters.all;

ticketStore.setters.deleteByItem;

const deleteTicket = (id) => {
    ticketStore.actions.delete(id);
}

function deleteComfirm(ticketId) {
  if (confirm("The ticket is being deleted together with the reviews")) {
    deleteTicket(ticketId)
  }
}
</script>