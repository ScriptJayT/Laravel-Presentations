<script setup lang="ts">
import { type Presentation } from '@/types';
import { plural } from '@/lib/utils';
import { SectionHeading } from '../global/text';
import PresentationLink from '@/components/app/PresentationLink.vue';
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
</script>

<template>
    <section
        data-component="app/PresentationList"
        :class
        class="
            space-y-4
            px-8 pt-8 pb-10
            border-3 rounded-4xl
            shadow-lg shadow-gray-500 dark:shadow-md dark:shadow-gray-400
            bg-card
            "
    >
        <div class="flex gap-4 justify-between flex-wrap">
            <SectionHeading :title />
            <span class="block min-w-fit ml-auto my-0 italic">
                {{ plural(presentations, 'presentation') }} found
            </span>
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