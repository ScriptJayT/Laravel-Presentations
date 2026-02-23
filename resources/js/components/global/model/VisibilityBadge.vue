<script setup lang="ts">
import { type PresentationVisibility } from '@/types';
import { Shield, Lock, LockOpen } from "lucide-vue-next";

defineProps<{
    visibility: PresentationVisibility;
    class?: string;
}>();

</script>

<template>
  <span
        data-component="global/model/VisibilityBadge"
        :data-title="visibility.title"
        :class
        class="
            pointer-events-none select-none
            flex gap-2 items-center
            py-1 px-3
            border rounded-sm
            bg-white
            "
    >
        <span class="italic text-md">
            {{ visibility.name }}
        </span>
        <span>
            <template v-if="visibility.title === 'creator'">
                <Lock class="size-4"/>
            </template>
            <template v-else-if="visibility.title === 'login'">
                <Shield class="size-4"/>
            </template>
            <template v-else-if="visibility.title === 'public'">
                <LockOpen class="size-4"/>
            </template>
            <template v-else>
                <LockOpen class="size-4"/>
            </template>
        </span>
    </span>
</template>