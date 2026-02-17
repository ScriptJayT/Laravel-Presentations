<script setup lang="ts">
import { type PresentationScript } from '@/types';

import { Head } from '@inertiajs/vue3';

import Container from '@/components/app/Container.vue';
import AppWrapper from '@/components/app/AppWrapper.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import AppContent from '@/components/app/AppContent.vue';
import AppFooter from '@/components/app/AppFooter.vue';

defineProps<{
    script: Required<PresentationScript>;
}>();
</script>

<template>
    <Head :title="`Script: ${script.title}`" />

    <AppWrapper>
        <AppHeader />

        <AppContent class="mt-15 mb-25">
            <Container>
                <h1 class="font-bold text-5xl mb-10"> {{ script.title }} </h1>
                <div v-html="script.renderedContent" />
            </Container>
        </AppContent>

        <AppFooter />
    </AppWrapper>
</template>
