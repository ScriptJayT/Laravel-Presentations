<script setup lang="ts">
import {
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import { dashboard, admin_scripts } from '@/routes';

import { Head } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import Container from '@/components/dashboard/Container.vue';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';

const props = defineProps<{
    allScripts: PresentationScript[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: dashboard().url,
    },
    {
        title: 'Scripts',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            title="Scripting stuff"
            id="script-index"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <NewLink title="Script"/>
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