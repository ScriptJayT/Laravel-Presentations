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

import EditSlides from '@/components/dashboard/sections/EditSlides.vue';
import PresentationInfo from '@/components/dashboard/sections/PresentationInfo.vue';
import EditScript from '@/components/dashboard/sections/EditScript.vue';
import FormField from '@/components/global/form/FormField.vue';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';
import DangerZone from '@/components/dashboard/sections/DangerZone.vue';
import SaveZone from '@/components/dashboard/sections/SaveZone.vue';
import AsideZone from '@/components/dashboard/sections/AsideZone.vue';

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
                <SaveZone form-id="update-presentation-form" />
                <AsideZone title="Info" :hidden-title="true">
                    <PresentationInfo :presentation />
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal id="presentation" :route="destroy.form(presentation.id)" />
                </DangerZone>
            </div>
            <div class="order-1 relative isolate space-y-20">
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
                    <span
                        v-show="isDirty" aria-live="polite"
                        class="
                            absolute right-0
                            p-2
                            border border-orange-400 rounded-md
                            bg-background
                            "
                    >
                        Unsaved Changes
                    </span>

                    <fieldset class="space-y-5">
                        <legend class="block font-semibold text-lg mb-5"> Meta </legend>
                        <FormField :error="errors.title" label="Title:" id="presentation-title">
                            <input
                                name="title" id="presentation-title"
                                type="text" :value="presentation.title"
                                class="
                                    grow px-2
                                    border-transparent outline-none
                                    "
                            >
                        </FormField>
                        <FormField :error="errors.slug" label="Slug:" id="presentation-slug">
                            <input
                                name="slug" id="presentation-slug"
                                type="text" :value="presentation.slug"
                                class="
                                    grow px-2
                                    border-transparent outline-none
                                    "
                            >
                        </FormField>
                        <FormField :error="errors.visibility" label="Visibility:" id="visibility-rule">
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
