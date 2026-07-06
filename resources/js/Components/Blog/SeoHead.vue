<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    seo: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <Head v-if="seo.title">
        <title>{{ seo.title }}</title>
        <meta head-key="description" name="description" :content="seo.description" />
        <link head-key="canonical" rel="canonical" :href="seo.canonical" />

        <meta head-key="og:title" property="og:title" :content="seo.og?.title" />
        <meta head-key="og:description" property="og:description" :content="seo.og?.description" />
        <meta head-key="og:url" property="og:url" :content="seo.og?.url" />
        <meta head-key="og:type" property="og:type" :content="seo.og?.type" />
        <meta head-key="og:image" property="og:image" :content="seo.og?.image" />

        <meta head-key="twitter:card" name="twitter:card" :content="seo.twitter?.card" />
        <meta head-key="twitter:title" name="twitter:title" :content="seo.twitter?.title" />
        <meta head-key="twitter:description" name="twitter:description" :content="seo.twitter?.description" />
        <meta head-key="twitter:image" name="twitter:image" :content="seo.twitter?.image" />
    </Head>
</template>
