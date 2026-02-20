<script setup lang="ts">
import { store } from '@/routes/admin_script';
import { Form, RedirectToField, TextField } from '@/components/global/form';
</script>

<template>
    <Form
        class="space-y-6"
        form-action="create"
        :send-to="store.form()"
        button-text="Create new script"
        success-message="New Script was created"
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