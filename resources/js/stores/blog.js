import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useBlogStore = defineStore('blog', () => {
    const sidebarOpen = ref(false);
    const searchQuery = ref('');
    const searchResults = ref([]);
    const isSearching = ref(false);

    function toggleSidebar() {
        sidebarOpen.value = !sidebarOpen.value;
    }

    function closeSidebar() {
        sidebarOpen.value = false;
    }

    return {
        sidebarOpen,
        searchQuery,
        searchResults,
        isSearching,
        toggleSidebar,
        closeSidebar,
    };
});
