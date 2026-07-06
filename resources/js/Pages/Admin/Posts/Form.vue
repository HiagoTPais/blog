<script setup>
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import { Save, ArrowLeft } from 'lucide-vue-next';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MarkdownEditor from '@/Components/Blog/MarkdownEditor.vue';

const props = defineProps({
    post: Object,
    categories: Array,
    allTags: Array,
});

const isEditing = computed(() => !!props.post);

function postTagNames(tags) {
    if (!tags) return [];
    const list = Array.isArray(tags) ? tags : tags.data ?? [];
    return list.map((tag) => (typeof tag === 'string' ? tag : tag.name));
}

const form = useForm({
    title: props.post?.title ?? '',
    slug: props.post?.slug ?? '',
    excerpt: props.post?.excerpt ?? '',
    markdown: props.post?.markdown ?? '',
    cover_image: null,
    remove_cover: false,
    category_id: props.post?.category?.id ?? '',
    tags: postTagNames(props.post?.tags),
    status: props.post?.status ?? 'draft',
    published_at: props.post?.published_at?.substring(0, 16) ?? '',
    meta_title: props.post?.meta_title ?? '',
    meta_description: props.post?.meta_description ?? '',
});

const tagInput = ref('');
const coverPreview = ref(props.post?.cover_image ?? null);

function addTag() {
    const tag = tagInput.value.trim();
    if (tag && !form.tags.includes(tag)) {
        form.tags.push(tag);
    }
    tagInput.value = '';
}

function removeTag(index) {
    form.tags.splice(index, 1);
}

function handleCoverChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.cover_image = file;
        coverPreview.value = URL.createObjectURL(file);
        form.remove_cover = false;
    }
}

function removeCover() {
    form.cover_image = null;
    form.remove_cover = true;
    coverPreview.value = null;
}

function submit() {
    const options = {
        forceFormData: true,
        preserveScroll: true,
    };

    if (isEditing.value) {
        form.transform((data) => ({ ...data, _method: 'PUT' }))
            .post(route('admin.posts.update', props.post.id), options);
    } else {
        form.post(route('admin.posts.store'), options);
    }
}
</script>

<template>
    <AdminLayout>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="font-mono text-2xl text-cyber-primary">
                    <span class="text-cyber-muted">$</span> {{ isEditing ? 'edit_post' : 'new_post' }}
                </h1>
                <Link :href="route('admin.posts.index')" class="cyber-btn-outline">
                    <ArrowLeft class="w-4 h-4" /> Voltar
                </Link>
            </div>

            <form class="space-y-6" @submit.prevent="submit">
                <!-- Title & Slug -->
                <div class="cyber-card p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Título *</label>
                        <input v-model="form.title" type="text" class="cyber-input w-full px-3 py-2" required />
                        <p v-if="form.errors.title" class="mt-1 text-xs text-red-400">{{ form.errors.title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Slug (auto-gerado se vazio)</label>
                        <input v-model="form.slug" type="text" class="cyber-input w-full px-3 py-2 font-mono" />
                        <p v-if="form.errors.slug" class="mt-1 text-xs text-red-400">{{ form.errors.slug }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Resumo *</label>
                        <textarea v-model="form.excerpt" rows="3" class="cyber-input w-full px-3 py-2 resize-y" required />
                        <p v-if="form.errors.excerpt" class="mt-1 text-xs text-red-400">{{ form.errors.excerpt }}</p>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-mono text-cyber-muted mb-2">Conteúdo (Markdown) *</label>
                    <MarkdownEditor v-model="form.markdown" />
                    <p v-if="form.errors.markdown" class="mt-1 text-xs text-red-400">{{ form.errors.markdown }}</p>
                </div>

                <!-- Cover & Category -->
                <div class="cyber-card p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Imagem de Capa</label>
                        <div v-if="coverPreview" class="relative mb-3">
                            <img :src="coverPreview" alt="Preview" class="w-full max-h-48 object-cover rounded-lg" />
                            <button type="button" class="mt-2 text-xs text-red-400 hover:text-red-300 font-mono" @click="removeCover">
                                Remover imagem
                            </button>
                        </div>
                        <input type="file" accept="image/*" class="text-sm text-cyber-muted" @change="handleCoverChange" />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-mono text-cyber-muted mb-1">Categoria *</label>
                            <select v-model="form.category_id" class="cyber-input w-full px-3 py-2" required>
                                <option value="">Selecione...</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                            <p v-if="form.errors.category_id" class="mt-1 text-xs text-red-400">{{ form.errors.category_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-mono text-cyber-muted mb-1">Status *</label>
                            <select v-model="form.status" class="cyber-input w-full px-3 py-2" required>
                                <option value="draft">Rascunho</option>
                                <option value="published">Publicado</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Data de Publicação</label>
                        <input v-model="form.published_at" type="datetime-local" class="cyber-input w-full px-3 py-2" />
                    </div>
                </div>

                <!-- Tags -->
                <div class="cyber-card p-6">
                    <label class="block text-sm font-mono text-cyber-muted mb-2">Tags</label>
                    <div class="flex gap-2 mb-3">
                        <input
                            v-model="tagInput"
                            type="text"
                            class="cyber-input flex-1 px-3 py-2"
                            placeholder="Digite uma tag e pressione Enter"
                            @keydown.enter.prevent="addTag"
                        />
                        <button type="button" class="cyber-btn-outline" @click="addTag">Adicionar</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="(tag, index) in form.tags"
                            :key="index"
                            class="cyber-tag cursor-pointer"
                            @click="removeTag(index)"
                        >
                            #{{ tag }} ×
                        </span>
                    </div>
                </div>

                <!-- SEO -->
                <div class="cyber-card p-6 space-y-4">
                    <h3 class="font-mono text-sm text-cyber-primary">
                        <span class="text-cyber-muted">//</span> seo
                    </h3>
                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Meta Title</label>
                        <input v-model="form.meta_title" type="text" class="cyber-input w-full px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-sm font-mono text-cyber-muted mb-1">Meta Description</label>
                        <textarea v-model="form.meta_description" rows="2" class="cyber-input w-full px-3 py-2 resize-y" />
                    </div>
                </div>

                <button type="submit" class="cyber-btn" :disabled="form.processing">
                    <Save class="w-4 h-4" />
                    {{ form.processing ? 'Salvando...' : (isEditing ? 'Atualizar Post' : 'Criar Post') }}
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
