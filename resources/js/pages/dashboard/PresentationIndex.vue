<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { dashboard, admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import Container from '@/components/dashboard/Container.vue';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';

defineProps<{
    allPresentations: Presentation[];
}>();
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Presentations',
    href: dashboard().url,
}];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            title="Full Overview"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <NewLink title="Presentation"/>
            <template v-for="_presentation in allPresentations">
                <IndexLink
                    :title="_presentation.title"
                    :semantic-title="true"
                    :link="admin_presentations(_presentation.id)"
                    :last-edit="_presentation.updated_at"
                >
                    <span
                        aria-hidden="true"
                        class="
                            pointer-events-none
                            absolute top-0 right-4 z-10
                            block px-2 border rounded-sm
                            -translate-y-1/2
                            text-sm italic
                            bg-white
                            "
                    >
                        {{ _presentation.presentation_visibility.name }}
                    </span>
                    <span class="block mt-auto" aria-label="A presentation">
                        by: {{ _presentation.user.name }}
                    </span>
                </IndexLink>
            </template>
        </Container>
    </AppLayout>
</template>
