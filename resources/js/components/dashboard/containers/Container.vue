<script setup lang="ts">
import Heading from '@/components/Heading.vue';

const props = defineProps<{
    id?: string;
    class?: string;
    title?: string;
}>();
</script>

<template>
    <section
        data-component="dashboard/Container"
        :data-id="id"
        class="
            ct-inline-size | relative isolate
            grow flex flex-col
            px-6 md:px-4 dark:px-8 dark:md:px-6
            pt-6 pb-12
            rounded-xl
            "
    >
        <Heading :title="title ?? ''"/>
        <div :class class="grow">
            <slot />
        </div>
    </section>
</template>