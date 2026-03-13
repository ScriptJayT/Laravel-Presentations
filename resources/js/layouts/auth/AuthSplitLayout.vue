<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { AppIcon } from '@/components/global/logo';
import { home } from '@/routes';
const name = usePage().props.name;
defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="
        relative
        grid
        lg:grid-cols-2
        h-dvh
        flex-col items-center justify-center
        lg:max-w-none
        px-8 sm:px-0 lg:px-0
        "
    >
        <div class="
            relative
            hidden lg:flex flex-col
            h-full p-10
            dark:border-r
            text-white
            bg-muted
            "
        >
            <div class="absolute inset-0 bg-zinc-900" />
            <Link
                :href="home()"
                class="relative z-20 flex items-center text-lg font-medium"
            >
                <AppIcon class="mr-2 size-8 fill-current text-white" />
                {{ name }}
            </Link>
        </div>
        <div class="lg:p-8">
            <div
                class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]"
            >
                <div class="flex flex-col space-y-2 text-center">
                    <h1 class="text-xl font-medium tracking-tight" v-if="title">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-muted-foreground" v-if="description">
                        {{ description }}
                    </p>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
