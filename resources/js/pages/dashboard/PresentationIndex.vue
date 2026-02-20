<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';
import NewPresentation from '@/components/dashboard/forms/NewPresentation.vue';
import { Search } from '@/components/global/form';

defineProps<{
    allPresentations: Presentation[];
}>();
const breadcrumbs: BreadcrumbItem[] = [{
    title: 'Presentations',
}];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" meta-title="Presentations">
        <Container
            id="presentation-index"
            title="Full Overview"
            class="space-y-10"
        >
            <Search />
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <NewLink title="Presentation">
                    <h2 class="text-lg font-semibold my-5"> Create a new Presentation </h2>
                    <NewPresentation/>
                </NewLink>
                <template v-for="_presentation in allPresentations">
                    <IndexLink
                        :title="_presentation.title"
                        class="search-indexable"
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
            </div>
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