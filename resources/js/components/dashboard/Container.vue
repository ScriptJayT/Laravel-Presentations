<script setup lang="ts">
import Heading from '@/components/Heading.vue';

const props = defineProps<{
    class?: string;
    title?: string;
}>();
const classList = props.class ?? "";
</script>

<template>
    <div
        data-component="dashboard/Container"
        class="
            ct-inline-size |
            space-y-4
            px-6 md:px-4 dark:px-8 dark:md:px-6
            py-6
            rounded-xl
            "
    >
        <template v-if="title">
            <Heading :title/>
        </template>
        <div :class="classList">
            <slot />
        </div>
    </div>
</template>