<script setup lang="ts">
import {
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import { dashboard, admin_scripts } from '@/routes';

import { Head } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';

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
        href: dashboard().url,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            title="Hi"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >

        <template v-for="_script in allScripts">
                <div
                    class="
                        relative isolate
                        flex flex-col
                        aspect-video
                        p-4
                        border border-transparent rounded-xl
                        "
                >
                    <h3 class="text-lg font-semibold"> {{ _script.title }} </h3>

                    <span class="block text-sm">
                        last edit: {{ _script.updated_at }}
                    </span>

                    <a
                        class="
                            absolute inset-0
                            border-2 rounded-xl hover:border-cyan-700 focus-visible:border-cyan-700
                            outline-offset-8
                            "
                        :href="admin_scripts(_script.id).url"
                        title="Open this script"
                    ></a>

                    <PlaceholderPattern :interactable="false"/>
                </div>
            </template>

        </Container>
    </AppLayout>
</template>

<style scoped>

</style>