<script setup lang="ts">
import { FormField, type RangelikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<RangelikeFieldAttributes>();
const id = `numberfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :description :disabled :id :hidden>
        <input
            :name :id type="number"
            :value :min :max :step
            :class="inputClasses()"
        >
    </FormField>
</template>