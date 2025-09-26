<template>
<nav v-if="!$route.meta.hideNavbar" class="bg-gray-800/50 mb-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <div class="flex items-center">
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
                <router-link :to="{name: 'ticket.overview'}"
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
        <div class="flex items-right">
          <router-link v-if="!isLoggedIn" :to="{name: 'login.overview'}"
              class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
              Login
          </router-link>
        <button v-if="isLoggedIn" @click="handleLogout"
          class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white">
          Logout
        </button>
          <router-link v-if="isAdmin" :to="{name: 'admin.overview'}"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
              Administrator
          </router-link>
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

<router-view></router-view>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getRequest, postRequest } from './services/http';
import { useRouter } from 'vue-router';

const isLoggedIn = ref(false);
const isAdmin = ref(false);
const router = useRouter();

onMounted(async () => {
  try {
    const res = await getRequest('/user');
    isLoggedIn.value = !!res.data;
    isAdmin.value = res.data?.is_admin === 1 || res.data?.is_admin === "1";
  } catch (err) {
    isLoggedIn.value = false;
    isAdmin.value = false;
  }
});

const handleLogout = async () => {
  try {
    await postRequest('/logout');
    isLoggedIn.value = false;
    isAdmin.value = false;
    router.push({ name: 'login.overview' });
  } catch (err) {
    console.error('Logout failed', err);
  }
}
</script>