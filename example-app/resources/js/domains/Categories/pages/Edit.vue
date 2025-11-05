<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { categoryStore } from '..';
import Form from '../components/Form.vue';

const route = useRoute();
const router = useRouter();
const form = ref({ title: '', description: '' });

const categoryId = Number(route.params.id);
categoryStore.actions.getAll();
const category = categoryStore.getters.byId(categoryId);

const title = "Edit category"
const description = "Here you can edit the category"

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/categories/${id}`);
  form.value.title = data.title;
  form.value.description = data.description;
});

const handleSubmit = async (data) => {
    await categoryStore.actions.update(categoryId, data);
    router.push({ name: 'categories.overview' });
};
</script>

<template>
  <Form v-if="category" :category="category" @submit="handleSubmit" :title="title" :description="description" />
</template>
