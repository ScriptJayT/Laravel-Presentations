<script setup lang="ts">
import {
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import { dashboard } from '@/routes';

import { Head } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
    all: PresentationScript[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: dashboard().url,
    },
    {
        title: 'Scripts',
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            title="Hi"
        >
        </Container>
    </AppLayout>
</template>

<style scoped>

</style>