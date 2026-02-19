<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';
import NewPresentation from '@/components/dashboard/forms/NewPresentation.vue';

defineProps<{
    allPresentations: Presentation[];
}>();
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Presentations',
}];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            id="presentation-index"
            title="Full Overview"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <NewLink title="Presentation">
                <h2 class="text-lg font-semibold my-5"> Create a new Presentation </h2>
                <NewPresentation/>
            </NewLink>
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

<style>
    [data-id=presentation-index] .form--meta {
        bottom: 1rem;
        right: auto;
        left: 0;
    }
</style>