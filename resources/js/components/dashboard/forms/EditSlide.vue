<script setup lang="ts">
import { type PresentationSlide } from '@/types';
import { destroy, update } from '@/routes/admin_slide';
import { Form, ContentField, TextField, NumberField } from '@/components/global/form'

const emit = defineEmits(["updateSlideSuccess", "deleteSlideSuccess"]);
const props = defineProps<{
    parentId: number;
    slide: PresentationSlide;
    class?: string;
}>();
function emitSave() {
    console.log("emit: update");
    emit('updateSlideSuccess', props.slide.id);
}
function emitDelete() {
    console.log("emit: delete");
    emit('deleteSlideSuccess', props.slide.id);
}
</script>

<template>
    <div
        data-component="dashboard/forms/EditSlide"
        :class
        class="grid gap-x-5"
    >
        <Form
            :on-success="emitSave"
            :send-to="update.form(slide.id)"
            form-action="edit"
            v-slot="{errors}"
            button-text="Update"
            class="space-y-5"
        >
            <NumberField label="Order:" name="order" :min="0" :value="slide.order"/>
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
            :on-success="emitDelete"
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