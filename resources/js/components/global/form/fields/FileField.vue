<script setup lang="ts">
import { FormField, inputClasses, type TextlikeFieldAttributes } from '@/components/global/form';
defineProps<TextlikeFieldAttributes>();
const id = `filefield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden>
        <input
            :id :name :value :disabled
            type="file"
            :class="inputClasses()"
            class="cursor-pointer"
        />
    </FormField>
</template>
