<script setup lang="ts">
import FormField from '@/components/global/form/FormField.vue';
import { Save } from 'lucide-vue-next';

import { store } from '@/routes/admin_presentation';
import { Form } from '@/components/global/form';
</script>

<template>
    <Form
        id="update-script-form"
        class="
            relative
            grid gap-6
            inert:opacity-50
            "
        :send-to="store.form()"
        form-action="create"
        success-message="New Presentation was created"
        v-slot="{ errors }"
    >
        <FormField
            id="presentation-title" label="Title:"
            :error="errors.title || errors.slug"
        >
            <input
                type="text" name="title" id="presentation-title"
                class="grow outline-none"
            >
        </FormField>

        <label class="cursor-pointer flex gap-2 items-center">
            <span class="select-none">Directly go to edit-page</span>
            <input type="checkbox" name="goto" checked>
        </label>

        <div class="flex gap-5 items-end">
            <button
                class="
                    cursor-pointer select-none
                    flex items-center gap-1
                    w-fit
                    px-3 py-2 ml-auto
                    border border-green-700 rounded-md
                    outline-offset-8
                    "
            >
                <span> Create new Presentation </span>
                <Save class="size-4"/>
            </button>
        </div>
    </Form>
</template>