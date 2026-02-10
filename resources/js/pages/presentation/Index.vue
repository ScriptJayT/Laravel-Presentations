<script setup lang="ts">
import { type Presentation } from '@/types';
import { Head } from '@inertiajs/vue3';

import PresentationLink from '@/components/app/PresentationLink.vue';

const props = defineProps<{
    allPublicPresentations: Presentation[];
    allPrivatePresentations: Presentation[];
    allCreatorPresentations: Presentation[];
    isLoggedIn: boolean;
}>();

console.log(
    props.allCreatorPresentations, props.allPrivatePresentations, 
    props.allPublicPresentations, props.isLoggedIn
);
</script>

<template>
    <Head title="Home" />

    <div class="space-y-4 p-4" >
        <h2>Public Presentations</h2>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <template v-for="_presentation in allPublicPresentations">
                <PresentationLink :presentation="_presentation" />
            </template>
        </div>
    </div>

    <template v-if="isLoggedIn">
        <div class="space-y-4 p-4" >
            <h2>Private Presentations</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allPrivatePresentations">
                    <PresentationLink :presentation="_presentation" />
                </template>
            </div>
        </div>
    
        <div class="space-y-4 p-4" >
            <h2>Your Presentations</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allCreatorPresentations">
                    <PresentationLink :presentation="_presentation" />
                </template>
            </div>
        </div>
    </template>

</template>
