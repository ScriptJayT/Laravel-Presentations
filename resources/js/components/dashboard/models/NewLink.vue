<script setup lang="ts">
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import { Plus } from 'lucide-vue-next';

const props = defineProps<{
    title: string;
}>();
</script>

<template>
    <IndexLink :title="`New ${title}`">
        <button
            class="
                model-create--button |
                cursor-pointer
                absolute inset-0
                grid place-content-center
                border-2 rounded-xl hover:border-green-700 focus-visible:border-green-700
                outline-offset-8
                "
            :title="`Create a New ${title}`"
        >
            <Plus class="size-[15cqw] opacity-15"/>
        </button>
    </IndexLink>
</template>