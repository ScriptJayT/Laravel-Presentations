<script setup lang="ts">
import { FormField } from '@/components/global/form';
defineProps<{
    name: string;
    value?: number;
    min?: number;
    max?: number;
    step?: number;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
}>();
const id = `numberfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <input
            :name :id type="number"
            :value
            :min :max :step
            class="grow outline-none"
        >
    </FormField>
</template>