<script setup lang="ts">
import Form from '../components/Form.vue';
import { useRoute, useRouter } from 'vue-router';
import { ref } from 'vue';
import { noteStore } from '..';

const route = useRoute();
const router = useRouter();

const ticketId = Number(route.query.ticket_id);

const title = "Create note"
const description = "Here you can create the note"

const note = ref({
    description: '',
    ticket_id: ticketId,
});

const handleSubmit = async (item: any) => {
    try {
        await noteStore.actions.create(item);
        router.push({ name: 'ticket.show', params: { ticket: ticketId } });
    } catch (err) {
        console.error(err);
    }
};

</script>

<template>
    <div>
        <Form :note="note" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>