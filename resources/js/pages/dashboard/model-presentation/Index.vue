<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { admin_presentations } from '@/routes';
import { Scroll } from '@lucide/vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import { IndexLink, NewLink } from '@/components/dashboard/models';
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
                    <NewPresentation />
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
                        <span
                            v-if="_presentation.presentation_script"
                            aria-hidden="true"
                            class="flex gap-1 items-center italic opacity-70"
                        >
                            <Scroll class="size-4" />
                            {{ _presentation.presentation_script.title }}
                        </span>

                        <span class="block mt-auto pt-5" aria-label="A presentation">
                            by: {{ _presentation.user.name }}
                        </span>
                    </IndexLink>
                </template>
            </IndexGrid>
        </Container>
    </AppLayout>
</template>