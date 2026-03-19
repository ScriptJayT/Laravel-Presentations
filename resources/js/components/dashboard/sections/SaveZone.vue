<script setup lang="ts" >
import { Save } from 'lucide-vue-next';
import AsideZone from './AsideZone.vue';
import { metaButtonClasses, metaButtonSpanClasses } from '@/components/dashboard/sections';
import { cn } from '@/lib/utils';

defineProps<{
    formId: string;
}>();
</script>

<template>
    <AsideZone>
        <button
            :form="formId"
            :class="cn(metaButtonClasses(), 'w-full')"
        >
            <span :class="cn(metaButtonSpanClasses())"> Save </span>
            <Save class="size-4"/>
        </button>
    </AsideZone>
</template>