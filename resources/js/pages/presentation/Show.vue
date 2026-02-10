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

console.log(props.presentation.slides);

</script>

<template>
    <Head :title="presentation.title" />

    <AppContent>
        <slide-show class="relative | h-screen space-y-10 | pi-8 overflow-x-clip overflow-y-scroll">
            <slide class="relative | block h-full | p-8 border rounded-4xl | bg-amber-200 | overflow-clip">
                <h2> {{ presentation.title }} </h2>
                <span class="created_on | block">
                    created on: {{ presentation.created_at }}
                </span>
                <span class="creator | block">
                    by: {{ presentation.user.name }}
                </span>
                <div class="pointer-events-none" role="presentation">
                    <PlaceholderPattern />
                </div>
            </slide>

            <template v-for="_slide in presentation.slides">
                <slide class="relative | block h-full | p-8 border rounded-4xl | bg-amber-200 | overflow-clip">
                    <div class="pointer-events-none" role="presentation">
                        <PlaceholderPattern />
                    </div>
                </slide>
            </template>
        </slide-show>
    </AppContent>
</template>
