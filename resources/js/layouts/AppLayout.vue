<script setup lang="ts">
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import AlertFlash from '@/components/global/AlertFlash.vue';

type Props = {
    metaTitle?: string;
    breadcrumbs?: BreadcrumbItem[];
};
withDefaults(defineProps<Props>(), {
    metaTitle: "Dashboard",
    breadcrumbs: () => [],
});
</script>

<template >
    <Head :title="metaTitle" />
    <AlertFlash />
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
