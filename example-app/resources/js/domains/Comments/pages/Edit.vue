<script setup>
import { useRoute, useRouter } from 'vue-router';
import Form from '../components/Form.vue';
import { commentStore } from '..';

const route = useRoute();
const router = useRouter();

const title = "Edit comment"
const description = "Here you can edit the comment"

const commentId = Number(route.params.id);

commentStore.actions.getAll();

const comment = commentStore.getters.getById(commentId);

const handleSubmit = async (updatedComment) => {
    await commentStore.actions.update(commentId, updatedComment);
    router.push({ name: 'tickets.show', params: { id: updatedComment.ticket_id }})
};

const cancel = (comment) => {
    router.push({ name: 'tickets.show', params: { id: comment.ticket_id }})
};

</script>

<template>
    <div>
        <Form v-if="comment" :comment="comment" @cancel="cancel" @submit="handleSubmit" :title="title" :description="description" />
    </div>
</template>