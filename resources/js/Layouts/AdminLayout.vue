<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutDashboard, FileText, LogOut, ExternalLink } from 'lucide-vue-next';

const page = usePage();

const navItems = [
    { name: 'Dashboard', href: 'admin.dashboard', icon: LayoutDashboard },
    { name: 'Posts', href: 'admin.posts.index', icon: FileText },
];
</script>

<template>
    <div class="min-h-screen bg-cyber-bg">
        <nav class="bg-cyber-card border-b border-cyber-border">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-8">
                        <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                            <img src="/img/icone.png" alt="Logo" class="w-7 h-7 object-contain" />
                            <span class="font-mono text-sm font-bold text-cyber-primary">admin_panel</span>
                        </Link>

                        <div class="hidden sm:flex items-center gap-1">
                            <Link
                                v-for="item in navItems"
                                :key="item.name"
                                :href="route(item.href)"
                                :class="[
                                    'flex items-center gap-2 px-3 py-2 rounded-md text-sm font-mono transition-colors',
                                    route().current(item.href + '*') || route().current(item.href)
                                        ? 'bg-cyber-primary/10 text-cyber-primary'
                                        : 'text-cyber-muted hover:text-cyber-text',
                                ]"
                            >
                                <component :is="item.icon" class="w-4 h-4" />
                                {{ item.name }}
                            </Link>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('home')"
                            class="flex items-center gap-1 text-sm text-cyber-muted hover:text-cyber-primary font-mono transition-colors"
                        >
                            <ExternalLink class="w-4 h-4" />
                            Ver Blog
                        </Link>
                        <span class="text-sm text-cyber-muted hidden sm:block">{{ page.props.auth.user?.name }}</span>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="flex items-center gap-1 text-sm text-cyber-muted hover:text-red-400 font-mono transition-colors"
                        >
                            <LogOut class="w-4 h-4" />
                            Sair
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <slot />
        </main>
    </div>
</template>
