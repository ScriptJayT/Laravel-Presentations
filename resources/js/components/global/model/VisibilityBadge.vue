<script setup lang="ts">
import type { PresentationVisibility } from '@/types';
import { getAppEnums } from '@/lib/utils';
import { Shield, Lock, LockOpen } from "lucide-vue-next";
const visibilityTitles = getAppEnums().visibility;
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
            bg-background
            "
    >
        <span class="italic text-md"> {{ visibility.name }} </span>
        <span role="presentation">
            <template v-if="visibility.title === visibilityTitles.PRIVATE">
                <Lock class="size-4"/>
            </template>
            <template v-else-if="visibility.title === visibilityTitles.PROTECTED">
                <Shield class="size-4"/>
            </template>
            <template v-else-if="visibility.title === visibilityTitles.PUBLIC">
                <LockOpen class="size-4"/>
            </template>
            <template v-else>
                <LockOpen class="size-4"/>
            </template>
        </span>
    </span>
</template>