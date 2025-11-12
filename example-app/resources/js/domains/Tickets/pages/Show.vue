<script setup lang="ts">
import { ref, onMounted, computed, nextTick } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { noteStore } from '../../Notes';
import { ticketStore } from '..';
import { commentStore } from '../../Comments/index';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import Form from '../../Comments/components/FormShowPage.vue';
import Status from '../components/Status.vue';
import { Ticket } from '../types';
import { getLoggedInUser, me } from '../../Auth/store';
import { orderBy } from '../../../services/helpers';
import { initFlowbite } from 'flowbite';

const route = useRoute();
const router = useRouter();


const ticketId = Number(route.params.ticket);
const ticket = ref<Ticket | null>(null);

commentStore.actions.getAll();
const comments =  commentStore.getters.getCommentsByTicketId(ticketId);

const notes = computed(() =>
    orderBy(noteStore.getters.getNotesByTicketId(ticketId).value, 'created_at', false)
);

const comment = ref({
    ticket_id: ticketId,
    comment: ''
});

const currentUser = computed(() => getLoggedInUser.value);

const isOwnerOrAgent = computed(() => {
  const u = currentUser.value;
  const t = ticket.value;
  if (!u || !t) return false;
  return u.id === t.user_id || u.id === t.agent_id;
});

const formatTime = (dateStr) => {
  const d = new Date(dateStr);
  return d.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
};

const timeAgo = (dateStr) => {
  const d = new Date(dateStr);
  const now = new Date();
  const diffHours = Math.floor((now.getTime() - d.getTime()) / 1000 / 60 / 60);
  if(diffHours === 0) return ;
  else if (diffHours < 24) return `(${diffHours} hours ago)`
  const diffDays = Math.floor(diffHours / 24);
  return `(${diffDays} days ago)`;
};

const handleSubmit = async (item: any) => {
    try {
        await commentStore.actions.create(item);
        router.push({ name: 'ticket.show' });
    } catch (err) {
            console.error(err);
    }
};

