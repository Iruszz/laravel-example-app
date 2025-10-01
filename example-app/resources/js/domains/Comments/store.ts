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
}

// state
const comments = ref<Comment[]>([]);

// getters
export const getAllComments = computed(() => comments.value);

// actions
export const fetchComments = async () => {
    const {data} = await getRequest('/comments');
    if(!data) return;
    comments.value = data.data;
};

export const addComment = (comment) => {
    comments.value = [...comments.value, comment];
};

export const createComment = async (newComment: Omit<Comment, 'id'>) => {
  const { data } = await axios.post('/api/comments', newComment);
  if (!data) return;
  addComment(data);
};

export const getCommentById = (id) => computed(() => comments.value.find(comment => comment.id == id));

export const updateComment = async (id, updatedComment) => {
    const { data } = await axios.put(`/api/comments/${id}`, updatedComment);
    if (!data) return;
    comments.value = data;
};

export const deleteComment = async (id) => {
    await axios.delete(`/api/comments/${id}`);
    comments.value = comments.value.filter(comment => comment.id !== id);
};