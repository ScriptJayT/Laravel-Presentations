<script setup lang="ts">
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<TextlikeFieldAttributes>();
const id = `textfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden>
        <input
            :id :name :value :disabled
            type="text"
            :class="inputClasses()"
        >
    </FormField>
</template>