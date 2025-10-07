<template>
  <div class="fixed top-5 right-5 space-y-2 z-50">
    <div
      v-for="toast in toastStore.toasts.filter(t => t.message)"
      :key="toast.id"
      :class="['px-4 py-2 rounded shadow-lg text-white', toastTypeClass(toast.type)]"
    >
      {{ toast.message }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { toastStore } from '../toast';

const toastTypeClass = (type: string) => {
  switch (type) {
    case 'success': return 'bg-green-500';
    case 'error': return 'bg-red-500';
    case 'info': return 'bg-blue-500';
    default: return 'bg-gray-500';
  }
};
</script>