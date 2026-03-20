<script setup lang="ts">
import type { PresentationScript } from '@/types';
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
    <AppWrapper :meta-title="`Script: ${script.title}`">
        <AppHeader />
        <AppContent class="pt-15 pb-25">
            <Container>
                <h1 class="mb-10 text-5xl font-bold">{{ script.title }}</h1>
                <div v-html="script.renderedContent" />
            </Container>
        </AppContent>
        <AppFooter />
    </AppWrapper>
</template>
