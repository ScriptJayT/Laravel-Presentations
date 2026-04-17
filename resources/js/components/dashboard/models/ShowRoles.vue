<script setup lang="ts">
import type { Role } from '@/types';
import { admin_role_index } from '@/routes';
defineProps<{ roles: Role[] }>();
</script>
<template>
    <div data-component="dashboard/models/ShowRoles">
        <span
            v-if="roles.length < 1"
            class="text-sm text-muted-foreground"
        >
            None granted
        </span>
        <ul v-else class="space-y-3">
            <li v-for="_role in roles">
                <span class="mb-1 block capitalize">
                    {{ _role.name }}:
                </span>
                <ul class="list-disc pl-5">
                    <li v-for="_perm in _role.permissions">
                        <span>
                            {{ _perm.name }}
                        </span>
                    </li>
                </ul>
            </li>
        </ul>
        <a :href="admin_role_index().url" class="block mt-5">
            Check out what roles and permissions mean
        </a>
    </div>
</template>