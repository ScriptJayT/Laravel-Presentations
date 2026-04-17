<script setup lang="ts">
import { type Role, type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';

const props = defineProps<{ allRoles: Role[] }>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
    },
    {
        title: 'Roles',
    },
];
</script>

<template>
    <AppLayout meta-title="Roles & Permissions" :breadcrumbs="breadcrumbs">
        <Container
            title="Roles & Permissions"
        />
    </AppLayout>
</template>