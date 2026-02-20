<script setup lang="ts">
import { TextField, CheckboxField } from '@/components/global/form';

type field = {
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
};
type checkfield = {
    type: "check",
    value?: "on",
} & field;
type textfield = {
    type: "text",
    value?: string,
} & field;
type prop = checkfield | textfield;
defineProps<prop>();
</script>

<template>
    <template v-if="type==='text'" >
        <TextField hidden name="goto" :value />
    </template>
    <template v-else>
        <CheckboxField name="goto" :checked="(value==='on')" :label :class :error :descr />
    </template>
</template>