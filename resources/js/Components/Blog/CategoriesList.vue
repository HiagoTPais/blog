<script setup>
import { Link } from '@inertiajs/vue3';
import SidebarWidget from './SidebarWidget.vue';
import { blogRoute } from '@/helpers/routes';

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <SidebarWidget title="categories">
        <ul class="space-y-2">
            <li v-for="category in categories" :key="category.id">
                <Link
                    v-if="category.slug"
                    :href="blogRoute('categories.show', { category: category.slug })"
                    class="flex items-center justify-between text-sm group"
                >
                    <span class="text-cyber-muted group-hover:text-cyber-primary transition-colors font-mono">
                        {{ category.name }}
                    </span>
                    <span class="text-xs text-cyber-muted bg-cyber-bg px-2 py-0.5 rounded">
                        {{ category.posts_count }}
                    </span>
                </Link>
                <div v-else class="flex items-center justify-between text-sm">
                    <span class="text-cyber-muted font-mono">{{ category.name }}</span>
                    <span class="text-xs text-cyber-muted bg-cyber-bg px-2 py-0.5 rounded">
                        {{ category.posts_count }}
                    </span>
                </div>
            </li>
        </ul>
    </SidebarWidget>
</template>
