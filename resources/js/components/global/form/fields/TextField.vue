<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type TextlikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<TextlikeFieldAttributes>();
const id = `textfield-${useId()}`;
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