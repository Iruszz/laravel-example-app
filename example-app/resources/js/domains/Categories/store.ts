import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

// state
const categories = ref([]);

// getters
export const getAllCategories = computed(() => categories.value);

// actions
export const fetchCategories = async () => {
    const {data} = await getRequest('/categories');
    if(!data) return;
    categories.value = data;
};

export const createCategory = async (newCategory) => {
    const {data} = await axios.post('/api/categories', newCategory);
    if(!data) return
    categories.value = data;
};

export const getCategoryById = (id) => computed(() => categories.value.find(category => category.id == id));

export const updateCategory = async (id, updatedCategory) => {
    const { data } = await axios.put(`/api/categories/${id}`, updatedCategory);
    if (!data) return;
    categories.value = data;
};

export const deleteCategory = async (id) => {
    await axios.delete(`/api/categories/${id}`);
    categories.value = categories.value.filter(category => category.id !== id);
};