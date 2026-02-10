<script setup lang="ts">
import {
    type Presentation,
} from '@/types';
import { Head } from '@inertiajs/vue3';

import AppContent from '@/components/AppContent.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Required<Presentation>;
}>();
</script>

<template>
    <Head :title="presentation.title" />

    <AppContent>
        <slide-show class="relative | h-screen space-y-10 | pi-8 overflow-x-clip overflow-y-scroll">
            <slide
                :data-theme="presentation.presentation_theme.title + ' intro'"
                class="relative | block h-full | p-8 border rounded-4xl | bg-amber-200 | overflow-clip"
            >
                <h1> {{ presentation.title }} </h1>
                <span class="created_on | block">
                    created on: {{ presentation.created_at }}
                </span>
                <span class="creator | block">
                    by: {{ presentation.user.name }}
                </span>
                <PlaceholderPattern :interactable="false"/>
            </slide>

            <template v-for="_slide in presentation.slides">
                <slide
                    :data-theme="_slide.presentation_theme.title + ' ' + presentation.presentation_theme.title"
                    class="relative | block h-full | p-8 border rounded-4xl | bg-amber-200 | overflow-clip"
                >
                    <h2> {{ _slide.title }} </h2>
                    <div v-html="_slide.content" />
                    <PlaceholderPattern :interactable="false" />
                </slide>
            </template>
        </slide-show>
    </AppContent>
</template>

<style is="scoped">
    slide-show {
        scroll-snap-type: y mandatory;
    }
    slide {
        scroll-snap-align: center;
    }
</style>