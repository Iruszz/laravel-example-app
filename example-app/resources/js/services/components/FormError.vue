<template>
    <div v-for="error in getErrorByProperty(name).value" :key="error">
        {{ error }}
    </div>
</template>

<script setup lang="ts">
import { getErrorByProperty } from '../error';

defineProps<{ name: string }>();
</script> 