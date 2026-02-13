<script setup lang="ts">
import {
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import { admin_presentation_index, admin_script_index } from '@/routes';

import { Trash, OctagonAlert, Save } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
    script: PresentationScript;
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: admin_presentation_index().url,
    },
    {
        title: 'Scripts',
        href: admin_script_index().url,
    },
    {
        title: `Script: #${props.script.id}`,
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Container
            :title="script.title"
            class="info-field grid gap-6"
        >
            <div class="order-2 flex flex-col gap-10">
                <div class="max-w-full w-3xs space-y-3 p-4 border rounded-xl">
                    <button class="cursor-pointer select-none w-full flex items-center justify-between gap-1">
                        <span> Save </span>
                        <Save class="size-4"/>
                    </button>
                </div>
                <div class="max-w-full w-3xs space-y-3 p-4 border rounded-xl">
                    <h3 class="sr-only"> Info </h3>
                    <span class="block">
                        Last edit: {{ script.updated_at }}
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
                <textarea
                    name="content"
                    id=""
                    class="
                        max-w-[90ch]
                        mx-auto
                        resize-none
                        min-h-full p-4
                        rounded-md
                        border-2
                        "
                    :value="script.content.trim()"
                />
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