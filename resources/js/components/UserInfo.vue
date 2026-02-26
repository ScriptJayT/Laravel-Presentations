<script setup lang="ts">
import type { User } from '@/types';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
const props = withDefaults(
    defineProps<{
        user: User;
        showEmail?: boolean;
    }>(),
    {
        showEmail: false,
    }
);
</script>

<template>
    <UserAvatar :avatar="user.avatar" :user-name="user.name" inline />
    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">
            {{ user.name }}
        </span>
        <span v-if="showEmail" class="truncate text-xs text-muted-foreground">
            {{ user.email }}
        </span>
    </div>
</template>
