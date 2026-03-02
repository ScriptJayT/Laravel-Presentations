<script setup lang="ts">
import type { Model, User } from '@/types';
import { ExternalLink } from 'lucide-vue-next';
import { RouteDefinition } from '@/wayfinder';
import { admin_users } from "@/routes";
const props = defineProps<{
    model: { user?: User } & Model;
    previewUrl?: RouteDefinition<'get'>;
}>();
</script>

<template>
    <template v-if="previewUrl">
        <a
            :href="previewUrl.url"
            target="_blank"
            class="
                cursor-pointer select-none
                flex justify-between gap-1
                rounded-sm
                outline-sidebar-ring
                outline-offset-8
                "
        >
            <span> Go to preview </span>
            <ExternalLink class="size-4"/>
        </a>
        <hr>
    </template>
    <template v-if="model.user">
        <a
            :href="admin_users(model.user.id).url"
            target="_blank"
            class="
                cursor-pointer select-none
                flex justify-between gap-1
                rounded-sm
                outline-sidebar-ring
                outline-offset-8
                "
        >
            <span> Created by: {{ model.user.name }} </span>
            <span aria-hidden="true"> <ExternalLink class="size-4" /> </span>
        </a>
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