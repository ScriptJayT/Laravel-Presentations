<script setup lang="ts">
import { TextField, CheckboxField, type FieldAttributes } from '@/components/global/form';
type checkfield = {
    type: "check",
    value?: "on",
};
type textfield = {
    type: "text",
    value?: string,
};
type prop = Omit<FieldAttributes, 'name'> & (checkfield | textfield);
defineProps<prop>();
</script>

<template>
    <template v-if="type==='text'" >
        <TextField name="goto" :value :disabled hidden />
    </template>
    <template v-else>
        <CheckboxField name="goto" :checked="(value==='on')" :label :class :error :description :disabled :hidden />
    </template>
</template>