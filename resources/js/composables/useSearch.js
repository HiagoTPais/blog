import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import axios from 'axios';
import { useBlogStore } from '@/stores/blog';

export function useSearch() {
    const store = useBlogStore();
    const showResults = ref(false);

    const performSearch = useDebounceFn(async (query) => {
        if (!query || query.length < 2) {
            store.searchResults = [];
            return;
        }

        store.isSearching = true;
        try {
            const { data } = await axios.get(route('search'), { params: { q: query } });
            store.searchResults = data.data;
            showResults.value = true;
        } catch {
            store.searchResults = [];
        } finally {
            store.isSearching = false;
        }
    }, 300);

    watch(() => store.searchQuery, (query) => {
        performSearch(query);
    });

    function clearSearch() {
        store.searchQuery = '';
        store.searchResults = [];
        showResults.value = false;
    }

    return { showResults, clearSearch };
}
