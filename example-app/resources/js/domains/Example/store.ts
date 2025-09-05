import axios from 'axios';
import { ref, computed } from 'vue';
import { getRequest } from '../../services/http';

// state
const examples = ref([]);

// getters
export const getAllExamples = computed(() => examples.value);

// actions
export const fetchExamples = async () => {
    const {data} = await getRequest('/examples');
    if(!data) return;
    examples.value = data;
};

export const createExample = async (newExample) => {
    const {data} = await axios.post('/api/examples', newExample);
    if(!data) return
    examples.value = data;
};

export const getExampleById = (id) => computed(() => examples.value.find(example => example.id == id));

export const updateExample = async (id, updatedExample) => {
    const { data } = await axios.put(`/api/examples/${id}`, updatedExample);
    if (!data) return;
    examples.value = data;
};

export const deleteExample = async (id) => {
    await axios.delete(`/api/examples/${id}`);
    examples.value = examples.value.filter(example => example.id !== id);
};