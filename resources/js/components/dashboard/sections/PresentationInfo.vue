<script setup lang="ts">
import { type Presentation } from '@/types';
import { presentations } from '@/routes';
import { ExternalLink } from 'lucide-vue-next';

const props = defineProps<{
    presentation: Presentation;
}>();
</script>

<template>
    <a
        class="cursor-pointer select-none | flex justify-between gap-1"
        :href="presentations(presentation.slug).url"
        target="_blank"
    >
        <span> Go to preview </span>
        <ExternalLink class="size-4"/>
    </a>
    <hr>
    <span class="block">
        Created by: {{ presentation.user.name }}
    </span>
    <span class="block">
        on: {{ presentation.created_at }}
    </span>
    <span class="block">
        Last edit: {{ presentation.updated_at }}
    </span>
</template>