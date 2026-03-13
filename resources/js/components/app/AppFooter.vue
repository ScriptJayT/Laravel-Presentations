<script setup lang="ts">
import { getAppName } from '@/lib/utils';
import { LaravelLogo } from '../global/logo';
</script>
<template>
    <footer
        id="site-footer"
        class="
            mt-auto
            py-5
            border-t-2 dark:border-t-3
            border-cyan-300 dark:border-cyan-900
            bg-neutral-50 dark:bg-neutral-950
            "
    >
        <div class="px-5">
            <p class="text-center">
                These works were brought to you by: <br> the amazing users of {{ getAppName() }}
            </p>
            <p class="text-center mt-5 mb-1"> Powered by: </p>
            <div class="flex gap-2 items-center justify-center">
                <LaravelLogo />
            </div>
        </div>
    </footer>
</template>