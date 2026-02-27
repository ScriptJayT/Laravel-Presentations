<script setup lang="ts">
import { Form, TextField } from '@/components/global/form';
import { store } from '@/routes/admin_user';

defineProps<{ class?: string }>()
</script>

<template>
    <Form
        :send-to="store.form()"
        form-action="create"
        v-slot="{errors}"
        button-text="Create new User"
        :class
        class="space-y-5"
    >
        <TextField
            name="name"
            label="Username:"
            :error="errors.name"
        />
        <TextField
            name="email"
            label="Email:"
            :error="errors.email"
        />
        <TextField
            name="password"
            label="Password:"
            :error="errors.password"
        />
        <TextField
            name="password_confirmation"
            label="Confirm Password:"
        />
    </Form>
</template>