<script setup lang="ts">
import { type Presentation, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { dashboard, admin_presentations } from '@/routes';

import AppLayout from '@/layouts/AppLayout.vue';
import Container from '@/components/dashboard/Container.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

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
            title="Presentation Overview"
            class="grid auto-rows-min gap-4 md:grid-cols-3"
        >
            <template v-for="_presentation in allPresentations">
                <div class="
                    relative isolate
                    flex flex-col
                    aspect-video
                    p-4 border border-transparent rounded-xl
                    "
                >
                    <h3 class="text-lg font-semibold"> {{ _presentation.title }} </h3>
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
                    <span class="block text-sm">
                        last edit: {{ _presentation.updated_at }}
                    </span>

                    <a
                        class="absolute inset-0 border rounded-xl"
                        :href="admin_presentations(_presentation.id).url"
                        :title="'Open this presentation by ' + _presentation.user.name"
                    ></a>

                    <PlaceholderPattern :interactable="false"/>
                </div>
            </template>
        </Container>
    </AppLayout>
</template>
