<script setup>
import { Link } from '@inertiajs/vue3';
import SidebarWidget from './SidebarWidget.vue';
import { blogRoute } from '@/helpers/routes';

defineProps({
    tags: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <SidebarWidget title="popular_tags">
        <div class="flex flex-wrap gap-2">
            <template v-for="tag in tags" :key="tag.id">
                <Link
                    v-if="tag.slug"
                    :href="blogRoute('tags.show', { tag: tag.slug })"
                    class="cyber-tag"
                >
                    #{{ tag.name }}
                    <span class="ml-1 text-cyber-muted">({{ tag.posts_count }})</span>
                </Link>
            </template>
        </div>
    </SidebarWidget>
</template>
