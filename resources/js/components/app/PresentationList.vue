<script setup lang="ts">
import { type Presentation } from '@/types';
import PresentationLink from '@/components/app/PresentationLink.vue';
import Heading from '@/components/Heading.vue';
const props = withDefaults(
    defineProps<{
        title: string;
        presentations: Array<Presentation>;
        showGuard?: boolean;
        showUser?: boolean;
        class?: string;
    }>(),
    {
        showGuard: false,
        showUser: true,
    }
);
const totalPresentations = Array.isArray(props.presentations)
    ? props.presentations.length
    : Object.keys(props.presentations).length
</script>

<template>
    <section
        data-component="app/PresentationList"
        :class
        class="
            space-y-4
            px-8 pt-8 pb-10
            border-3 rounded-4xl
            shadow-lg shadow-gray-500 dark:shadow-gray-400
            bg-gray-200 dark:bg-gray-800
            "
    >
        <div class="flex gap-4 justify-between flex-wrap">
            <Heading :title />
            <template v-if="totalPresentations < 1">
                <p class="m-0 min-w-fit"> None found </p>
            </template>
            <template v-else>
                <span class="block min-w-fit ml-auto my-0 | italic">
                    Showing: {{ totalPresentations }} presentation(s)
                </span>
            </template>
        </div>
        <div class="grid auto-rows-min gap-x-10 gap-y-12 md:grid-cols-3">
            <template v-for="_presentation in presentations">
                <PresentationLink
                    :presentation="_presentation"
                    :show-guard="showGuard"
                    :show-user="showUser"
                />
            </template>
        </div>
    </section>
</template>