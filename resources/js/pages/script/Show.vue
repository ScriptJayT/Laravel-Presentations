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
                <h1 class="mb-10 text-5xl text-center">{{ script.title }}</h1>
                <div v-html="script.renderedContent" class="script-content space-y-5 max-w-3xl mx-auto" />
            </Container>
        </AppContent>
        <AppFooter />
    </AppWrapper>
</template>

<style>
    .script-content {
        & h2, h3, h4, h5, h6 {
            font-weight: var(--font-weight-semibold);
        }
        & h2 {
            font-size: var(--text-3xl);
        }
        & h3 {
            font-size: var(--text-2xl);
        }
        & h4 {
            font-size: var(--text-xl);
        }
        & p {
            line-height: 1.7;
        }
    }
</style>