<script setup>
import Form from '../components/Form.vue';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import { commentStore } from '..';

const router = useRouter();

const title = "Create comment"
const description = "Here you can create the comment"

const comment = ref({
    title: '',
    summary: '',
    comment_id: null
});

const handleSubmit = async (item) => {
    await commentStore.actions.create(item);
    router.push({name: 'comments.overview'});
};
</script>

<template>
    <div>
        <Form :comment="comment" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>