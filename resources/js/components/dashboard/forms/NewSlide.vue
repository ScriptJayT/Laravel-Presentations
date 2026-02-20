<script setup lang="ts">
import { store } from '@/routes/admin_script';
import { Form, FormField, TextField } from '@/components/global/form';
</script>

<template>
    <Form
        class="space-y-6"
        form-action="create"
        :send-to="store.form()"
        button-text="Create new Slide"
        success-message="New Slide was created"
        v-slot="{ errors }"
    >
        <TextField
            name="title"
            label="Title:"
            :error="errors.title || errors.slug"
        />
        <FormField id="continue-on" label="Continue to edit-page:" >
            <input type="checkbox" name="goto" checked id="continue-on">
        </FormField>
    </Form>
</template>