<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getRequest } from '../../../services/http';
import { userStore } from '..';
import Form from '../components/Form.vue';

const route = useRoute();
const router = useRouter();
const form = ref({ title: '', description: '' });

const userId = Number(route.params.id);
userStore.actions.getAll();
const user = userStore.getters.byId(userId);

const title = "Edit user"
const description = "Here you can edit the user"

onMounted(async () => {
  const id = route.params.id;
  const { data } = await getRequest(`/users/${id}`);
  form.value.title = data.title;
  form.value.description = data.description;
});

const handleSubmit = async (data) => {
    await userStore.actions.update(userId, data);
    router.push({ name: 'users.overview' });
};
</script>

<template>
  <Form v-if="user" :user="user" @submit="handleSubmit" :title="title" :description="description" />
</template>
