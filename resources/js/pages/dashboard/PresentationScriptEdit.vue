<script setup lang="ts">
import {
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import {
    admin_presentation_index,
    admin_script_index,
} from '@/routes';
import { destroy, update } from '@/routes/admin_script';

import { Trash, OctagonAlert, Save } from 'lucide-vue-next';
import { Head, Form } from '@inertiajs/vue3';
import { Spinner } from '@/components/ui/spinner';

import AppLayout from '@/layouts/AppLayout.vue';
import Container from '@/components/dashboard/Container.vue';
import ActionModal from '@/components/dashboard/ActionModal.vue';
import FormField from '@/components/global/form/FormField.vue';

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
                    <button
                        form="update-script-form"
                        class="cursor-pointer select-none w-full flex items-center justify-between gap-1"
                    >
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

                    <button
                        command="show-modal"
                        commandfor="destroy-script-dialog"
                        class="
                            cursor-pointer select-none
                            flex items-center justify-between gap-1
                            w-full
                            "
                    >
                        <span> Delete </span>
                        <Trash class="size-4"/>
                    </button>
                </div>
            </div>
            <div class="order-1 space-y-20">
                <Form
                    id="update-script-form"
                    class="h-full grid gap-6 max-w-[90ch] mx-auto"
                    v-bind="update.form(script.id)"
                    v-slot="{ errors, processing }"
                >
                    <FormField
                        id="script-title" label="Title:"
                        :error="errors.title"
                    >
                        <input
                            id="script-title" name="title"
                            :value="script.title" type="text"
                            class="grow outline-none"
                        />
                    </FormField>

                    <FormField :error="errors.content">
                        <textarea
                            aria-label="Content"
                            name="content"
                            class="
                                resize-none
                                outline-none
                                min-h-[10lh]
                                "
                            :value="script.content.trim()"
                        />
                    </FormField>
                </Form>
            </div>
        </Container>
    </AppLayout>

    <ActionModal id="destroy-script-dialog">
        <p class="my-5">
            Are you sure you want to delete this script? This is irreversible.
            <br>
            Any presentations using this script will lose that connection.
        </p>
        <Form
            v-bind="destroy.form(script.id)"
            v-slot="{ processing }"
        >
            <button
                class="
                    cursor-pointer select-none
                    flex items-center gap-1
                    w-fit
                    px-2 py-1 mx-auto
                    border border-red-900 rounded-md
                    outline-offset-8
                    "
            >
                <span> Yes, delete this script </span>
                <Trash class="size-4"/>
            </button>
            <Spinner v-if="processing" />
        </Form>
    </ActionModal>
</template>

<style>
    #update-script-form {
        grid-template-rows: auto 1fr;
    }

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