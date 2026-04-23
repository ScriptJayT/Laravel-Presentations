<script setup lang="ts">
import { Upload } from '@lucide/vue';
import { cn } from '@/lib/utils';
import { FormField, inputClasses, type TextlikeFieldAttributes } from '@/components/global/form';
const props = defineProps<TextlikeFieldAttributes & {
    accept?: string,
    onChange?: (_input: HTMLInputElement) => void,
}>();
function handleChange(_e: Event) {
    const input = _e.target as HTMLInputElement;
    if(!input) return;

    if(props.onChange) {
        props.onChange(input);
    }
}
</script>

<template>
     <FormField
        id-prefix="filefield"
        :class
        :label :description
        :error
        :disabled :hidden :inert
        v-slot="{ fieldId }"
     >
        <div
            :data-id="fieldId"
            data-component="global/form/fields/FileField"
            class="grid gap-x-2 items-center"
        >
            <input
                v-on:drop.prevent=""
                v-on:change="handleChange"
                :id="fieldId"
                :name="name!=='--' ? name : undefined"
                :value :disabled :accept
                type="file"
                :class="cn(inputClasses(), 'cursor-pointer')"
            />
            <Upload
                aria-hidden="true"
                class="size-4"
            />
        </div>
    </FormField>
</template>

<style scoped>
    div.grid {
        grid-template-columns: auto 1fr;
    }
    input {
        user-select: none;
        color: transparent;
        width: 12ch;
        overflow: hidden;

        &::file-selector-button {
            cursor: pointer;
            color: var(--foreground);
        }
    }
</style>