import { ref, computed } from 'vue';
import { getRequest, postRequest, putRequest, deleteRequest } from '../../services/http';

export const storeModuleFactory = (moduleName) => {
    const state = ref([]);

    const getters = {
        all: computed(() => state.value), 
        getById: (id: number) => computed(() => state.value.find(item => item.id === id)),
    };

    const setters = {
        setAll: (items) => {
            if (Array.isArray(items)) {
                state.value = items.map(item => ({ ...item }));
            } else if (items && typeof items === 'object') {
                state.value = [{ ...items }];
            } else {
                state.value = [];
            }
        },
        deleteByItem: (item) => {
            state.value = state.value.filter(i => i.id !== item.id);
        },
    };

    const actions = {
        getAll: async () => {
            const { data } = await getRequest(moduleName);
            if (!data) return;
            setters.setAll(data);
        },

        create: async (item) => {
            const { data } = await postRequest(moduleName, item);
            if (!data) return;
            setters.setAll(data);
        },

        update: async (id, item) => {
            const { data } = await putRequest(`${moduleName}/${id}`, item);
            if (!data) return;
            setters.setAll(data);
        },

        delete: async (id) => {
            await deleteRequest(`${moduleName}/${id}`);
            setters.deleteByItem({ id });
        }
    };

    return { getters, setters, actions };
}