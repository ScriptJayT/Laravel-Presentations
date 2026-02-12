<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <header
        class="
            flex h-16 shrink-0 items-center gap-2
            px-6 md:px-4 dark:px-8 dark:md:px-6
            border-b border-sidebar-border/70
            transition-[width,height] ease-linear
            group-has-data-[collapsible=icon]/sidebar-wrapper:h-12
        "
        data-component="dashboard/AppSidebarHeader"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
    </header>
</template>
