<script setup lang="ts">
import {
    type Presentation,
    type PresentationVisibility,
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import {
    admin_presentation_index,
    admin_script_index, admin_scripts,
    presentations,
} from '@/routes';

import { ExternalLink, Trash, OctagonAlert, Plus } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Presentation;
    rules: PresentationVisibility[];
    scripts: PresentationScript[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: admin_presentation_index().url,
    },
    {
        title: `Presentation: #${props.presentation.id}`,
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            :title="presentation.title"
            class="info-field grid gap-6"
        >
            <div class="order-2 flex flex-col gap-10">
                <div class="max-w-full w-3xs space-y-3 p-4 border rounded-xl">
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
                    <span class="flex gap-2">
                        <label class="cursor-pointer" for="visibility-rule"> Visibility: </label>
                        <select
                            name="visibility" id="visibility-rule"
                            :value="presentation.presentation_visibility.title"
                            class="
                                hidden-input
                                grow cursor-pointer
                                px-2 border
                                "
                        >
                            <button> <selectedcontent></selectedcontent> </button>
                            <template v-for="_rule in rules">
                                <option
                                    :value="_rule.title"
                                    class="px-2"
                                >
                                    {{ _rule.name }}
                                </option>
                            </template>
                        </select>
                    </span>
                    <span class="flex gap-2">
                        <label class="cursor-pointer" for="presentation-slug"> Slug: </label>
                        <input
                            name="slug" id="presentation-slug"
                            type="text" :value="presentation.slug"
                            class="hidden-input grow px-2 border"
                        >
                    </span>
                </div>
                <div class="space-y-3 p-4 border rounded-xl border-red-900">
                    <h3 class="flex items-center gap-3 text-lg font-semibold text-red-900">
                        <OctagonAlert class="size-5"/>
                        <span> Danger zone </span>
                    </h3>
                    <button class="cursor-pointer select-none w-full flex items-center justify-between gap-1">
                        <span> Delete </span>
                        <Trash class="size-4"/>
                    </button>
                </div>
            </div>
            <div class="order-1 space-y-20">
                <div class="space-y-5">
                    <template v-if="presentation.presentation_script">
                        <h3 class="text-lg font-semibold">
                            Script: {{ presentation.presentation_script.title }}
                        </h3>
                        <a class="block" :href="admin_scripts(presentation.presentation_script.id).url">
                            Go to script
                        </a>
                    </template>
                    <template v-else>
                        <h3 class="text-lg font-semibold">
                            Script
                        </h3>
                    </template>

                    <fieldset class="grid grid-cols-2">
                        <field class="space-y-2">
                            <label class="block" for="select-script"> Choose one from existing: </label>
                            <select
                                name="script" id="select-script"
                                class="
                                    cursor-pointer
                                    block w-full max-w-50
                                    px-2 border
                                    "
                            >
                                <button> <selectedcontent></selectedcontent> </button>
                                <template v-for="_script in scripts">
                                    <option class="px-2" :value="_script.id">
                                        <span>
                                            {{ _script.title }}
                                        </span>
                                        <span>
                                            {{ _script.id }}
                                        </span>
                                    </option>
                                </template>
                            </select>
                        </field>
                        <a class="flex gap-1" target="_blank" :href="admin_script_index().url">
                            <span> Go create a new one </span>
                            <ExternalLink class="size-4"/>
                        </a>
                    </fieldset>
                </div>
                <div class="space-y-5">
                    <h3 class="text-lg font-semibold"> Slides </h3>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div
                            class="
                                ct-inline-size
                                relative isolate
                                flex flex-col
                                aspect-video
                                p-4 border border-transparent rounded-xl
                                "
                        >
                            <span class="font-semibold" aria-hidden="true"> New Slide </span>
                            <button
                                class="
                                    cursor-pointer
                                    absolute inset-0
                                    border rounded-xl
                                    grid place-content-center
                                    "
                                title="Create a New Presentation"
                            >
                                <Plus class="size-[15cqw] opacity-15"/>
                            </button>
                            <PlaceholderPattern :interactable="false"/>
                        </div>
                        <template v-for="_slide in presentation.slides">
                            <div class="relative isolate | aspect-video | p-4 | border rounded-xl">
                                <h4 class="font-semibold"> {{ _slide.id }} </h4>
                                <PlaceholderPattern :interactable="false" />
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>

<style>
    .info-field {
        grid-template-columns: 1fr auto;
    }
</style>

<style scoped>
    .hidden-input {
        transition: 200ms;
        transition-property: border-color;

        &:is(select)::picker-icon {
            transition: 200ms;
            transition-property: color;
        }

        &:not(:hover, :focus-visible) {
            border-color: transparent;

            &:is(select)::picker-icon {
                color: transparent;
            }
        }
    }
</style>