<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type RangelikeFieldAttributes, inputClasses } from '@/components/global/form';
defineProps<RangelikeFieldAttributes>();
const id = `numberfield-${useId()}`;
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