<script setup>
import { ref } from 'vue';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import FormError from '../../../services/components/FormError.vue';

const props = defineProps({ comment: Object, title: String, description: String });

const emit = defineEmits(['submit', 'cancel']);

const form = ref({ ...props.comment });

const handleSubmit = () => {
    emit('submit', form.value)
};

const cancel = () => {
  emit('cancel', form.value);
};
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
                        <div class="col-span-full">
                                <label for="comment" class="block text-sm/6 font-medium text-white">Comment</label>
                            <div class="mt-2">
                                <textarea v-model="form.comment" id="comment" name="comment" rows="3" required
                                class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"
                                >
                                </textarea>
                            </div>
                        </div>
                        <FormError name="comment" />
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