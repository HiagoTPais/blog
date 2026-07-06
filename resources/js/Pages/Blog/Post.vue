<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Clock, Eye, User, Calendar } from 'lucide-vue-next';
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';
import MarkdownRenderer from '@/Components/Blog/MarkdownRenderer.vue';
import TableOfContents from '@/Components/Blog/TableOfContents.vue';
import ShareButtons from '@/Components/Blog/ShareButtons.vue';
import PostCard from '@/Components/Blog/PostCard.vue';
import { formatDate } from '@/helpers/formatDate';
import { blogRoute } from '@/helpers/routes';

const props = defineProps({
    post: Object,
    tableOfContents: Array,
    relatedPosts: Array,
    seo: Object,
});

const breadcrumbs = computed(() => [
    { label: 'Home', href: 'home' },
    ...(props.post.category?.slug
        ? [{ label: props.post.category.name, href: 'categories.show', params: { category: props.post.category.slug } }]
        : []),
    { label: props.post.title },
]);
</script>

<template>
    <BlogLayout :breadcrumbs="breadcrumbs">
        <SeoHead :seo="seo" />

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <!-- Main article -->
            <article class="xl:col-span-3 space-y-6">
                <header class="cyber-card overflow-hidden">
                    <div v-if="post.cover_image" class="aspect-video overflow-hidden">
                        <img
                            :src="post.cover_image"
                            :alt="post.title"
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <div class="p-6 lg:p-8">
                        <Link
                            v-if="post.category?.slug"
                            :href="blogRoute('categories.show', { category: post.category.slug })"
                            class="cyber-tag"
                        >
                            {{ post.category.name }}
                        </Link>

                        <h1 class="mt-4 text-3xl lg:text-4xl font-bold text-cyber-text">
                            {{ post.title }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-cyber-muted">
                            <span v-if="post.author" class="flex items-center gap-1.5">
                                <User class="w-4 h-4" />
                                {{ post.author.name }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <Calendar class="w-4 h-4" />
                                {{ formatDate(post.published_at) }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <Clock class="w-4 h-4" />
                                {{ post.reading_time }} min de leitura
                            </span>
                            <span class="flex items-center gap-1.5">
                                <Eye class="w-4 h-4" />
                                {{ post.views_count }} visualizações
                            </span>
                        </div>

                        <div v-if="post.tags?.length" class="flex flex-wrap gap-2 mt-4">
                            <template v-for="tag in post.tags" :key="tag.id">
                                <Link
                                    v-if="tag.slug"
                                    :href="blogRoute('tags.show', { tag: tag.slug })"
                                    class="cyber-tag"
                                >
                                    #{{ tag.name }}
                                </Link>
                            </template>
                        </div>

                        <div class="mt-6 pt-6 border-t border-cyber-border">
                            <ShareButtons :title="post.title" :url="seo.canonical" />
                        </div>
                    </div>
                </header>

                <div class="cyber-card p-6 lg:p-8">
                    <MarkdownRenderer :content="post.markdown" />
                </div>

                <!-- Related posts -->
                <div v-if="relatedPosts?.length" class="space-y-4">
                    <h3 class="font-mono text-lg text-cyber-primary">
                        <span class="text-cyber-muted">//</span> related_posts
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <PostCard v-for="related in relatedPosts" :key="related.id" :post="related" />
                    </div>
                </div>
            </article>

            <!-- TOC sidebar -->
            <aside class="hidden xl:block">
                <TableOfContents :headings="tableOfContents" />
            </aside>
        </div>
    </BlogLayout>
</template>
