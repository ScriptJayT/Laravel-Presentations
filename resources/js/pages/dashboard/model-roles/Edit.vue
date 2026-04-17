<script setup lang="ts">
import type { Role, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_role_index } from '@/routes';
import { update } from '@/routes/admin_role';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
import { Form, ContentField } from '@/components/global/form';

const props = defineProps<{ role: Role }>();
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
        title: `${props.role.name}`,
    }
];
</script>

<template>
    <AppLayout meta-title="Role" :breadcrumbs="breadcrumbs">
        <Container :title="role.name">
            <Form
                :send-to="update.form(role.id)"
                form-action="edit"
            >
                <ContentField
                    name="description"
                    label="Description"
                    :value="role.description ?? ''"
                />
            </Form>
        </Container>
    </AppLayout>
</template>
