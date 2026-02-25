<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { AlertCircle } from 'lucide-vue-next';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

type Flash = {
    success?: string,
    error?: string,
    info?: string,
}
const flash = computed(() => usePage().props.flash).value as Flash;
const anyMessage = !!(flash.info || flash.error || flash.success);
const message = [flash.info, flash.error, flash.success].join("\n");
</script>

<template>
    <Alert
        v-show="anyMessage"
        data-component="global/AlertFlash"
        class="
            cursor-default
            fixed z-100 right-0 top-6
            w-fit border-2
            motion-safe:animate-flash hover:paused
            "
    >
        <AlertCircle class="size-4" />
        <AlertTitle class="min-w-[10ch]"> Server Bot: </AlertTitle>
        <AlertDescription class="capitalize">
           {{message}}
        </AlertDescription>
    </Alert>
</template>
