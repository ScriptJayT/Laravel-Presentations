<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

type User = {
    id: number,
    name: string,
}
type Presentation = {
    title: string,
    creator: User,
}
defineProps<{
    presentations: Presentation[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4" >
            <h2>Presentation Overview</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in presentations">
                    <div class="
                        relative aspect-video 
                        p-4
                        border rounded-xl 
                    ">
                        <h3> {{ _presentation.title }} </h3>
                        <span>
                            by:
                        </span>
                        <div class="pointer-events-none" role="presentation">
                            <PlaceholderPattern />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
