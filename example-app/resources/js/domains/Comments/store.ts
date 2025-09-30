import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

interface Comment {
  id: number;
  comment: string;
  user_id: number;
  ticket_id: number;
  created_at?: string;
  updated_at?: string;
}

// state
const comments = ref<Comment[]>([]);

// getters
export const getAllComments = computed(() => comments.value);

export const getCommentsByTicketId = (ticketId: number) =>
  computed(() => comments.value.filter(comment => comment.ticket_id === ticketId));

// actions
export const fetchComments = async () => {
    const {data} = await getRequest('/comments');
    if(!data) return;
    comments.value = data.data;
};

export const fetchCommentsForTicket = async (ticketId: number) => {
  const { data } = await getRequest(`/comments?ticket_id=${ticketId}`);
  if (!data) return;
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