<script setup lang="ts">
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<TextlikeFieldAttributes>();
const id = `contentfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden >
        <textarea
            :id :name :value :disabled
            :class="inputClasses()"
            class="min-h-[10lh] resize-none"
        />
    </FormField>
</template>
