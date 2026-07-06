<script setup>
import { computed, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import { Menu, Search, Loader2, X } from 'lucide-vue-next';
import { useBlogStore } from '@/stores/blog';
import { useSearch } from '@/composables/useSearch';
import { blogRoute, breadcrumbHref } from '@/helpers/routes';

const props = defineProps({
    breadcrumbs: {
        type: Array,
        default: () => [{ label: 'Home', href: 'home' }],
    },
});

const store = useBlogStore();
const { showResults, clearSearch } = useSearch();
const searchFocused = ref(false);

const hasResults = computed(() => store.searchResults.length > 0);

const breadcrumbItems = computed(() =>
    props.breadcrumbs.map((crumb, index) => ({
        label: crumb.label,
        href:
            crumb.href && index < props.breadcrumbs.length - 1
                ? breadcrumbHref(crumb)
                : null,
    })),
);
</script>

<template>
    <header class="sticky top-0 z-30 bg-cyber-bg/95 backdrop-blur-sm border-b border-cyber-border">
        <div class="flex items-center justify-between gap-4 px-4 py-3 lg:px-6">
            <!-- Left: menu + breadcrumb -->
            <div class="flex items-center gap-3 min-w-0">
                <button
                    class="lg:hidden text-cyber-muted hover:text-cyber-text"
                    @click="store.toggleSidebar()"
                >
                    <Menu class="w-5 h-5" />
                </button>

                <nav class="flex items-center gap-1.5 text-sm min-w-0 overflow-hidden">
                    <template v-for="(item, index) in breadcrumbItems" :key="index">
                        <span v-if="index > 0" class="text-cyber-border shrink-0">/</span>
                        <Link
                            v-if="item.href"
                            :href="item.href"
                            class="text-cyber-muted hover:text-cyber-primary font-mono truncate transition-colors"
                        >
                            {{ item.label }}
                        </Link>
                        <span
                            v-else
                            class="text-cyber-text font-mono truncate"
                        >
                            {{ item.label }}
                        </span>
                    </template>
                </nav>
            </div>

            <!-- Right: search -->
            <div class="relative w-full max-w-xs sm:max-w-sm">
                <div class="relative">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-cyber-muted" />
                    <input
                        v-model="store.searchQuery"
                        type="search"
                        placeholder="Buscar posts, tags..."
                        class="cyber-input w-full pl-9 pr-9 py-2 text-sm"
                        @focus="searchFocused = true"
                        @blur="setTimeout(() => { searchFocused = false; showResults = false }, 200)"
                    />
                    <button
                        v-if="store.searchQuery"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-cyber-muted hover:text-cyber-text"
                        @click="clearSearch"
                    >
                        <X class="w-4 h-4" />
                    </button>
                    <Loader2
                        v-if="store.isSearching"
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-cyber-primary animate-spin"
                    />
                </div>

                <!-- Search results dropdown -->
                <div
                    v-if="(searchFocused || showResults) && store.searchQuery.length >= 2"
                    class="absolute top-full mt-1 w-full cyber-card shadow-xl z-50 max-h-80 overflow-y-auto"
                >
                    <div v-if="store.isSearching" class="p-4 text-sm text-cyber-muted text-center">
                        Buscando...
                    </div>
                    <div v-else-if="hasResults" class="py-1">
                        <button
                            v-for="post in store.searchResults"
                            :key="post.id"
                            class="w-full text-left px-4 py-3 hover:bg-cyber-bg transition-colors border-b border-cyber-border last:border-0"
                            @mousedown.prevent="post.slug && router.visit(blogRoute('posts.show', { post: post.slug }))"
                        >
                            <p class="text-sm font-medium text-cyber-text truncate">{{ post.title }}</p>
                            <p class="text-xs text-cyber-muted mt-0.5 truncate">{{ post.excerpt }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span v-if="post.category" class="text-xs text-cyber-primary font-mono">{{ post.category.name }}</span>
                                <span
                                    v-for="tag in (post.tags ?? []).slice(0, 2)"
                                    :key="tag.id"
                                    class="text-xs text-cyber-muted font-mono"
                                >
                                    #{{ tag.name }}
                                </span>
                            </div>
                        </button>
                    </div>
                    <div v-else class="p-4 text-sm text-cyber-muted text-center">
                        Nenhum resultado encontrado.
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
