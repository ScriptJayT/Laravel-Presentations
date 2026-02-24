<script setup lang="ts" >
import { Save } from 'lucide-vue-next';
import AsideZone from './AsideZone.vue';

defineProps<{
    formId: string;
}>();
</script>

<template>
    <AsideZone>
        <button
            :form="formId"
            class="
                cursor-pointer select-none
                flex items-center justify-between gap-1
                w-full
                rounded-sm
                outline-sidebar-ring
                outline-offset-8
                "
        >
            <span> Save </span>
            <Save class="size-4"/>
        </button>
    </AsideZone>
</template>