onMounted(async () => {
  try {
    const storedTicket: Ticket | undefined = ticketStore.getters.byId(ticketId)?.value;
    if (storedTicket) {
      ticket.value = storedTicket;
    } else {
      const { data } = await getRequest(`/tickets/${ticketId}`);
      ticket.value = data;
    }

    await noteStore.actions.getAll();

    initFlowbite(); 

    const hash = window.location.hash;
    if (hash) {
      const el = document.querySelector(hash);
      if (el) {
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  } catch (err) {
    console.error(err);
  }

  if (!currentUser.value) {
    await me();
  }
});

const deleteNote = (id: number) => {
    noteStore.actions.delete(id);
};

const deleteComment = (id: number) => {
    commentStore.actions.delete(id);
}

function deleteConfirm(noteId: number) {
    if (confirm("The ticket is being deleted together with the reviews")) {
        deleteNote(ticketId);
    }
}
</script>

<template>
<ErrorMessage />
<div class="min-h-full">
    <header v-if="ticket" class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
        <div class="flex items-center space-x-5 mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-white">Ticket #{{ ticket.id }}</h1>
            <Status :ticket="ticket"/>
        </div>
    </header>

    <main>
        <section
            v-if="ticket"
            class="bg-white md:py-5 mx-10 dark:bg-gray-900 antialiased border-b border-white/10"
        >
            <div class="flex-inline divide-y divide-white/5 items-start max-w-screen-xl mx-auto 2xl:px-0">
                <div class="flex pb-5 items-start justify-between max-w-screen-xl mx-auto 2xl:px-0">
                    <!-- Left column -->
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                        {{ ticket.title }}
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400">
                        Via email
                        </p>
                    </div>

                    <!-- Right column -->
                    <div class="text-right">
                        <p class="text-gray-500 dark:text-gray-400">
                        {{ new Date(ticket.created_at).toLocaleDateString('en-US', { weekday: 'short' }) }},
                        <time :datetime="ticket.created_at">
                            {{ formatTime(ticket.created_at) }}
                        </time>
                        {{ timeAgo(ticket.created_at) }}
                        </p>
                    </div>
                </div>

                <!-- Notes -->
                <div v-if="getLoggedInUser?.is_admin" class="py-5 gap-5">
                    <div class="flex flex-wrap pb-5 gap-5 items-stretch justify-start">
                        <div
                        v-for="note in notes"
                        :key="note.id"
                        class="bg-gray-50 min-w-75 p-6 border-3 border-blue-700 rounded-lg dark:bg-gray-800 w-full md:w-auto"
                        >
                            <div class="flex justify-between items-start">
                                <!-- Left column: note text -->
                                <div class="flex flex-col pt-1 max-w-[calc(100%-3rem)]">
                                    <p class="text-gray-500 dark:text-white font-semibold">
                                        {{ note.user?.name || 'Unknown' }} added a note:
                                    </p>
                                    <p class="text-gray-500 dark:text-gray-400 mt-2">
                                        {{ note.description }}
                                    </p>
                                </div>

                                <!-- Right column: dropdown button -->
                                <div>
                                    <button
                                        :id="`dropdownDefault-${note.id}`"
                                        :data-dropdown-toggle="`dropdown-${note.id}`"
                                        class="inline-flex items-center p-2 text-sm font-medium text-center text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white"
                                    >
                                        <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 16 3"
                                        >
                                        <path
                                            d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
                                        />
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div
                                        :id="`dropdown-${note.id}`"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600"
                                    >
                                        <ul
                                        class="py-2 text-sm font-medium text-gray-700 dark:text-gray-400"
                                        aria-labelledby="dropdownMenuIconHorizontalButton"
                                        >
                                            <li>
                                                <RouterLink
                                                class="flex block px-4 py-2 mx-2 gap-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                :to="{ name: 'note.edit', params: { id: note.id }, query: { ticket_id: ticket.id }}"
                                                >
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M11.3 6.2H5a2 2 0 0 0-2 2V19a2 2 0 0 0 2 2h11c1.1 0 2-1 2-2.1V11l-4 4.2c-.3.3-.7.6-1.2.7l-2.7.6c-1.7.3-3.3-1.3-3-3.1l.6-2.9c.1-.5.4-1 .7-1.3l3-3.1Z" clip-rule="evenodd"></path>
                                                    <path fill-rule="evenodd" d="M19.8 4.3a2.1 2.1 0 0 0-1-1.1 2 2 0 0 0-2.2.4l-.6.6 2.9 3 .5-.6a2.1 2.1 0 0 0 .6-1.5c0-.2 0-.5-.2-.8Zm-2.4 4.4-2.8-3-4.8 5-.1.3-.7 3c0 .3.3.7.6.6l2.7-.6.3-.1 4.7-5Z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit Note
                                                </RouterLink>
                                            </li>
                                        </ul>

                                        <ul
                                        v-if="getLoggedInUser?.is_admin"
                                        class="py-2 px-2 text-sm font-medium text-gray-700 dark:text-gray-400"
                                        >
                                            <li>
                                                <button
                                                type="button"
                                                class="flex w-full px-4 py-2 gap-2 rounded-lg text-sm text-red-700 hover:bg-red-100 dark:hover:bg-gray-600 dark:text-red-500"
                                                @click="deleteConfirm(ticket.id)"
                                                >
                                                <svg
                                                    class="w-4 h-4"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                    fill-rule="evenodd"
                                                    d="M8.6 2.6A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4c0-.5.2-1 .6-1.4ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                    clip-rule="evenodd"
                                                    />
                                                </svg>
                                                Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add note button -->
                    <RouterLink
                        type="button"
                        class="flex justify-items-center items-center w-fit gap-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        :to="{ name: 'note.create', query: { ticket_id: ticket.id } }"
                    >
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="size-6"
                        >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add note
                    </RouterLink>
                </div>


                <!-- Comments -->
                <div class="">
                    <section class="bg-white pt-10 dark:bg-gray-900 antialiased">
                        <div class="">
                            <article
                                v-for="comment in comments"
                                :key="comment.id"
                                :id="`comment-${comment.id}`"
                                class="pb-10 text-base bg-white rounded-lg dark:bg-gray-900 mb-4">
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
                                    <RouterLink 
                                        v-if="currentUser && currentUser.id === comment.user_id"
                                        :to="{ name: 'comments.edit', params: { id: comment.id } }"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                        <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                        </svg>
                                        Edit
                                    </RouterLink>
                                    <button @click="deleteComment(comment.id)" type="button"
                                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                        <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </article>
                            <Form v-if="isOwnerOrAgent" :comment="comment" @submit="handleSubmit" />
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</div>
</template>