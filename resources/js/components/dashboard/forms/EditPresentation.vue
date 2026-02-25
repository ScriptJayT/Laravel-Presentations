<script setup lang="ts">
import type { Presentation, PresentationVisibility, PresentationScript, } from '@/types';
import { admin_script_index, admin_scripts } from '@/routes';
import { update } from '@/routes/admin_presentation';

import { ExternalLink, Book, CirclePlus } from 'lucide-vue-next';
import { Form, FormField, SelectField, TextField } from '@/components/global/form';

const props = defineProps<{
    presentation: Presentation;
    allVisibilityRules: PresentationVisibility[];
    allScripts: PresentationScript[];
}>();
const visibilityOptions: Record<string, string> = {};
props.allVisibilityRules.forEach(_visibility => {
    visibilityOptions[_visibility.id] = `${_visibility.name}`;
});
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
            <SelectField
                name="script"
                label="Current Script:"
                null-value-text="None linked"
                :default-value="`${presentation.presentation_script?.id}`"
                :options="scriptOptions"
                :error="errors.script"
            />
            <div class="grid md:grid-cols-2 gap-x-10">
                <template v-if="presentation.presentation_script">
                    <a
                        :href="admin_scripts(presentation.presentation_script.id).url"
                        target="_blank"
                        class="
                            flex gap-3 justify-between items-center
                            p-4
                            border-2 rounded-md
                            outline-offset-4
                            text-center text-balance
                            hover:bg-accent dark:hover:bg-accent/50
                            transition-colors
                            "
                    >
                        <span aria-hidden="true"> <Book class="size-4"/> </span>
                        <span> Open: {{ presentation.presentation_script.title }} </span>
                        <span aria-hidden="true"> <ExternalLink class="size-4"/> </span>
                    </a>
                </template>
                <a
                    :href="admin_script_index().url"
                    target="_blank"
                    class="
                        col-start-2
                        flex gap-3 justify-between items-center
                        p-4
                        border-2 rounded-md
                        outline-offset-4
                        text-center text-balance
                        hover:bg-accent dark:hover:bg-accent/50
                        transition-colors
                        "
                >
                    <span aria-hidden="true"> <CirclePlus class="size-4"/> </span>
                    <span> Create a new script </span>
                    <span aria-hidden="true"> <ExternalLink class="size-4"/> </span>
                </a>
            </div>
        </fieldset>
    </Form>
</template>