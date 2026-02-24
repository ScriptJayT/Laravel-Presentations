<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import {IndexLink, NewLink} from '@/components/dashboard/models';
import NewPresentation from '@/components/dashboard/forms/NewPresentation.vue';
import { Search } from '@/components/global/form';
import VisibilityBadge from '@/components/global/model/VisibilityBadge.vue';

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
            <Search :updatable-list="allPresentations" />
            <IndexGrid>
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
                        <VisibilityBadge
                            :visibility="_presentation.presentation_visibility"
                            class="absolute top-0 right-4 z-10 -translate-y-1/2"
                            aria-hidden="true"
                        />

                        <span v-if="_presentation.presentation_script" >
                            Has a Script {{ _presentation.presentation_script.title }}
                        </span>

                        <span class="block mt-auto" aria-label="A presentation">
                            by: {{ _presentation.user.name }}
                        </span>
                    </IndexLink>
                </template>
            </IndexGrid>
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