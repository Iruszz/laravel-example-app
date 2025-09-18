<script setup>
import Form from '../components/Form.vue';
import { storeModuleFactory } from '../../../services/store';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { ticketStore } from '..';

const router = useRouter();

const title = "Create ticket"
const description = "Here you can create the ticket"

const ticket = ref({
    title: '',
    // user_id: ,
    category_id: null,
    status_id: 1
});

const handleSubmit = async (item) => {
    await ticketStore.actions.create(item);
    router.push({name: 'tickets.overview'});
};
</script>

<template>
    <div>
        <Form :ticket="ticket" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>