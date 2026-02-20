<script setup lang="ts">
import { FormField } from '@/components/global/form';
defineProps<{
    name: string;
    checked?: boolean;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
}>();
const id = `checkboxfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <input
            :name :id :checked type="checkbox"
            class="outline-none"
        >
    </FormField>
</template>
