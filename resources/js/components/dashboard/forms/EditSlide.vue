<script setup lang="ts">
import { type PresentationSlide } from '@/types';
import { Form, ContentField, TextField } from '@/components/global/form'
import { destroy, update } from '@/routes/admin_slide';


const emit = defineEmits(['success']);
defineProps<{
    parentId: number;
    slide: PresentationSlide;
    class?: string;
}>();
</script>

<template>
    <div
        data-component="dashboard/forms/EditSlide"
        :class
        class="grid gap-x-5"
    >
        <Form
            :send-to="update.form(slide.id)"
            form-action="edit"
            v-slot="{errors}"
            button-text="Update"
            class="space-y-5"
        >
            <TextField
                label="Title:"
                name="title"
                :value="slide.title"
                :error="errors.title"
            />
            <ContentField
                name="content"
                :value="slide.content"
                :error="errors.content"
            />
       </Form>

        <Form
            :send-to="destroy.form(slide.id)"
            form-action="delete"
            button-text="Delete"
        >
           <p>Are u sure?</p>
        </Form>
    </div>
</template>

<style scoped>
    div.grid {
        grid-template-columns: 3fr 1fr;
    }
</style>