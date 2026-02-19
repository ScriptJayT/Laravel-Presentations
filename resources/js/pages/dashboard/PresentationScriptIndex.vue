<script setup lang="ts">
import { type PresentationScript, type BreadcrumbItem } from '@/types';
import { admin_presentation_index, admin_scripts } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';
import NewScript from '@/components/dashboard/forms/NewScript.vue';

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
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <NewLink title="Script">
                <h2 class="text-lg font-semibold my-5"> Create a new Script </h2>
                <NewScript />
            </NewLink>
            <template v-for="_script in allScripts">
                <IndexLink
                    :title="_script.title"
                    :semantic-title="true"
                    :link="admin_scripts(_script.id)"
                    :last-edit="_script.updated_at"
                />
            </template>
        </Container>
    </AppLayout>
</template>

<style>
    [data-id=script-index] .model-entry--last-edit {
        margin-top: auto;
    }
</style>