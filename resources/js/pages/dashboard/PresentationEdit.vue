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

import { ExternalLink, Trash, OctagonAlert } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import FormField from '@/components/global/form/FormField.vue';

import EditSlides from '@/components/dashboard/sections/EditSlides.vue';

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
                <fieldset class="grid grid-cols-2 items-start gap-x-15">
                    <legend class="block font-semibold text-lg mb-5 ">Script</legend>

                    <FormField label="Current Script:" id="select-script" >
                        <select
                            :value="presentation.presentation_script.id"
                            name="script" id="select-script"
                            class="
                                cursor-pointer
                                block grow
                                px-2 border
                                "
                        >
                            <button> <selectedcontent></selectedcontent> </button>
                            <option value="" class="italic"> * None linked * </option>
                            <template v-for="_script in scripts">
                                <option class="px-2" :value="_script.id">
                                    <span>
                                        {{ _script.title }}
                                    </span>
                                    <span>
                                        #{{ _script.id }}
                                    </span>
                                </option>
                            </template>
                        </select>
                    </FormField>
                    <div class="space-y-3">
                        <template v-if="presentation.presentation_script">
                            <a class="flex gap-1" target="_blank" :href="admin_scripts(presentation.presentation_script.id).url">
                                <span> Go to script: {{ presentation.presentation_script.title }} </span>
                                <ExternalLink class="size-4"/>
                            </a>
                        </template>
                        <a class="flex gap-1" target="_blank" :href="admin_script_index().url">
                            <span> Create a new script </span>
                            <ExternalLink class="size-4"/>
                        </a>
                    </div>
                </fieldset>
                <div class="space-y-5">
                    <h3 class="text-lg font-semibold"> Slides </h3>
                    <EditSlides :slides="presentation.slides"/>
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