<script setup>
import { computed } from 'vue';

const statusColors = {
    'yellow-500': { text: 'text-yellow-500', bg: 'bg-yellow-900' },
    'green-500': { text: 'text-green-500', bg: 'bg-green-900' },
};

const props = defineProps({ ticket: Object });
</script>

<template>
<span
    class="inline-flex items-center rounded-md justify-center w-23 h-7 text-xs font-medium"
    :class="[statusColors[ticket.status.color].text, statusColors[ticket.status.color].bg]"
    >
    <!-- Yellow (pending) -->
    <svg v-if="ticket.status.color === 'yellow-500'" class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M5.5 3a1 1 0 0 0 0 2H7v2.3c0 .7.2 1.3.6 1.8L9 11.9l.1.1v.1L7.5 15a3 3 0 0 0-.6 1.8V19H5.5a1 1 0 1 0 0 2h13a1 1 0 1 0 0-2H17v-2.3a3 3 0 0 0-.6-1.8l-1.6-2.8v-.2l1.6-2.8a3 3 0 0 0 .6-1.8V5h1.5a1 1 0 1 0 0-2h-13Z" clip-rule="evenodd"/>
    </svg>

    <!-- Green (solved) -->
    <svg v-if="ticket.status.color === 'green-500'" class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M9 2a1 1 0 0 0-1 1H6a2 2 0 0 0-2 2v15c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-2c0-.6-.4-1-1-1H9Zm1 2h4v2h1a1 1 0 1 1 0 2H9a1 1 0 0 1 0-2h1V4Zm5.7 8.7a1 1 0 0 0-1.4-1.4L11 14.6l-1.3-1.3a1 1 0 0 0-1.4 1.4l2 2c.4.4 1 .4 1.4 0l4-4Z" clip-rule="evenodd"/>
    </svg>

    {{ ticket.status?.name || 'No status' }}
</span>
</template>