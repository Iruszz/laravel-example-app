<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getRequest } from '../../../services/http';

const route = useRoute();
const ticket = ref(null);

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/tickets/${id}`);
  ticket.value = data;
});
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
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                <img class="w-full dark:hidden" :src="`/assets/ticket-2-svgrepo-com.svg`" alt="" />
                <img class="w-full hidden dark:block" :src="`/assets/ticket-2-svgrepo-com-dark.svg`" alt="" />
                </div>

                <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                    {{ ticket.title }}
                </h1>
                <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                    <p
                    class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white"
                    >
                    $14,45
                    </p>

                    <div class="flex items-center gap-2 mt-2 sm:mt-0">
                    <div class="flex items-center gap-1">
                        <svg
                        class="w-4 h-4 text-yellow-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                        />
                        </svg>
                        <svg
                        class="w-4 h-4 text-yellow-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                        />
                        </svg>
                        <svg
                        class="w-4 h-4 text-yellow-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                        />
                        </svg>
                        <svg
                        class="w-4 h-4 text-yellow-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                        />
                        </svg>
                        <svg
                        class="w-4 h-4 text-yellow-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        >
                        <path
                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"
                        />
                        </svg>
                    </div>
                    <p
                        class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400"
                    >
                        (5.0)
                    </p>
                    <a
                        href="#"
                        class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white"
                    >
                        345 Reviews
                    </a>
                    </div>
                </div>

                <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                    <a
                    href="#"
                    title=""
                    class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    role="button"
                    >
                    <svg
                        class="w-5 h-5 -ms-2 me-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"
                        />
                    </svg>
                    Add to favorites
                    </a>
                </div>

                <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

                <!-- <p class="mb-6 text-gray-500 dark:text-gray-400">
                    {{ category.title }}
                </p> -->
                </div>
            </div>
            </div>
        </section>

    <!-- Reviews -->
    <!-- <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
            <div class="max-w-2xl mx-auto px-4">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Reviews ({{ reviews.length }})</h2>
                </div>
                <Form :review="review" @submit="handleSubmit" />


                <article
                    v-for="review in reviews"
                    :key="review.id"
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
                                {{ review.name }}
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
                        {{ review.review }}
                    </p>
                    <div class="flex items-center mt-4 space-x-4">
                        <RouterLink :to="{ name: 'reviews.edit', params: { id: review.id } }"
                            class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                            </svg>
                            Edit
                        </RouterLink>
                        <button @click="deleteReview(review.id)" type="button"
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
    </div> -->
  </main>
</div>
</template>