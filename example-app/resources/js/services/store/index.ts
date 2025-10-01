import { ref, computed } from 'vue';
import { getRequest, postRequest, putRequest, deleteRequest } from '../../services/http';

export const storeModuleFactory = (moduleName) => {
    const state = ref({});

    const getters = {
        all: computed(() => state.value),
        getById: (id: number) => computed(() => state.value[id]),
    };
    console.log('all data', getters.all.value);

    const setters = {
        setAll: (items) => {
            const newState = {};
            for (const item of items) {
                newState[item.id] = Object.freeze(item);
            }
            state.value = newState;
        },
        deleteByItem: (item) => {
            const newState = { ...state.value };
            delete newState[item.id];
            state.value = newState;
        }
    };

    const actions = {
        getAll: async () => {
            const { data } = await getRequest(moduleName);
            if (!data) return;
            setters.setAll(data);
            console.log('getAll data', data);
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