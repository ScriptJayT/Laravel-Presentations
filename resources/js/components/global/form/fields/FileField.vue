<script setup lang="ts">
import { FormField } from '@/components/global/form';
defineProps<{
    name: string;
    value?: string;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
    disabled?: boolean
}>();
const id = `filefield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <input
            :id :name :value :disabled
            type="file"
            class="cursor-pointer outline-none"
        />
    </FormField>
</template>
