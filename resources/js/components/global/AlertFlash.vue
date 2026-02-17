<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
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

console.log(flash, anyMessage, message);
</script>

<template>
    <Alert
        v-show="anyMessage"
        class="
            fixed z-100 right-0 top-5
            w-fit border-2
            "
    >
        <AlertCircle class="size-4" />
        <AlertTitle class="min-w-[10ch]"> Hello </AlertTitle>
        <AlertDescription class="capitalize">
           {{message}}
        </AlertDescription>
    </Alert>
</template>
