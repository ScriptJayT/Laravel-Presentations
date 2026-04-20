<script setup lang="ts">
import type { Role, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_role_index } from '@/routes';
import { update } from '@/routes/admin_role';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { Container } from '@/components/dashboard/containers';
import { Form, ContentField } from '@/components/global/form';
import SingleEditDescription from '@/components/dashboard/forms/SingleEditDescription.vue';
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
        <Container :title="role.name" id="edit-role--container" class="grid">
            <SingleEditDescription
                :to="update.form(role.id)"
                :descr="role.description"
            />
            <div class="space-y-10 max-w-[40ch]">
                <SubSectionHeading
                    title="Specific Permissions"
                    description="Roles also inherit permissions from lower levels, these aren't shown here"
                />
                <ul>
                    <li v-for="_perm in role.permissions">
                        {{ _perm.name }}
                    </li>
                </ul>
            </div>
        </Container>
    </AppLayout>
</template>

<style>
    [data-id="edit-role--container"] .grid {
        grid-template-columns: 1fr auto;
    }
</style>