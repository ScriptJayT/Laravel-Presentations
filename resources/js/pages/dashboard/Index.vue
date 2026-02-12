<script setup lang="ts">
import {
    type Presentation,
    type BreadcrumbItem,
} from '@/types';
import { Head } from '@inertiajs/vue3';
import { dashboard, admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import Container from '@/components/dashboard/Container.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Presentations',
    href: dashboard().url,
}];

defineProps<{
    allPresentations: Presentation[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            title="Presentation Overview"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <template v-for="_presentation in allPresentations">
                <div class="relative isolate | aspect-video | p-4 | border rounded-xl">
                    <h3> {{ _presentation.title }} </h3>
                    <span> {{ _presentation.presentation_visibility.name }} </span>

                    <span class="creator | block">
                        by: {{ _presentation.user.name }}
                    </span>
                    <span class="last_edit | block">
                        last edit: {{ _presentation.updated_at }}
                    </span>

                    <a :href="admin_presentations(_presentation.id).url">
                        /{{ _presentation.slug }}
                    </a>

                    <PlaceholderPattern :interactable="false"/>
                </div>
            </template>
        </Container>
    </AppLayout>
</template>
