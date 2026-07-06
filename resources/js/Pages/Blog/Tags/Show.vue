<script setup>
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';
import PostCard from '@/Components/Blog/PostCard.vue';
import Pagination from '@/Components/Blog/Pagination.vue';

defineProps({
    tag: Object,
    posts: Object,
    seo: Object,
});
</script>

<template>
    <BlogLayout
        :breadcrumbs="[
            { label: 'Home', href: 'home' },
            { label: `#${tag.name}` },
        ]"
    >
        <SeoHead :seo="seo" />

        <div class="space-y-6">
            <div class="cyber-card p-6">
                <h1 class="font-mono text-2xl text-cyber-primary">
                    <span class="text-cyber-muted">#</span>{{ tag.name }}
                </h1>
                <p class="mt-2 text-cyber-muted">Artigos marcados com esta tag.</p>
            </div>

            <div v-if="posts.data?.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <PostCard v-for="post in posts.data" :key="post.id" :post="post" />
            </div>

            <div v-else class="cyber-card p-12 text-center">
                <p class="text-cyber-muted font-mono">Nenhum artigo com esta tag.</p>
            </div>

            <Pagination :links="posts.meta?.links ?? posts.links" />
        </div>
    </BlogLayout>
</template>
