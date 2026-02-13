<script setup lang="ts">
import { type Presentation } from '@/types';
import { presentations } from '@/routes';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Presentation;
    showGuard: boolean;
}>();

</script>

<template>
    <div
        data-component="PresentationLink"
        class="
            relative
            flex flex-col
            aspect-video p-4
            border rounded-xl
            "
    >
        <template v-if="showGuard">
            <span
                :data-guard="presentation.presentation_visibility.title"
                class="
                    absolute top-0 right-4
                    block px-2
                    border rounded-sm
                    -translate-y-1/2
                    italic text-sm
                    bg-white
                    "
            >
                {{ presentation.presentation_visibility.name }}
            </span>
        </template>
        <h3 class="font-semibold">
            {{ presentation.title }}
        </h3>
        <span class="creator | block">
            by: {{ presentation.user.name }}
        </span>

        <div class="mt-auto">
            <a :href="presentations(presentation.slug).url" target="_blank">
                Present
            </a>
            <template v-if="presentation.presentation_script">
                Script
            </template>
        </div>

        <PlaceholderPattern :interactable="false" />
    </div>
</template>