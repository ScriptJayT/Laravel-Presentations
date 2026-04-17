<script setup lang="ts">
import type { Role, Permission, BreadcrumbItem } from '@/types';
import { admin_user_index } from '@/routes';
import { edit as editRole } from '@/routes/admin_role';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';

const props = defineProps<{
    allRoles: Role[];
    allPermissions: Permission[];
    canEdit: boolean;
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: admin_user_index().url,
    },
    {
        title: 'Roles & Permissions',
    },
];
</script>

<template>
    <AppLayout meta-title="Roles & Permissions" :breadcrumbs="breadcrumbs">
        <div class="grid grid-cols-2">
            <Container title="Roles">
                <dl>
                    <template v-for="_role in allRoles">
                        <dt class="capitalize">{{ _role.name }}</dt>
                        <dd class="pl-2">
                            {{ _role.description ?? '[no description]' }}
                        </dd>
                        <a v-if="canEdit" :href="editRole(_role.id).url"> Edit </a>
                    </template>
                </dl>
            </Container>
            <Container title="Permissions">
                <dl>
                    <template v-for="_perm in allPermissions">
                        <dt class="capitalize">{{ _perm.name }}</dt>
                        <dd class="pl-2">
                            {{ _perm.description ?? '[no description]' }}
                        </dd>
                    </template>
                </dl>
            </Container>
        </div>
    </AppLayout>
</template>

<style scoped>
dt {
    &:not(:first-child) {
        margin-top: 1lh;
    }

    &::after {
        content: ':';
    }
}
</style>
