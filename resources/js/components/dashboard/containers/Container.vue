<script setup lang="ts">
import { cn } from '@/lib/utils';
import { SectionHeading } from '@/components/global/text';

const props = withDefaults(
    defineProps<{
        id?: string;
        class?: string;
        title?: string;
    }>(),
    {
        class: "",
        title: "",
    }
);
</script>

<template>
    <section
        data-component="dashboard/containers/Container"
        :data-id="id"
        class="
            ct-inline-size | relative isolate
            grow flex flex-col
            px-6 md:px-4 dark:px-8 dark:md:px-6
            pt-6 pb-12
            rounded-xl
            "
    >
        <SectionHeading :title />
        <div :class="cn(props.class, ['grow'])">
            <slot />
        </div>
    </section>
</template>