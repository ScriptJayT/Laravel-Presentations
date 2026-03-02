<script setup lang="ts">
import { PresentationScript, PresentationVisibility } from '@/types';
import { Form, FormField, ContentField, SelectField } from '@/components/global/form';
import { update } from '@/routes/admin_script';

const props = defineProps<{
    script: PresentationScript;
    allVisibilityRules: PresentationVisibility[];
}>();
const visibilityOptions: Record<string, string> = {};
props.allVisibilityRules.forEach(_visibility => {
    visibilityOptions[_visibility.id] = `${_visibility.name}`;
});
</script>
<template>
    <Form
        id="update-script-form"
        form-action="edit"
        class="
            space-y-6
            max-w-[90ch] h-fit
            mx-auto inert:opacity-50
            "
        :show-button="false"
        :send-to="update.form(script.id)"
        v-slot="{ errors }"
    >
        <FormField
            id="script-title" label="Title:"
            :error="errors.title"
        >
            <input
                id="script-title" name="title" type="text"
                v-model.lazy="script.title"
                class="grow outline-none"
            />
        </FormField>

        <SelectField
            name="visibility"
            label="Visibility:"
            :default-value="`${script.presentation_visibility.id}`"
            :allow-null-value="false"
            :error="errors.visibility"
            :options="visibilityOptions"
        />

        <ContentField
            name="content"
            :error="errors.content"
            :value="script.content.trim()"
        />
    </Form>
</template>