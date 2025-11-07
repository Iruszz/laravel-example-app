<script setup lang="ts">
import Form from '../components/Form.vue';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { ticketStore } from '..';

const router = useRouter();

const title = "Create ticket"
const description = "Here you can create the ticket"

const ticket = ref({
    title: '',
    category_id: null,
    agent_id: null,
});

const handleSubmit = async (item: any) => {
    try {
        await ticketStore.actions.create(item);
        router.push({ name: 'tickets.overview' });
    } catch (err) {
        console.error(err);
    }
};

</script>

<template>
    <div>
        <Form :ticket="ticket" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>