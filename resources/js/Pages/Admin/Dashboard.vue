<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { FileText, FolderOpen, Tag, Eye } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

defineProps({
    stats: Object,
    mostViewed: Array,
});
</script>

<template>
    <AdminLayout>
        <div class="space-y-6">
            <h1 class="font-mono text-2xl text-cyber-primary">
                <span class="text-cyber-muted">$</span> dashboard
            </h1>

            <!-- Stats -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="cyber-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-cyber-primary/10">
                            <FileText class="w-5 h-5 text-cyber-primary" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-cyber-text">{{ stats.posts }}</p>
                            <p class="text-xs text-cyber-muted font-mono">Posts</p>
                        </div>
                    </div>
                </div>

                <div class="cyber-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-cyber-primary/10">
                            <FolderOpen class="w-5 h-5 text-cyber-primary" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-cyber-text">{{ stats.categories }}</p>
                            <p class="text-xs text-cyber-muted font-mono">Categorias</p>
                        </div>
                    </div>
                </div>

                <div class="cyber-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-cyber-primary/10">
                            <Tag class="w-5 h-5 text-cyber-primary" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-cyber-text">{{ stats.tags }}</p>
                            <p class="text-xs text-cyber-muted font-mono">Tags</p>
                        </div>
                    </div>
                </div>

                <div class="cyber-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-cyber-primary/10">
                            <Eye class="w-5 h-5 text-cyber-primary" />
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-cyber-text">{{ stats.views }}</p>
                            <p class="text-xs text-cyber-muted font-mono">Visualizações</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Most viewed -->
            <div class="cyber-card p-6">
                <h2 class="font-mono text-sm text-cyber-primary mb-4">
                    <span class="text-cyber-muted">//</span> top_posts
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-cyber-muted font-mono border-b border-cyber-border">
                                <th class="pb-3 pr-4">Título</th>
                                <th class="pb-3 pr-4">Categoria</th>
                                <th class="pb-3 pr-4">Views</th>
                                <th class="pb-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in mostViewed"
                                :key="post.id"
                                class="border-b border-cyber-border/50 last:border-0"
                            >
                                <td class="py-3 pr-4 text-cyber-text">{{ post.title }}</td>
                                <td class="py-3 pr-4 text-cyber-muted">{{ post.category?.name }}</td>
                                <td class="py-3 pr-4 text-cyber-primary font-mono">{{ post.views_count }}</td>
                                <td class="py-3">
                                    <Link
                                        :href="route('admin.posts.edit', post.id)"
                                        class="text-cyber-primary hover:text-cyber-hover font-mono text-xs"
                                    >
                                        editar
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
