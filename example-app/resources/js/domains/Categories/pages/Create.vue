<script setup lang="ts">
import Form from '../components/Form.vue';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { categoryStore } from '..';

const router = useRouter();

const title = "Create category"
const description = "Here you can create the category"

const category = ref({
    title: '',
    category_id: null,
    agent_id: null,
});

const handleSubmit = async (item: any) => {
    try {
        await categoryStore.actions.create(item);
        router.push({ name: 'categories.overview' });
    } catch (err) {
        console.error(err);
    }
};

</script>

<template>
    <div>
        <Form :category="category" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>