<script setup lang="ts">
import { useId } from 'vue';
import { FormField, inputClasses, type TextlikeFieldAttributes } from '@/components/global/form';
const props = defineProps<TextlikeFieldAttributes & {
    accept?: string,
    onChange?: (_input: HTMLInputElement) => void,
}>();
const id = `filefield-${useId()}`;
function handleChange(_e: Event) {
    const input = _e.target as HTMLInputElement;
    if(!input) return;

    if(props.onChange) {
        props.onChange(input);
    }
}
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden :inert>
        <input
            data-component="global/form/fields/FileField"
            v-on:change="handleChange"
            :id :name :value :disabled :accept
            type="file"
            :class="inputClasses()"
            class="cursor-pointer"
        />
    </FormField>
</template>

<style scoped>
    input {
        user-select: none;
        color: transparent;
        &::file-selector-button {
            color: var(--foreground);
        }
    }
</style>