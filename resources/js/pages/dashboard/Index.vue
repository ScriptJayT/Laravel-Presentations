<script setup lang="ts">
import { 
    type Presentation,
    type BreadcrumbItem, 
} from '@/types';
import { Head } from '@inertiajs/vue3';
import { dashboard, admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Dashboard',
    href: dashboard().url,
}];

defineProps<{
    allPresentations: Presentation[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="h-full space-y-4 rounded-xl p-4" >
            <h2>Presentation Overview</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allPresentations">
                    <div class="relative | aspect-video | p-4 | border rounded-xl">
                        <h3> {{ _presentation.title }} </h3>

                        <span class="creator | block">
                            by: {{ _presentation.user.name }}
                        </span>
                        <span class="created_on | block">
                            created on: {{ _presentation.created_at }}
                        </span>
                        <span class="last_edit | block">
                            last edit: {{ _presentation.updated_at }}
                        </span>

                        <a :href="admin_presentations(_presentation.id).url">
                            /{{ _presentation.slug }} 
                        </a>

                        <div class="pointer-events-none" role="presentation">
                            <PlaceholderPattern />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
