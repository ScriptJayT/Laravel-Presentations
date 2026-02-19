<script setup lang="ts">
import { TriangleAlert } from 'lucide-vue-next';

defineProps<{
    message?: string;
}>();
</script>

<template>
    <div v-show="message" class="flex gap-2 items-center">
        <TriangleAlert class="size-4"/>
        <p class="text-sm text-red-600 dark:text-red-500">
            {{ message }}
        </p>
    </div>
</template>
