<template>
  <div
    v-if="getMessage.value"
    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"
    role="alert"
  >
    {{ getMessage.value }}
  </div>
</template>

<script setup lang="ts">
import { getMessage } from '../error';
</script>
