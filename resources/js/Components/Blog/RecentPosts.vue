<script setup>
import { Link } from '@inertiajs/vue3';
import { formatDate } from '@/helpers/formatDate';
import { blogRoute } from '@/helpers/routes';
import SidebarWidget from './SidebarWidget.vue';

defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <SidebarWidget title="recent_posts">
        <ul class="space-y-3">
            <li v-for="post in posts" :key="post.id">
                <Link
                    v-if="post.slug"
                    :href="blogRoute('posts.show', { post: post.slug })"
                    class="block group"
                >
                    <p class="text-sm text-cyber-text group-hover:text-cyber-primary transition-colors line-clamp-2">
                        {{ post.title }}
                    </p>
                    <p class="text-xs text-cyber-muted mt-1">{{ formatDate(post.published_at) }}</p>
                </Link>
            </li>
        </ul>
    </SidebarWidget>
</template>
