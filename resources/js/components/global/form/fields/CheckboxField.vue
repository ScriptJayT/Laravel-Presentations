<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type FieldAttributes } from '@/components/global/form';
defineProps<FieldAttributes & {
    checked?: boolean;
}>();
const id = `checkboxfield-${useId()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden>
        <input
            :name :id :checked type="checkbox"
            class="outline-none"
            :disabled
        >
    </FormField>
</template>
