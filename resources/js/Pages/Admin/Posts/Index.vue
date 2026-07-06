<script setup>
import { Link, router } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from '@/Components/Blog/Pagination.vue';
import { formatDate } from '@/helpers/formatDate';

defineProps({
    posts: Object,
});

function deletePost(id) {
    if (confirm('Tem certeza que deseja excluir este post?')) {
        router.delete(route('admin.posts.destroy', id));
    }
}
</script>

<template>
    <AdminLayout>
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="font-mono text-2xl text-cyber-primary">
                    <span class="text-cyber-muted">$</span> posts
                </h1>
                <Link :href="route('admin.posts.create')" class="cyber-btn">
                    <Plus class="w-4 h-4" /> Novo Post
                </Link>
            </div>

            <div class="cyber-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-cyber-muted font-mono border-b border-cyber-border bg-cyber-bg/50">
                                <th class="p-4">Título</th>
                                <th class="p-4">Categoria</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Views</th>
                                <th class="p-4">Data</th>
                                <th class="p-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="post in posts.data"
                                :key="post.id"
                                class="border-b border-cyber-border/50 hover:bg-cyber-bg/30"
                            >
                                <td class="p-4 text-cyber-text max-w-xs truncate">{{ post.title }}</td>
                                <td class="p-4 text-cyber-muted">{{ post.category?.name }}</td>
                                <td class="p-4">
                                    <span
                                        :class="[
                                            'px-2 py-0.5 rounded text-xs font-mono',
                                            post.status === 'published'
                                                ? 'bg-cyber-primary/10 text-cyber-primary'
                                                : 'bg-yellow-500/10 text-yellow-400',
                                        ]"
                                    >
                                        {{ post.status }}
                                    </span>
                                </td>
                                <td class="p-4 text-cyber-muted font-mono">{{ post.views_count }}</td>
                                <td class="p-4 text-cyber-muted text-xs">{{ formatDate(post.published_at) }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <Link
                                            :href="route('admin.posts.edit', post.id)"
                                            class="p-1.5 text-cyber-muted hover:text-cyber-primary transition-colors"
                                        >
                                            <Pencil class="w-4 h-4" />
                                        </Link>
                                        <button
                                            class="p-1.5 text-cyber-muted hover:text-red-400 transition-colors"
                                            @click="deletePost(post.id)"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <Pagination :links="posts.meta?.links ?? posts.links" />
        </div>
    </AdminLayout>
</template>
