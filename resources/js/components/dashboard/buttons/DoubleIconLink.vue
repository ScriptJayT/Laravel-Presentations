<script setup lang="ts">
import { FunctionalComponent } from 'vue';
import { cn } from '@/lib/utils';
import { formfieldButtonClasses, doubleIconButtonClasses } from '.';
const props = defineProps<{
    target: '_blank' | '_self';
    url: string;
    beforeIcon: FunctionalComponent;
    afterIcon: FunctionalComponent;
    class?: string;
    text?: string;
}>();
</script>

<template>
    <a
        :href="url"
        :target
        :class="
            cn(props.class, formfieldButtonClasses(), doubleIconButtonClasses())
        "
    >
        <span aria-hidden="true">
            <component :is="beforeIcon" class="size-4" />
        </span>
        <span> {{ text }} <slot /> </span>
        <span aria-hidden="true">
            <component :is="afterIcon" class="size-4" />
        </span>
    </a>
</template>
