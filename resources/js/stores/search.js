import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useSearchStore = defineStore('search', () => {
    const isOpen = ref(false);
    const query = ref('');

    function open() {
        isOpen.value = true;
    }

    function close() {
        isOpen.value = false;
        query.value = '';
    }

    return { isOpen, query, open, close };
});
