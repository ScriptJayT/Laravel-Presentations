<script setup lang="ts">
import { safeQuery } from '@/lib/utils';
import { AppLogo } from '../global/logo';
import AppNavList from './AppNavList.vue';
withDefaults(
    defineProps<{ isLoggedIn?: boolean }>(),
    { isLoggedIn: false }
);
async function skipToContent(_e: MouseEvent) {
    const content = safeQuery('#site-content');
    if (!content) return;
    _e.preventDefault();
    content.focus({ preventScroll: true });
    content.scrollIntoView({ behavior: 'smooth' });
}
</script>

<template>
    <a
        href="#site-content"
        @click="skipToContent"
        class="skip-content | fixed top-3 left-5 block rounded-md border-2 border-neutral-500 bg-background px-5 py-1.5 outline-offset-6 transition-all hover:scale-105 hover:border-cyan-600 hover:bg-background/90 focus-visible:scale-105 focus-visible:border-cyan-600 focus-visible:outline-2 dark:border-cyan-900 dark:hover:border-cyan-500 dark:focus-visible:border-cyan-500"
    >
        Skip to Content
    </a>

    <header
        id="site-header"
        class="border-b-2 border-cyan-300 bg-neutral-50 dark:border-b-3 dark:border-cyan-900 dark:bg-neutral-950"
    >
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-6 px-4 py-5"
        >
            <div class="mr-auto flex items-center gap-3">
                <AppLogo />
            </div>
            <nav class="block w-fit min-w-fit select-none">
                <AppNavList :is-logged-in="isLoggedIn" />
            </nav>
        </div>
    </header>
</template>

<style scoped>
.skip-content {
    translate: 0 calc(-100% - var(--spacing) * 3);

    &:focus-visible {
        translate: 0 0;
    }
}
</style>
