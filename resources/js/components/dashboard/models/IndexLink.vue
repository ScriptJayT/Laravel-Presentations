<script setup lang="ts">
import { type RouteDefinition } from '@/wayfinder';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    title: string;
    semanticTitle?: boolean;
    link?: RouteDefinition<'get'>;
    lastEdit?: string;
}>();
</script>

<template>
    <div
        class="
            ct-inline-size
            relative isolate
            flex flex-col
            aspect-video
            p-4 border border-transparent rounded-xl
            "
    >
        <template v-if="semanticTitle">
            <span class="model-entry--title | text-lg font-semibold" aria-hidden="true">
                {{ title }}
            </span>
        </template>
        <template v-else>
            <h3 class="model-entry--title | text-lg font-semibold">
                {{ title }}
            </h3>
        </template>

        <slot />

        <template v-if="lastEdit">
            <span class="model-entry--last-edit | block text-sm">
                Last edit: {{ lastEdit }}
            </span>
        </template>
        <template v-if="link">
            <a
                class="
                    model-entry--link |
                    absolute inset-0
                    border-2 rounded-xl hover:border-cyan-700 focus-visible:border-cyan-700
                    outline-offset-8
                    "
                :href="link.url"
                :title="`Open: ${title}`"
            ></a>
        </template>
        <PlaceholderPattern :interactable="false"/>
    </div>
</template>