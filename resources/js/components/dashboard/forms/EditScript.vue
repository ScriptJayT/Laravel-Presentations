<script setup lang="ts">
import { PresentationScript, PresentationVisibility } from '@/types';
import { Form, FormField, ContentField } from '@/components/global/form';
import SelectVisibility from '../models/SelectVisibility.vue';
import { update } from '@/routes/admin_script';
defineProps<{
    script: PresentationScript;
    allVisibilityRules: PresentationVisibility[];
}>();
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
        <SelectVisibility
            :current-rule="script.presentation_visibility.id"
            :rules="allVisibilityRules"
        />
        <ContentField
            name="content"
            :error="errors.content"
            :value="script.content.trim()"
        />
    </Form>
</template>