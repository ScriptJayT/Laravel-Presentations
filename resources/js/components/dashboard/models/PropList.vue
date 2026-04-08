<script setup lang="ts">
import ReadonlyField from '@/components/global/form/fields/ReadonlyField.vue';
import { cn } from '@/lib/utils';
defineProps<{
    list: Record<string, string>;
    class?: string;
}>();
</script>

<template>
    <div
        data-component="dashboard/models/PropList"
        :class
    >
        <template v-for="_value, _key in list">
            <ReadonlyField
                :value="_value"
                :label="`${_key}:`"
            />
        </template>
    </div>
</template>