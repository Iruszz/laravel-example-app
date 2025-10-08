import { onMounted, nextTick } from 'vue';
import { initFlowbite, refreshFlowbite } from 'flowbite';

export function useFlowbite() {
  // Run on mount
  onMounted(() => {
    initFlowbite();
  });

  // Return a refresh function for dynamic content
  const refresh = async () => {
    await nextTick(); // wait for DOM updates
    refreshFlowbite();
  };

  return { refresh };
}
