<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { AlertCircle } from 'lucide-vue-next';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';

const flash = computed(() => usePage().props.flash);
console.log(flash);
console.log(flash.value);
</script>

<template>
    <Alert class="fixed z-100 right-0 top-5 w-fit border-2" v-if="flash">
        <AlertCircle class="size-4" />
        <AlertTitle class="min-w-[10ch]"> Hello </AlertTitle>
        <AlertDescription>
           Test
        </AlertDescription>
    </Alert>
</template>
