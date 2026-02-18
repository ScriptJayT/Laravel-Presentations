<script setup lang="ts">
const props = defineProps<{
    title?: string;
    hiddenTitle?: boolean;
    class?:string;
}>();
</script>
<template>
    <div :class class="max-w-full w-3xs space-y-3 p-4 border rounded-xl">
        <template v-if="title">
            <h3 :class="hiddenTitle ? 'sr-only' : '' "> {{ title }} </h3>
        </template>
        <slot/>
    </div>
</template>