<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { ticketStore } from '../../Tickets/index';
import { userStore } from '../../Auth/index';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import FormError from '../../../services/components/FormError.vue';
import { useRoute, useRouter } from 'vue-router';
// import { getAllAgents } from '../store';
import type { Ticket } from '../../Tickets/types';

const router = useRouter();
const route = useRoute();

const ticketId = Number(route.params.id);
const ticket = ticketStore.getters.byId(ticketId);

userStore.actions.getAll();

const formData = ref<{ agent_id: number | null }>({ agent_id: null });

const title = "Assign agent"
const description = "Here you can assign the agent"

onMounted(() => {
  const t = ticket.value as Ticket | undefined;
  if (t) {
    formData.value.agent_id = t.agent_id ?? null;
  }
});

const emit = defineEmits(['submit']);

const handleSubmit = async () => {
    await ticketStore.actions.assignAgentToTicket(ticketId, formData.value.agent_id);
    router.push({ name: 'tickets.overview' });
};

function cancel() {
  router.push({ name: 'tickets.overview' })
}
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-2 xl:gap-x-8">
        <form @submit.prevent="handleSubmit">
            <div class="space-y-12">
                <ErrorMessage />
                <div class="border-b border-white/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-white">{{ title }}</h2>
                    <p class="mt-1 text-sm/6 text-gray-400">{{ description }}</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="user" class="block text-sm/6 font-medium text-white">Agent</label>
                            <div class="mt-2 grid grid-cols-1">
                                <select v-model="formData.agent_id" id="user" title="user" required
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white/5 py-1.5 pr-8 pl-3 text-base text-white outline-1 -outline-offset-1 outline-white/10 *:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                >
                                    <option v-for="agent in userStore.getters.getAllAgents.value" :key="agent.id" :value="agent.id">
                                        {{ agent.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <FormError name="ticket.title" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" @click="cancel" class="text-sm/6 font-semibold text-white">Cancel</button>
                <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
            </div>
        </form>
    </div>
  </div>
</template>