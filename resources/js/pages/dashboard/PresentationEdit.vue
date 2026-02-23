<script setup lang="ts">
import {
    type Presentation,
    type PresentationVisibility,
    type PresentationScript,
    type BreadcrumbItem,
} from '@/types';
import { admin_presentation_index } from '@/routes';
import { destroy, update } from '@/routes/admin_presentation';

import AppLayout from '@/layouts/AppLayout.vue';
import { SideZoneContainer } from '@/components/dashboard/containers';
import { Form, FormField, SelectField, TextField } from '@/components/global/form'
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
const visibilityOptions: Record<string, string> = {};
props.rules.forEach(_visibility => {
    visibilityOptions[_visibility.id] = `${_visibility.name}`;
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" meta-title="Edit Presentation">
        <SideZoneContainer
            :title="presentation.title"
            main-class="space-y-20"
        >
            <template v-slot:sidezone>
                <SaveZone form-id="update-presentation-form" />
                <AsideZone title="Info" :hidden-title="true">
                    <PresentationInfo :presentation />
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal id="presentation" :route="destroy.form(presentation.id)" />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
                <h3 class="sr-only"> Presentation </h3>
                <Form
                    id="update-presentation-form"
                    form-action="edit"
                    class="grid grid-cols-2 gap-x-10"
                    :show-button="false"
                    :send-to="update.form(presentation.id)"
                    v-slot="{ errors }"
                >
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

                        <TextField
                            name="slug"
                            label="Slug:"
                            :value="presentation.slug"
                            :error="errors.slug"
                        />
                        <SelectField
                            name="visibility"
                            label="Visibility:"
                            :default-value="`${presentation.presentation_visibility.id}`"
                            :allow-null-value="false"
                            :error="errors.visibility"
                            :options="visibilityOptions"
                        />
                    </fieldset>
                    <fieldset class="space-y-5">
                        <legend class="block font-semibold text-lg mb-5"> Script </legend>
                        <EditScript
                            :scripts
                            :current-script="presentation.presentation_script"
                            :error="errors.script"
                        />
                    </fieldset>
                </Form>
                <div class="space-y-5">
                    <h3 class="text-lg font-semibold"> Slides </h3>
                    <EditSlides :slides="presentation.slides"/>
                </div>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>
