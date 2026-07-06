<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Shield, Home, FolderOpen, User, Mail, Github, Linkedin, X } from 'lucide-vue-next';
import { useBlogStore } from '@/stores/blog';

const page = usePage();
const store = useBlogStore();

const navItems = [
    { name: 'Home', href: 'home', icon: Home },
    { name: 'Categorias', href: 'categories.index', icon: FolderOpen },
    { name: 'About', href: 'about', icon: User },
    { name: 'Contato', href: 'contact', icon: Mail },
];

function isActive(routeName) {
    return route().current(routeName);
}
</script>

<template>
    <!-- Mobile overlay -->
    <div
        v-if="store.sidebarOpen"
        class="fixed inset-0 z-40 bg-black/60 lg:hidden"
        @click="store.closeSidebar()"
    />

    <aside
        :class="[
            'fixed top-0 left-0 z-50 h-full w-64 flex flex-col bg-cyber-card border-r border-cyber-border transition-transform duration-300 lg:translate-x-0',
            store.sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        ]"
    >
        <!-- Logo -->
        <div class="flex items-center justify-between p-6 border-b border-cyber-border">
            <Link :href="route('home')" class="flex items-center gap-3 group" @click="store.closeSidebar()">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-cyber-primary/10 border border-cyber-primary/30 group-hover:border-cyber-primary transition-colors overflow-hidden">
                    <img src="/img/icone.png" :alt="page.props.blog?.name" class="w-7 h-7 object-contain" />
                </div>
                <div>
                    <p class="font-mono text-sm font-bold text-cyber-primary">$ {{ page.props.blog?.name.toLowerCase().replace(' ', '_') }}</p>
                </div>
            </Link>
            <button class="lg:hidden text-cyber-muted hover:text-cyber-text" @click="store.closeSidebar()">
                <X class="w-5 h-5" />
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1">
            <Link
                v-for="item in navItems"
                :key="item.name"
                :href="route(item.href)"
                :class="[
                    'flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors',
                    isActive(item.href)
                        ? 'bg-cyber-primary/10 text-cyber-primary border border-cyber-primary/20'
                        : 'text-cyber-muted hover:text-cyber-text hover:bg-cyber-bg',
                ]"
                @click="store.closeSidebar()"
            >
                <component :is="item.icon" class="w-4 h-4" />
                <span class="font-mono">{{ item.name }}</span>
            </Link>

            <Link
                v-if="page.props.auth?.user"
                :href="route('admin.dashboard')"
                :class="[
                    'flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors mt-4',
                    route().current('admin.*')
                        ? 'bg-cyber-primary/10 text-cyber-primary border border-cyber-primary/20'
                        : 'text-cyber-muted hover:text-cyber-text hover:bg-cyber-bg',
                ]"
                @click="store.closeSidebar()"
            >
                <Shield class="w-4 h-4" />
                <span class="font-mono">Admin</span>
            </Link>
        </nav>

        <!-- Social links -->
        <div class="p-4 border-t border-cyber-border">
            <div class="flex items-center justify-center gap-4">
                <a
                    :href="page.props.blog?.github"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-cyber-muted hover:text-cyber-primary transition-colors"
                    aria-label="GitHub"
                >
                    <Github class="w-5 h-5" />
                </a>
                <a
                    :href="page.props.blog?.linkedin"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="text-cyber-muted hover:text-cyber-primary transition-colors"
                    aria-label="LinkedIn"
                >
                    <Linkedin class="w-5 h-5" />
                </a>
                <a
                    :href="`mailto:${page.props.blog?.email}`"
                    class="text-cyber-muted hover:text-cyber-primary transition-colors"
                    aria-label="Email"
                >
                    <Mail class="w-5 h-5" />
                </a>
            </div>
            <p class="mt-3 text-center text-xs text-cyber-muted font-mono">
                © {{ new Date().getFullYear() }} {{ page.props.blog?.author }}
            </p>
        </div>
    </aside>
</template>
