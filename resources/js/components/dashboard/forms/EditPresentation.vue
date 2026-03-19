<script setup lang="ts">
import type { Presentation, PresentationVisibility, PresentationScript, } from '@/types';
import { admin_script_index, admin_scripts } from '@/routes';
import { update } from '@/routes/admin_presentation';
import { ExternalLink, Book, CirclePlus } from 'lucide-vue-next';
import { Form, FormField, SelectField, TextField } from '@/components/global/form';
import { DoubleIconLink } from '../buttons';
import SelectVisibility from '../models/SelectVisibility.vue';

const props = defineProps<{
    presentation: Presentation;
    allVisibilityRules: PresentationVisibility[];
    allScripts: PresentationScript[];
}>();
const scriptOptions: Record<string, string> = {};
props.allScripts.forEach(_script => {
    scriptOptions[_script.id] = `
        <span>${_script.title}</span>
        <span class="ml-auto italic">#${_script.id}</span>
    `;
});
</script>

<template>
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
            <SelectVisibility
                :current-rule="presentation.presentation_visibility.id"
                :rules="allVisibilityRules"
            />
        </fieldset>
        <fieldset class="space-y-5 ct-inline-size">
            <legend class="block font-semibold text-lg mb-5"> Script </legend>
            <SelectField
                name="script"
                label="Current Script:"
                null-value-text="None linked"
                :default-value="`${presentation.presentation_script?.id}`"
                :options="scriptOptions"
                :error="errors.script"
            />
            <div class="script-links | flex flex-wrap gap-y-6 gap-x-5">
                <DoubleIconLink
                    v-if="presentation.presentation_script"
                    :url="admin_scripts(presentation.presentation_script.id).url"
                    target="_blank"
                    :before-icon="Book"
                    :after-icon="ExternalLink"
                    :text="`Open: ${presentation.presentation_script.title}`"
                    class="grow"
                />
                <DoubleIconLink
                    :url="admin_script_index().url"
                    target="_blank"
                    :before-icon="CirclePlus"
                    :after-icon="ExternalLink"
                    text="Create a new script"
                    class="grow self-end"
                />
            </div>
        </fieldset>
    </Form>
</template>