<script setup lang="ts">
import { store } from '@/routes/admin_presentation';
import { Form, RedirectToField, TextField } from '@/components/global/form';
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
        <TextField
            name="title"
            label="Title:"
            :error="errors.title || errors.slug"
        />
        <RedirectToField
            type="check"
            label="Go straight to /edit"
            value="on"
        />
    </Form>
</template>