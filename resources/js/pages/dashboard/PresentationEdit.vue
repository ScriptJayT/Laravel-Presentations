<script setup lang="ts">
import {
    type Presentation,
    type PresentationVisibility,
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';

import { admin_presentation_index } from '@/routes';
import { destroy, update } from '@/routes/admin_presentation';

import { Head, Form } from '@inertiajs/vue3';

import Container from '@/components/dashboard/Container.vue';
import AppLayout from '@/layouts/AppLayout.vue';

import { FormField, UnsavedChanges, ProcessIndicator } from '@/components/global/form'
import {
    AsideZone, SaveZone, DangerZone,
    PresentationInfo,
    EditScript, EditSlides
} from '@/components/dashboard/sections';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';

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
            class="info-field relative grid gap-6"
        >
            <div class="order-2 flex flex-col gap-10">
                <SaveZone form-id="update-presentation-form" />
                <AsideZone title="Info" :hidden-title="true">
                    <PresentationInfo :presentation />
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal id="presentation" :route="destroy.form(presentation.id)" />
                </DangerZone>
            </div>
            <div class="order-1 space-y-20">
                <h3 class="sr-only"> Presentation </h3>

                <Form
                    id="update-presentation-form"
                    class="grid grid-cols-2 gap-x-10"
                    v-bind="update.form(presentation.id)"
                    :reset-on-error="false"
                    :reset-on-success="false"
                    disable-while-processing
                    v-slot="{ errors, processing, isDirty }"
                >
                    <div class="absolute bottom-full right-0 m-0">
                        <ProcessIndicator :is-in-process="processing"/>
                        <UnsavedChanges :has-unsaved-changes="isDirty"/>
                    </div>

                    <fieldset class="space-y-5">
                        <legend class="block font-semibold text-lg mb-5"> Meta </legend>
                        <FormField
                            id="presentation-title"
                            label="Title:"
                            :error="errors.title"
                        >
                            <input
                                name="title" id="presentation-title"
                                type="text"
                                v-model.lazy="presentation.title"
                                class="grow px-2 border-transparent outline-none"
                            >
                        </FormField>
                        <FormField
                            id="presentation-slug"
                            label="Slug:"
                            :error="errors.slug"
                        >
                            <input
                                name="slug" id="presentation-slug"
                                type="text" :value="presentation.slug"
                                class="
                                    grow px-2
                                    border-transparent outline-none
                                    "
                            >
                        </FormField>
                        <FormField
                            id="visibility-rule"
                            label="Visibility:"
                            :error="errors.visibility"
                        >
                            <select
                                name="visibility" id="visibility-rule"
                                :value="presentation.presentation_visibility.title"
                                class="
                                    grow cursor-pointer
                                    px-2 border-transparent outline-none
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
                        </FormField>
                    </fieldset>
                    <fieldset class="space-y-5">
                        <legend class="block font-semibold text-lg mb-5"> Script </legend>
                        <EditScript :scripts :current-script="presentation.presentation_script"/>
                    </fieldset>
                </Form>
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
