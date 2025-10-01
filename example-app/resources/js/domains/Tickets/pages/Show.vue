<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { commentStore } from '../../Comments/index';
import Form from '../components/Form.vue';

const route = useRoute();
const router = useRouter();

const ticket = ref(null);
const ticketId = Number(route.params.id);

commentStore.actions.getAll();
const comments = commentStore.getters.getCommentsByTicketId(ticketId);
console.log('Comments for ticket', ticketId, comments.value);

const comment = ref({
    ticket_id: ticketId,
    name: '',
    comment: ''
});

const handleSubmit = async (item) => {
    await commentStore.actions.create(item);
    router.push({ name: 'tickets.show' });
};

onMounted(async () => {
    const { data } = await getRequest(`/tickets/${ticketId}`);
    ticket.value = data;
});

const deleteComment = (id) => {
    commentStore.actions.delete(id);
}
</script>

<template>

<div class="min-h-full">
    <header v-if="ticket" class="relative bg-gray-800 after:pointer-events-none after:absolute after:inset-x-0 after:inset-y-0 after:border-y after:border-white/10">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-white">{{ ticket.title }}</h1>
        </div>
    </header>

    <main>
        <section v-if="ticket" class="py-8 bg-white md:py-16 dark:bg-gray-800 antialiased border-b border-white/10">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
                    <div class="mt-6 sm:mt-8 lg:mt-0">
                        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                            {{ ticket.user.name }}
                        </h1>
                        <!-- <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                            <p class="mb-6 text-gray-500 dark:text-gray-400">
                            {{ users.id }}
                            </p>
                        </div> -->

                        <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                        <p class="mb-6 text-gray-500 dark:text-gray-400">
                            {{`to` ticket.title }}
                        </p>
                    </div>
            </div>
        </section>

    <!-- Reviews -->
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
            <div class="max-w-2xl mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Reviews ({{ comments.length }})</h2>
                </div>
                <Form :comment="comment" @submit="handleSubmit" />


                <article
                    v-for="comment in comments"
                    :key="comment.id"
                    class="p-6 text-base bg-white rounded-lg dark:bg-gray-900 mb-4">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                                <img
                                    class="mr-2 w-6 h-6 rounded-full dark:hidden"
                                    :src="'/assets/person-crop-circle-fill-svgrepo-com.svg'"
                                    alt="Profile"
                                />
                                <img
                                    class="mr-2 w-6 h-6 rounded-full hidden dark:block"
                                    :src="'/assets/person-crop-circle-fill-svgrepo-com-dark.svg'"
                                    alt="Profile"
                                />
                                {{ comment.name }}
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
                        {{ comment.comment }}
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
            </div>
        </section>
    </div>
  </main>
</div>
</template>