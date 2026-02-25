<script setup lang="ts">
import AppContent from '@/components/dashboard/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/dashboard/AppSidebar.vue';
import AppSidebarHeader from '@/components/dashboard/AppSidebarHeader.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar" data-layout="app/AppSidebarLayout">
        <AppSidebar />
        <AppContent variant="sidebar" class="overflow-x-hidden">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
