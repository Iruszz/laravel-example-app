<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { ticketStore } from '..';
import Form from '../components/Form.vue';

const route = useRoute();
const router = useRouter();
const form = ref({ title: '', description: '' });

const ticketId = Number(route.params.id);
ticketStore.actions.getAll();
const ticket = ticketStore.getters.byId(ticketId);

const title = "Edit ticket"
const description = "Here you can edit the ticket"

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/tickets/${id}`);
  form.value.title = data.title;
  form.value.description = data.description;
});

const handleSubmit = async (data) => {
    await ticketStore.actions.update(ticketId, data);
    router.push({ name: 'tickets.overview' });
};
</script>

<template>
  <Form v-if="ticket" :ticket="ticket" @submit="handleSubmit" :title="title" :description="description" />
</template>
