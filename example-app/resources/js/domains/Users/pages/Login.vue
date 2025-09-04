<template></template>

<script setup>
import { onMounted } from 'vue';
import { fetchUsers } from '../store';

fetchUsers();
</script>