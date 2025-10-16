import { reactive } from 'vue';

interface Toast {
  id: number;
  message: string;
  type: 'success' | 'error' | 'info';
}

export const toastStore = reactive({
  toasts: [] as Toast[],
  nextId: 1,

  add(message: string, type: 'success' | 'error' | 'info' = 'info', duration = 3000) {
    const id = this.nextId++;
    this.toasts.push({ id, message, type });

    setTimeout(() => {
      const index = this.toasts.findIndex(t => t.id === id);
      if (index !== -1) this.toasts.splice(index, 1);
    }, duration);
  },

  remove(id: number) {
    const index = this.toasts.findIndex(t => t.id === id);
    if (index !== -1) this.toasts.splice(index, 1);
  },
});