<script setup lang="ts">
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
const props = defineProps<TextlikeFieldAttributes & {
    onChange?: (_input: HTMLTextAreaElement) => void,
    onInput?: (_input: HTMLTextAreaElement) => void,
}>();
function handleChange(_e: Event) {
    if(!props.onChange) return;
    const input = _e.target as HTMLTextAreaElement;
    if(!input) return;
    props.onChange(input);
}
function handleInput(_e: Event) {
    if(!props.onInput) return;
    const input = _e.target as HTMLTextAreaElement;
    if(!input) return;
    props.onInput(input);
}
</script>

<template>
     <FormField
        id-prefix="contentfield"
        :label :class
        :error
        :description
        :disabled :hidden
        v-slot="{ fieldId }"
     >
        <textarea
            v-on:change="handleChange"
            v-on:input="handleInput"
            :id="fieldId" :name :value :disabled
            :class="inputClasses()"
            class="min-h-[10lh] max-w-full overflow-clip resize-none"
        />
    </FormField>
</template>
