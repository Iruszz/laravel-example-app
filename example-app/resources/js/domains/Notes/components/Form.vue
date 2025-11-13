<script setup>
import { ref } from 'vue';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import FormError from '../../../services/components/FormError.vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const ticketId = Number(route.query.ticket_id);

const props = defineProps({ note: Object, title: String, description: String });

const emit = defineEmits(['submit']);

const formData = ref({ ...props.note });

const handleSubmit = () => emit('submit', formData.value);

function cancel() {
  router.push({ name: 'ticket.show', params: { ticket: ticketId } });
}
</script>

<template>
  <div class="px-4 py-16 sm:px-6 sm:py-24">
  <div class="flex justify-center">
    <form class="w-full sm:max-w-[1100px] lg:max-w-[700px]" @submit.prevent="handleSubmit">
      <div class="space-y-12">
        <ErrorMessage />

        <div class="border-b border-white/10 pb-12">
          <h2 class="text-base/7 font-semibold text-white">{{ title }}</h2>
          <p class="mt-1 text-sm/6 text-gray-400">{{ description }}</p>

          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6 flex justify-center">
              <div class="w-full">
                <label for="description" class="block text-sm/6 font-medium text-white">Description</label>
                <textarea
                  v-model="formData.description"
                  id="description"
                  name="description"
                  autocomplete="given-name"
                  rows="6"
                  required
                  class="mt-2 block w-full max-w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6">
                </textarea>
                <FormError name="description" />
              </div>
            </div>
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