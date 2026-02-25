<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { SidebarProvider } from '@/components/ui/sidebar';
import type { AppShellVariant } from '@/types';

type Props = {
    variant?: AppShellVariant;
};

defineProps<Props>();

const isOpen = usePage().props.sidebarOpen as boolean;
</script>

<template>
    <div
        v-if="variant === 'header'"
        data-component="AppShell"
        class="flex min-h-screen w-full flex-col"
    >
        <slot />
    </div>
    <SidebarProvider
        v-else
        data-component="AppShell"
        :default-open="isOpen"
    >
        <slot />
    </SidebarProvider>
</template>
