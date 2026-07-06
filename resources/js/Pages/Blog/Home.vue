<script setup>
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';
import PostCard from '@/Components/Blog/PostCard.vue';
import RecentPosts from '@/Components/Blog/RecentPosts.vue';
import CategoriesList from '@/Components/Blog/CategoriesList.vue';
import PopularTags from '@/Components/Blog/PopularTags.vue';
import Pagination from '@/Components/Blog/Pagination.vue';

defineProps({
    posts: Object,
    recentPosts: Array,
    categories: Array,
    popularTags: Array,
    seo: Object,
});
</script>

<template>
    <BlogLayout :breadcrumbs="[{ label: 'Home', href: 'home' }]">
        <SeoHead :seo="seo" />

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Main content -->
            <div class="xl:col-span-2 space-y-6">
                <div v-if="posts.data?.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <PostCard v-for="post in posts.data" :key="post.id" :post="post" />
                </div>

                <div v-else class="cyber-card p-12 text-center">
                    <p class="text-cyber-muted font-mono">Nenhum artigo publicado ainda.</p>
                </div>

                <Pagination :links="posts.meta?.links ?? posts.links" :meta="posts.meta" />
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <RecentPosts :posts="recentPosts" />
                <CategoriesList :categories="categories" />
                <PopularTags :tags="popularTags" />
            </aside>
        </div>
    </BlogLayout>
</template>
