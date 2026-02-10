<script setup lang="ts">
import { type Presentation } from '@/types';

import PresentationLink from '@/components/app/PresentationLink.vue';

const props = defineProps<{
    title: string;
    presentations: Presentation[];
}>();
</script>

<template>
    <div class="space-y-4 p-4">
        <h2> {{ title }} </h2>
        <template v-if="presentations.length < 1">
            <p>None found</p>
        </template>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <template v-for="_presentation in presentations">
                <PresentationLink :presentation="_presentation" />
            </template>
        </div>
        <template v-if="presentations.length > 0">
            <span>
                Showing: {{ presentations.length }} presentation(s)
            </span>
        </template>
    </div>
</template>