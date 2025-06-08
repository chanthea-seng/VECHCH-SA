import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useLoadingStore = defineStore('loadingStore', () => {
  const loading = ref(false);  // Global loading state
  
  const setLoading = (status) => {
    loading.value = status;
  };

  return {
    loading,
    setLoading,
  };
});
