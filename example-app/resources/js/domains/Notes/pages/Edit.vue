<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { noteStore } from '..';
import Form from '../components/Form.vue';

const route = useRoute();
const router = useRouter();
const form = ref({ title: '', description: '' });

const ticketId = Number(route.query.ticket_id);
const noteId = Number(route.params.id);
const note = noteStore.getters.byId(noteId);

const title = "Edit note"
const description = "Here you can edit the note"

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/notes/${id}`);
  form.value.title = data.title;
  form.value.description = data.description;
});

const handleSubmit = async (data) => {
    await noteStore.actions.update(noteId, data);
    router.push({ name: 'ticket.show', params: { ticket: ticketId } });
};
</script>

<template>
  <Form v-if="note" :note="note" @submit="handleSubmit" :title="title" :description="description" />
</template>
