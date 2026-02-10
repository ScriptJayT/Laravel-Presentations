<script setup lang="ts">
import { 
    type Presentation,
    type BreadcrumbItem, 
} from '@/types';

import { dashboard, presentations } from '@/routes';

import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Presentation;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    }, 
    {
        title: 'Presentations',
        href: dashboard().url,
    },
    {
        title: `/${props.presentation.slug} #${props.presentation.id}`,
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="h-full space-y-4 rounded-xl p-4" >
            <div class="flex justify-between items-center">
                <h2> {{ presentation.title }} </h2>
                <span> {{ presentation.slug }} </span>
            </div>
            <div class="p-4 | border rounded-xl">
                <span class="created_on | block">
                    created on: {{ presentation.created_at }}
                </span>
                <span class="creator | block">
                    by: {{ presentation.user.name }}
                </span>
                <span class="last_edit | block">
                    last edit: {{ presentation.updated_at }}
                </span>

                <a target="_blank" :href="presentations(presentation.slug).url">
                    go to: /{{ presentation.slug }}
                </a>
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative | aspect-video | p-4 | border rounded-xl">
                    <div class="pointer-events-none" role="presentation">
                        <PlaceholderPattern />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
