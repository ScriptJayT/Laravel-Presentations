<script setup lang="ts">
import type { PresentationVisibility } from '@/types';
import { getAppEnums } from '@/lib/utils';
import { Shield, Lock, LockOpen } from '@lucide/vue';
const visibilityTitles = getAppEnums().visibility;
defineProps<{
    visibility: PresentationVisibility;
    class?: string;
}>();
const iconClass = "size-4";
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
            <Lock
                v-if="visibility.title === visibilityTitles.PRIVATE"
                :class="iconClass"
            />
            <Shield
                v-else-if="visibility.title === visibilityTitles.PROTECTED"
                :class="iconClass"
            />
            <LockOpen
                v-else-if="visibility.title === visibilityTitles.PUBLIC"
                :class="iconClass"
            />
            <LockOpen
                v-else
                :class="iconClass"
            />
        </span>
    </span>
</template>