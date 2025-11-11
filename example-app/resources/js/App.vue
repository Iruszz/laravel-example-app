<script setup>
import { ref, onMounted, nextTick, computed } from 'vue';
import { getRequest, postRequest } from './services/http';
import { useRouter } from 'vue-router';
import ToastContainer from './services/components/ToastContainer.vue';
import { userStore } from './domains/Users';
import { getLoggedInUser, me } from './domains/Auth/store';
import { ticketStore } from './domains/Tickets';
import { categoryStore } from './domains/Categories';

const router = useRouter();

function closeDropdown() {
  const dropdown = document.getElementById('dropdown')
  if (dropdown && !dropdown.classList.contains('hidden')) {
    dropdown.classList.add('hidden')
  }
}

onMounted(async () => {
    router.afterEach(() => {
      closeDropdown()
    })
    await me();
    await nextTick();
});

const handleLogout = async () => {
  try {
    await postRequest('/logout');
    ticketStore.setters.clear();
    categoryStore.setters.clear();
    userStore.setters.clear();
    router.push({ name: 'login.overview' });
  } catch (err) {
    console.error('Logout failed', err);
  }
}
</script>

<template>
<div class="flex flex-col min-h-screen">
  <nav v-if="!$route.meta.hideNavbar" class="bg-gray-800/50">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4">
                  <router-link :to="{name: 'tickets.overview'}"
                      class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                      Ticket Overview
                  </router-link>
                  <router-link :to="{name: 'ticket.create'}"
                      class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                      Add new Ticket
                  </router-link>
              </div>
            </div>
          </div>
          <div class="flex justify-center items-center items-right">
            <div class="mr-10">
              <button v-if="getLoggedInUser?.is_admin" id="dropdownDefaultButton" data-dropdown-toggle="dropdown" 
                class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" 
                type="button">Administrator
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
              </button>

              <!-- Dropdown menu -->
              <div v-if="getLoggedInUser?.is_admin" id="dropdown" 
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                      <router-link  :to="{name: 'categories.overview'}"
                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                          Categories
                      </router-link>                    
                    </li>
                    <li>
                      <router-link  :to="{name: 'users.overview'}"
                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                          Users
                      </router-link>                    
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>
                  </ul>
              </div>
            </div>
            <div>
              <router-link v-if="!getLoggedInUser" :to="{name: 'login.overview'}"
                  class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                  Login
              </router-link>
              <button v-if="!!getLoggedInUser" @click="handleLogout"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
                Logout
              </button>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <!-- Mobile menu button -->
            <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
              <span class="absolute -inset-0.5"></span>
              <span class="sr-only">Open main menu</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
        </div>
      </div>
  </nav>
  <router-view />
  <ToastContainer />
</div>
</template>