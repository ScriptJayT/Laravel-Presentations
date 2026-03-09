<script setup lang="ts">
import { type PresentationScript, type BreadcrumbItem } from '@/types';
import { admin_presentation_index, admin_scripts } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import { IndexLink, NewLink } from '@/components/dashboard/models';
import NewScript from '@/components/dashboard/forms/NewScript.vue';
import { Search } from '@/components/global/form';
import VisibilityBadge from '@/components/global/model/VisibilityBadge.vue';

const props = defineProps<{
    allScripts: PresentationScript[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: admin_presentation_index().url,
    },
    {
        title: 'Scripts',
    },
];
</script>

<template>
    <AppLayout meta-title="Scripts" :breadcrumbs="breadcrumbs">
        <Container
            title="Scripting stuff"
            id="script-index"
            class="space-y-10"
        >
            <Search :updatable-list="allScripts" />
            <IndexGrid>
                <NewLink title="Script">
                    <NewScript />
                </NewLink>
                <template v-for="_script in allScripts">
                    <IndexLink
                        :title="_script.title"
                        class="search-indexable"
                        :link="admin_scripts(_script.id)"
                        :last-edit="_script.updated_at"
                    >
                        <VisibilityBadge
                            :visibility="_script.presentation_visibility"
                            class="absolute top-0 right-4 z-10 -translate-y-1/2"
                            aria-hidden="true"
                        />
                        <span class="block mt-auto pt-5" aria-label="A presentation">
                            by: {{ _script.user.name }}
                        </span>
                    </IndexLink>
                </template>
            </IndexGrid>
        </Container>
    </AppLayout>
</template>