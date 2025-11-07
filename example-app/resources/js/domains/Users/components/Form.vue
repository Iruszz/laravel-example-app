<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { userStore } from '../index';
import ErrorMessage from '../../../services/components/ErrorMessage.vue';
import FormError from '../../../services/components/FormError.vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const props = defineProps<{ user: any; title: string; description: string }>();
const emit = defineEmits(['submit']);

const formData = ref({
  name: props.user?.name || '',
  email: props.user?.email || '',
  phone: props.user?.phone || '',
  user_role_id: props.user?.role_id || props.user?.role?.id || null,
});

const allUsers = computed(() => userStore.getters.all.value);
const roles = computed(() => {
  // get unique roles from all users
  const map = new Map();
  allUsers.value.forEach(u => u.role && !map.has(u.role.id) && map.set(u.role.id, u.role));
  return Array.from(map.values());
});

const handleSubmit = () => emit('submit', formData.value);

function cancel() {
  router.push({ name: 'users.overview' });
}
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <ErrorMessage />

      <!-- User Name -->
      <div>
        <label for="name" class="block text-sm font-medium text-white">User</label>
        <input v-model="formData.name" id="name" type="text" required
               class="block w-full rounded-md bg-white/5 px-3 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500"/>
        <FormError name="name" />
      </div>

      <!-- User Role -->
      <div>
        <label for="role" class="block text-sm font-medium text-white">User Role</label>
        <select v-model="formData.user_role_id" id="role" required
                class="block w-full rounded-md bg-white/5 px-3 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
          <option value="" disabled>Select a role</option>
          <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
        </select>
        <FormError name="user_role_id" />
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-white">Email</label>
        <input v-model="formData.email" id="email" type="email" required
               class="block w-full rounded-md bg-white/5 px-3 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500"/>
        <FormError name="email" />
      </div>

      <!-- Phone -->
      <div>
        <label for="phone" class="block text-sm font-medium text-white">Phone number</label>
        <input v-model="formData.phone" id="phone" type="tel"
               class="block w-full rounded-md bg-white/5 px-3 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500"/>
        <FormError name="phone" />
      </div>

      <div class="flex justify-end gap-4">
        <button type="button" @click="cancel" class="text-sm font-semibold text-white">Cancel</button>
        <button type="submit" class="rounded-md bg-indigo-500 px-4 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
      </div>
    </form>
  </div>
</template>
