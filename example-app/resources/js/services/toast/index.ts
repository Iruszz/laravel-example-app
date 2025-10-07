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
      this.toasts = this.toasts.filter(t => t.id !== id);
    }, duration);
  },

  remove(id: number) {
    this.toasts = this.toasts.filter(t => t.id !== id);
  },
});