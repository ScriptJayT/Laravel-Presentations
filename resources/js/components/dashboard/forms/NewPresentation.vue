<script setup lang="ts">
import { store } from '@/routes/admin_presentation';
import { Form, FormField } from '@/components/global/form';
</script>

<template>
    <Form
        class="relative space-y-6"
        form-action="create"
        :send-to="store.form()"
        button-text="Create new Presentation"
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
        <FormField id="continue-on" label="Continue to edit-page:" >
            <input type="checkbox" name="goto" checked id="continue-on">
        </FormField>
    </Form>
</template>