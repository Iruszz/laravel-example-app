<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Ticket Details</h1>
    <div v-if="ticket">
      <p><strong>ID:</strong> {{ ticket.id }}</p>
      <p><strong>Title:</strong> {{ ticket.title }}</p>
      <p><strong>Description:</strong> {{ ticket.description }}</p>
      <!-- Add more fields as needed -->
    </div>
    <div v-else>
      Loading...
    </div>
  </div>
</template>

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
