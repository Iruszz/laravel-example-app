 import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

interface Comment {
  id: number;
  user_id: number;
  comment: string;
  ticket_id: number;
  created_at?: string;
  updated_at?: string;
  recipient_id: number;
}

// state
const comments = ref<Comment[]>([]);

// getters
export const getAllComments = computed(() => comments.value);

// actions
export const fetchComments = async () => {
    const { data } = await getRequest('/comments');
    if (!data) return;
    comments.value = data;
};

export const addComment = (comment: Comment) => {
    comments.value = [...comments.value, comment];
};

export const createComment = async (newComment: Omit<Comment, 'id'>) => {
    const { data } = await axios.post('/api/comments', newComment);
    if (!data) return;
    addComment(data);
};

export const getCommentById = (id: number) =>
    computed(() => comments.value.find(comment => comment.id === id));

export const updateComment = async (id: number, updatedComment: Comment) => {
    const { data } = await axios.put(`/api/comments/${id}`, updatedComment);
    if (!data) return;

    const index = comments.value.findIndex(c => c.id === data.id);
    if (index !== -1) {
        comments.value[index] = { ...data }; // update existing
    } else {
        comments.value.push({ ...data }); // append if new
    }
};

export const deleteComment = async (id: number) => {
    await axios.delete(`/api/comments/${id}`);
    comments.value = comments.value.filter(comment => comment.id !== id);
};
