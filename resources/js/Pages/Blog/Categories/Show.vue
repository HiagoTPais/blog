<script setup>
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';
import PostCard from '@/Components/Blog/PostCard.vue';
import Pagination from '@/Components/Blog/Pagination.vue';

defineProps({
    category: Object,
    posts: Object,
    seo: Object,
});
</script>

<template>
    <BlogLayout
        :breadcrumbs="[
            { label: 'Home', href: 'home' },
            { label: 'Categorias', href: 'categories.index' },
            { label: category.name },
        ]"
    >
        <SeoHead :seo="seo" />

        <div class="space-y-6">
            <div class="cyber-card p-6">
                <h1 class="text-2xl font-bold text-cyber-text">{{ category.name }}</h1>
                <p v-if="category.description" class="mt-2 text-cyber-muted">{{ category.description }}</p>
            </div>

            <div v-if="posts.data?.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <PostCard v-for="post in posts.data" :key="post.id" :post="post" />
            </div>

            <div v-else class="cyber-card p-12 text-center">
                <p class="text-cyber-muted font-mono">Nenhum artigo nesta categoria.</p>
            </div>

            <Pagination :links="posts.meta?.links ?? posts.links" />
        </div>
    </BlogLayout>
</template>
