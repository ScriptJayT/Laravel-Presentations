<script setup lang="ts">
import { FormField } from '@/components/global/form';
defineProps<{
    name: string;
    value?: string;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
}>();
const id = `contentfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <textarea
            :id :name :value
            class="outline-none min-h-[10lh] resize-none"
        />
    </FormField>
</template>
