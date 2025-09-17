<template>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Ticket</h1>
    <form @submit.prevent="handleSubmit">
      <div class="mb-4">
        <label class="block mb-1 font-medium">Title</label>
        <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2" required />
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-medium">Description</label>
        <textarea v-model="form.description" class="w-full border rounded px-3 py-2" required></textarea>
      </div>
      <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-400">Save</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest, putRequest } from '../../../services/http';
import { ticketStore } from '..';

const route = useRoute();
const router = useRouter();
const form = ref({ title: '', description: '' });

const ticketId = Number(route.params.id);
ticketStore.actions.getAll();
const ticket = ticketStore.getters.getById(ticketId);

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/tickets/${id}`);
  form.value.title = data.title;
  form.value.description = data.description;
});

const handleSubmit = async () => {
  const id = route.params.id;
  await putRequest(`/tickets/${id}`, form.value);
  router.push({ name: 'tickets.show', params: { id } });
};
</script>
