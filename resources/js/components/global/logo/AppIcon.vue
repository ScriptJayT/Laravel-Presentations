<script setup lang="ts">
import { Flame } from 'lucide-vue-next';
import type { HTMLAttributes } from 'vue';
defineOptions({ inheritAttrs: false });
defineProps<{ className?: HTMLAttributes['class'] }>();
</script>

<template>
    <Flame
        :class="className"
        v-bind="$attrs"
    />
</template>
