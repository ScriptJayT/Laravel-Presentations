<script setup lang="ts">
import { type Presentation } from '@/types';
import { presentations } from '@/routes';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Presentation;
}>();

</script>

<template>
    <div  data-component="PresentationLink" class="relative | aspect-video | p-4 | border rounded-xl">
        <h3> {{ presentation.title }} </h3>
        <span class="creator | block">
            by: {{ presentation.user.name }}
        </span>
        <a :href="presentations(presentation.slug).url" target="_blank">
            /{{ presentation.slug }}
        </a>
        <div class="pointer-events-none" role="presentation">
            <PlaceholderPattern />
        </div>
    </div>
</template>