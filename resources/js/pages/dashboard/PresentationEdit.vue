<script setup lang="ts">
import {
    type Presentation,
    type BreadcrumbItem,
} from '@/types';

import { dashboard, presentations } from '@/routes';

import { ExternalLink, Trash } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Presentation;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
    {
        title: 'Presentations',
        href: dashboard().url,
    },
    {
        title: `Presentation: #${props.presentation.id}`,
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="presentation-wrapper | space-y-4 rounded-xl p-4" >
            <div class="flex justify-between items-center">
                <Heading :title="presentation.title"/>
            </div>

            <div class="info-field | grid gap-6">
                <div class="order-2 flex flex-col gap-10">
                    <div class="space-y-3 p-4 border rounded-xl">
                        <h3 class="sr-only"> Info </h3>
                        <a
                            class="cursor-pointer select-none | flex justify-between gap-1"
                            :href="presentations(presentation.slug).url"
                            target="_blank"
                        >
                            <span> Go to preview </span>
                            <ExternalLink class="size-4"/>
                        </a>
                        <hr>
                        <span class="block">
                            Created by: {{ presentation.user.name }}
                        </span>
                        <span class="block">
                            on: {{ presentation.created_at }}
                        </span>
                        <span class="block">
                            Last edit: {{ presentation.updated_at }}
                        </span>
                        <hr>
                        <span class="block">
                            Visibility: {{ presentation.presentation_visibility.name }}
                        </span>
                        <span class="block">
                            Slug: /{{ presentation.slug }}
                        </span>
                    </div>
                    <div class="space-y-3 p-4 border rounded-xl border-red-900">
                        <h3 class="text-lg font-semibold"> Danger zone </h3>
                        <button class="cursor-pointer select-none w-full flex justify-between gap-1">
                            <span> Delete </span>
                            <Trash class="size-4"/>
                        </button>
                    </div>
                </div>
                <div class="order-1 space-y-20">
                    <div class="space-y-5">
                        <h3 class="text-lg font-semibold"> Script </h3>
                        <span class="block">
                            Title: {{ presentation.presentation_script?.title }}
                        </span>
                        <a> Go to script </a>
                    </div>
                    <div class="space-y-5">
                        <h3 class="text-lg font-semibold"> Slides </h3>
                        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                            <div class="relative isolate | aspect-video | p-4 | border rounded-xl">
                                <PlaceholderPattern :interactable="false" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
    .presentation-wrapper {
        container-type: inline-size;
    }
    .info-field {
        grid-template-columns: 1fr auto;
    }
</style>