<script setup lang="ts">
import { type Presentation } from '@/types';

import PresentationLink from '@/components/app/PresentationLink.vue';

const props = defineProps<{
    title: string;
    presentations: Array<Presentation>;
}>();

// for some reason, vue's proxy transforms array's to objects; causing issues when trying to get length
const totalPresentations = Array.isArray(props.presentations)
    ? props.presentations.length
    : Object.keys(props.presentations).length
</script>

<template>
    <div data-component="PresentationList" class="space-y-4">
        <h2> {{ title }} </h2>
        <template v-if="totalPresentations < 1">
            <p>None found</p>
        </template>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <template v-for="_presentation in presentations">
                <PresentationLink :presentation="_presentation" />
            </template>
        </div>
        <template v-if="totalPresentations > 0">
            <span>
                Showing: {{ totalPresentations }} presentation(s)
            </span>
        </template>
    </div>
</template>