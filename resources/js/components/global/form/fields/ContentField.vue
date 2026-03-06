<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
const props = defineProps<TextlikeFieldAttributes & {
    onChange?: (_input: HTMLTextAreaElement) => void,
    onInput?: (_input: HTMLTextAreaElement) => void,
}>();
function handleChange(_e: Event) {
    const input = _e.target as HTMLTextAreaElement;
    if(!input) return;
    if(props.onChange) props.onChange(input);
}
function handleInput(_e: Event) {
    const input = _e.target as HTMLTextAreaElement;
    if(!input) return;
    if(props.onInput) props.onInput(input);
}
const id = `contentfield-${useId()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden >
        <textarea
            v-on:change="handleChange"
            v-on:input="handleInput"
            :id :name :value :disabled
            :class="inputClasses()"
            class="min-h-[10lh] resize-none"
        />
    </FormField>
</template>
