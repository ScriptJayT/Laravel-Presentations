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
import { Form, FormField } from '@/components/global/form'
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
                                class="
                                    grow cursor-pointer
                                    px-2 border-transparent outline-none
                                    "
                            >
                                <button> <selectedcontent></selectedcontent> </button>
                                <template v-for="_rule in rules">
                                    <option
                                        :value="_rule.id"
                                        class="px-2"
                                        :selected="_rule.id === (presentation.presentation_visibility.id)"
                                    >
                                        {{ _rule.name }}
                                    </option>
                                </template>
                            </select>
                        </FormField>
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
