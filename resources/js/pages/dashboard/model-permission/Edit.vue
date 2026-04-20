<script setup lang="ts">
import type { Permission, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_role_index } from '@/routes';
import { update } from '@/routes/admin_permission';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
import SingleEditDescription from '@/components/dashboard/forms/SingleEditDescription.vue';
const props = defineProps<{ permission: Permission }>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: admin_user_index().url,
    },
    {
        title: 'Roles',
        href: admin_role_index().url,
    },
    {
        title: 'Permissions',
        href: admin_role_index().url,
    },
    {
        title: `${props.permission.name}`,
    }
];
</script>

<template>
    <AppLayout meta-title="Permission" :breadcrumbs>
        <Container :title="permission.name">
            <SingleEditDescription
                :to="update.form(permission.id)"
                :descr="permission.description"
            />
        </Container>
    </AppLayout>
</template>
