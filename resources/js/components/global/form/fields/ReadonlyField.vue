<script setup lang="ts">
import { TextField } from '..';
defineProps<{
    label: string;
    value?: string|number;
}>();
</script>

<template>
    <TextField name="--" :label :value="`${value}`" :disabled="true" />
</template>