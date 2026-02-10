<script setup lang="ts">
import { 
    type Presentation,
} from '@/types';
import { Head } from '@inertiajs/vue3';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

defineProps<{
    presentation: Presentation;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <div class="h-full space-y-4 rounded-xl p-4" >
        <h2> {{ presentation.title }} </h2>
        <div class="p-4 | border rounded-xl">
            <span class="created_on | block">
                created on: {{ presentation.created_at }}
            </span>
            <span class="creator | block">
                by: {{ presentation.user.name }}
            </span>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative | aspect-video | p-4 | border rounded-xl">
                <div class="pointer-events-none" role="presentation">
                    <PlaceholderPattern />
                </div>
            </div>
        </div>
    </div>
</template>
