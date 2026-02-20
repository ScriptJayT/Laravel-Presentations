<script setup lang="ts">
import { store } from '@/routes/admin_script';
import { Form, FormField } from '@/components/global/form';
</script>

<template>
    <Form
        class="space-y-6"
        form-action="create"
        :send-to="store.form()"
        success-message="New Script was created"
        show-button
        button-text="Create new script"
        v-slot="{ errors }"
    >
        <FormField :error="errors.title" label="Script Title:" id="script-title">
            <input
                type="text" name="title" id="script-title"
                class="grow outline-none"
            >
        </FormField>
        <FormField id="continue-on" label="Continue to edit-page:" >
            <input type="checkbox" name="goto" checked id="continue-on">
        </FormField>
    </Form>
</template>