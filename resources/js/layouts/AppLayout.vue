<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItem } from '@/types';

import AlertFlash from '@/components/global/AlertFlash.vue';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template >
    <AlertFlash />
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
