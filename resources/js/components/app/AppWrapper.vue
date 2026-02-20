<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
defineProps<{
    metaTitle?: string;
}>();
</script>

<template>
    <template v-if="metaTitle">
        <Head :title="metaTitle" />
    </template>

    <div class="min-h-screen flex flex-col">
        <slot/>
    </div>
</template>