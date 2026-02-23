<script setup lang="ts">
import { store } from '@/routes/admin_slide';
import { Form, TextField } from '@/components/global/form';

defineProps<{
    parentId: number;
}>();
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
            :error="errors.title"
        />
        <hidden>
            <input type="hidden" name="presentation" :value="parentId">
        </hidden>
    </Form>
</template>