<script setup lang="ts" >
import { Save } from 'lucide-vue-next';
import { onMounted, onUnmounted, useId } from 'vue';
import { cn, safeQuery } from '@/lib/utils';
import AsideZone from './AsideZone.vue';
import { metaButtonClasses, metaButtonSpanClasses } from '@/components/dashboard/sections';

defineProps<{ formId: string }>();
const btnId = useId();
const signal = new AbortController();
onMounted(() => {
    const btn = safeQuery(`#${btnId}`);
    document.addEventListener('keydown', (_e: KeyboardEvent) => {
        if(!btn) return;
        if(_e.key === "s" && _e.ctrlKey) {
            _e.preventDefault();
            _e.stopImmediatePropagation();
            _e.stopPropagation();

            btn.click();
        }
    }, {signal: signal.signal});
});
onUnmounted(() => {
    console.log("[DEV] abort ctrl+s function");
    signal.abort();
});
</script>

<template>
    <AsideZone>
        <button
            :id="btnId"
            :form="formId"
            :class="cn(metaButtonClasses(), 'w-full')"
        >
            <span :class="cn(metaButtonSpanClasses())">
                Save <kbd class="text-sm text-muted-foreground uppercase">ctrl+s</kbd>
            </span>
            <Save class="size-4" />
        </button>
    </AsideZone>
</template>

<style scoped>
    kbd {
        &::before {
            content: "[";
        }
        &::after {
            content: "]";
        }
    }
</style>