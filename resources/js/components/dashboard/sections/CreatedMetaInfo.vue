<script setup lang="ts">
import type { Model, User } from '@/types';
import { ExternalLink } from 'lucide-vue-next';
import { RouteDefinition } from '@/wayfinder';

type HasUserModel = {
    user?: User
} & Model;
const props = defineProps<{
    model: HasUserModel;
    previewUrl?: RouteDefinition<'get'>;
}>();
</script>

<template>
    <template v-if="previewUrl">
        <a
            class="cursor-pointer select-none | flex justify-between gap-1"
            :href="previewUrl.url"
            target="_blank"
        >
            <span> Go to preview </span>
            <ExternalLink class="size-4"/>
        </a>
        <hr>
    </template>
    <template v-if="model.user">
        <span class="block">
            Created by: {{ model.user.name }}
        </span>
        <span class="block">
            on: {{ model.created_at }}
        </span>
    </template>
    <template v-else>
        <span class="block">
            Created on: {{ model.created_at }}
        </span>
    </template>
    <span class="block">
        Last edit: {{ model.updated_at }}
    </span>
</template>