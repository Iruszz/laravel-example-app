<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { commentStore } from '../../Comments/index';
import Form from '../../Comments/components/FormShowPage.vue';

const route = useRoute();
const router = useRouter();

const ticket = ref(null);
const ticketId = Number(route.params.id);

commentStore.actions.getAll();
const comments = computed(() => {
    const c = commentStore.getters.getCommentsByTicketId(ticketId);
    return c?.value || [];
});

const comment = ref({
    ticket_id: ticketId,
    name: '',
    comment: ''
});

const statusColors = {
    'yellow-500': { text: 'text-yellow-500', bg: 'bg-yellow-900' },
    'green-500': { text: 'text-green-500', bg: 'bg-green-900' },
};

const formatTime = (dateStr) => {
  const d = new Date(dateStr);
  return d.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
};

const timeAgo = (dateStr) => {
  const d = new Date(dateStr);
  const now = new Date();
  const diffHours = Math.floor((now.getTime() - d.getTime()) / 1000 / 60 / 60);
  if (diffHours < 24) return `${diffHours} hours ago`;
  const diffDays = Math.floor(diffHours / 24);
  return `${diffDays} days ago`;
};

const handleSubmit = async (item) => {
    await commentStore.actions.create(item);
    router.push({ name: 'tickets.show' });
};

onMounted(async () => {
    const { data } = await getRequest(`/tickets/${ticketId}`);
    ticket.value = data;
});

console.log('Comments', comments.value);

const deleteComment = (id) => {
    commentStore.actions.delete(id);
}
</script>

<template>

<div class="min-h-full">
    <header v-if="ticket" class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
        <div class="flex items-center space-x-5 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Ticket #{{ ticket.id }}</h1>
            <span
                class="inline-flex items-center rounded-md px-2.5 py-1 text-xs font-medium"
                :class="[statusColors[ticket.status.color].text, statusColors[ticket.status.color].bg]"
                >
                <!-- Yellow (pending) -->
                <svg v-if="ticket.status.color === 'yellow-500'" class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M5.5 3a1 1 0 0 0 0 2H7v2.3c0 .7.2 1.3.6 1.8L9 11.9l.1.1v.1L7.5 15a3 3 0 0 0-.6 1.8V19H5.5a1 1 0 1 0 0 2h13a1 1 0 1 0 0-2H17v-2.3a3 3 0 0 0-.6-1.8l-1.6-2.8v-.2l1.6-2.8a3 3 0 0 0 .6-1.8V5h1.5a1 1 0 1 0 0-2h-13Z" clip-rule="evenodd"/>
                </svg>

                <!-- Green (solved) -->
                <svg v-if="ticket.status.color === 'green-500'" class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2c0-.6-.4-1-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.7 8.7a1 1 0 0 0-1.4-1.4L11 14.6l-1.3-1.3a1 1 0 0 0-1.4 1.4l2 2c.4.4 1 .4 1.4 0l4-4Z" clip-rule="evenodd"/>
                </svg>

                {{ ticket.status.name }}
            </span>
        </div>
    </header>

    <main>
        <section v-if="ticket" class="bg-white md:py-5 mx-10 dark:bg-gray-900 antialiased border-b border-white/10">
            <div class="flex items-center max-w-screen-xl mx-auto 2xl:px-0">
                    <div class="sm:mt-8 lg:mt-0">
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                            {{ ticket.title }}
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400">
                            Via email
                        </p>
                    </div>
                    <div class="ml-auto">
                        <p class="text-gray-500 dark:text-gray-400">
                        {{ new Date(ticket.created_at).toLocaleDateString('en-US', { weekday: 'short' }) }},
                        <time :datetime="ticket.created_at">
                            {{ formatTime(ticket.created_at) }}
                        </time>
                        ({{ timeAgo(ticket.created_at) }})
                        </p>
                    </div>
            </div>
        </section>

    <!-- Comments -->
    <div class="mx-auto  px-20 py-6 ">
            <section class="bg-white  dark:bg-gray-900 py-8 lg:py-16 antialiased">
                <div class="mx-auto px-4">
                    <article
                        v-for="comment in comments"
                        :key="comment.id"
                        class="p-6 text-base bg-white rounded-lg dark:bg-gray-900 mb-4">
                        <footer class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                    <img
                                        class="mr-2 w-6 h-6 rounded-full dark:hidden"
                                        :src="'/storage/assets/person-crop-circle-fill-svgrepo-com.svg'"
                                        alt="Profile"
                                    />
                                    <img
                                        class="mr-2 w-6 h-6 rounded-full hidden dark:block"
                                        :src="'/storage/assets/person-crop-circle-fill-svgrepo-com-dark.svg'"
                                        alt="Profile"
                                    />
                                    
                                    {{ comment.user.name }}
                                </p>
                            </div>
                            <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">
                            <p v-html="comment.comment.replace(/\n/g, '<br>')"></p>
                        </p>
                        <div class="flex items-center mt-4 space-x-4">
                            <RouterLink :to="{ name: 'comments.edit', params: { id: comment.id } }"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                </svg>
                                Edit
                            </RouterLink>
                            <button @click="deleteReview(comment.id)" type="button"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </article>

                    <Form :comment="comment" @submit="handleSubmit" />

                </div>
            </section>
        </div>




  </main>
</div>
</template>