<script setup>
import { Link } from '@inertiajs/vue3';
import { FolderOpen } from 'lucide-vue-next';
import BlogLayout from '@/Layouts/BlogLayout.vue';
import SeoHead from '@/Components/Blog/SeoHead.vue';
import { blogRoute } from '@/helpers/routes';

defineProps({
    categories: Array,
    seo: Object,
});
</script>

<template>
    <BlogLayout :breadcrumbs="[{ label: 'Home', href: 'home' }, { label: 'Categorias' }]">
        <SeoHead :seo="seo" />

        <div class="max-w-4xl mx-auto">
            <div class="cyber-card p-6 mb-6">
                <h1 class="font-mono text-xl text-cyber-primary">
                    <span class="text-cyber-muted">$</span> ls /categories/
                </h1>
                <p class="mt-2 text-cyber-muted">Explore artigos organizados por categoria.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <template v-for="category in categories" :key="category.id">
                    <Link
                        v-if="category.slug"
                        :href="blogRoute('categories.show', { category: category.slug })"
                        class="cyber-card p-6 hover:border-cyber-primary/40 transition-colors group"
                    >
                    <div class="flex items-start gap-4">
                        <div class="p-3 rounded-lg bg-cyber-primary/10 border border-cyber-primary/20">
                            <FolderOpen class="w-5 h-5 text-cyber-primary" />
                        </div>
                        <div>
                            <h2 class="font-semibold text-cyber-text group-hover:text-cyber-primary transition-colors">
                                {{ category.name }}
                            </h2>
                            <p v-if="category.description" class="mt-1 text-sm text-cyber-muted line-clamp-2">
                                {{ category.description }}
                            </p>
                            <p class="mt-2 text-xs font-mono text-cyber-primary">
                                {{ category.posts_count }} {{ category.posts_count === 1 ? 'artigo' : 'artigos' }}
                            </p>
                        </div>
                    </div>
                    </Link>
                </template>
            </div>
        </div>
    </BlogLayout>
</template>
