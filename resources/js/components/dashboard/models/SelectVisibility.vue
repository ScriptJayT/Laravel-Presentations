<script setup lang="ts">
import type { PresentationVisibility } from '@/types';
import { SelectField } from '@/components/global/form';
const props = defineProps<{
    currentRule: number;
    error?: string;
    rules: PresentationVisibility[];
}>();
const visibilityOptions: Record<string, string> = {};
props.rules.forEach(_visibility => visibilityOptions[_visibility.id] = `${_visibility.name}`);
</script>

<template>
    <SelectField
        name="visibility"
        label="Visibility:"
        :default-value="`${currentRule}`"
        :allow-null-value="false"
        :error
        :options="visibilityOptions"
    />
</template>