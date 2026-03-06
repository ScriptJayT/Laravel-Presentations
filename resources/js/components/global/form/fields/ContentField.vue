<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<TextlikeFieldAttributes>();
const id = `contentfield-${useId()}`;
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
