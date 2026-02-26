<script setup lang="ts">
import { FormField } from '@/components/global/form';
defineProps<{
    name: string;
    value?: string;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
    disabled?: boolean;
}>();
const id = `textfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <input
            :name
            :value
            :id type="text"
            class="grow outline-none"
            :disabled
        >
    </FormField>
</template>