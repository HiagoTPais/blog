<script setup>
import { Link } from '@inertiajs/vue3';
import { Clock, Eye } from 'lucide-vue-next';
import { formatDate } from '@/helpers/formatDate';
import { blogRoute } from '@/helpers/routes';

defineProps({
    post: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <article class="cyber-card overflow-hidden group hover:border-cyber-primary/40 transition-colors duration-300 h-full">
        <Link
            v-if="post.slug"
            :href="blogRoute('posts.show', { post: post.slug })"
            class="flex flex-col h-full"
        >
            <!-- Cover image -->
            <div class="relative h-28 shrink-0 overflow-hidden bg-cyber-bg">
                <img
                    v-if="post.cover_image"
                    :src="post.cover_image"
                    :alt="post.title"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                />
                <div
                    v-else
                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cyber-card to-cyber-bg"
                >
                    <span class="font-mono text-cyber-primary/30 text-2xl">{'>'}_</span>
                </div>

                <div v-if="post.category" class="absolute top-2 left-2">
                    <span class="cyber-tag text-[10px] px-1.5 py-0">{{ post.category.name }}</span>
                </div>
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-1 p-3">
                <h2 class="text-sm font-semibold text-cyber-text group-hover:text-cyber-primary transition-colors line-clamp-2 leading-snug">
                    {{ post.title }}
                </h2>

                <p class="mt-1.5 text-xs text-cyber-muted line-clamp-2 leading-relaxed">
                    {{ post.excerpt }}
                </p>

                <!-- Meta -->
                <div class="flex flex-wrap items-center gap-x-2.5 gap-y-1 mt-auto pt-2 text-[10px] text-cyber-muted">
                    <span class="flex items-center gap-0.5">
                        <Clock class="w-3 h-3" />
                        {{ post.reading_time }} min
                    </span>
                    <span class="flex items-center gap-0.5">
                        <Eye class="w-3 h-3" />
                        {{ post.views_count }}
                    </span>
                    <span>{{ formatDate(post.published_at) }}</span>
                </div>

                <!-- Tags -->
                <div v-if="post.tags?.length" class="flex flex-wrap gap-1 mt-2">
                    <template v-for="tag in post.tags.slice(0, 2)" :key="tag.id">
                        <Link
                            v-if="tag.slug"
                            :href="blogRoute('tags.show', { tag: tag.slug })"
                            class="cyber-tag text-[10px] px-1.5 py-0"
                            @click.stop
                        >
                            #{{ tag.name }}
                        </Link>
                    </template>
                </div>
            </div>
        </Link>
    </article>
</template>
