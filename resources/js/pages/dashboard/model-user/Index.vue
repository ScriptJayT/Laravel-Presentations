<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_users } from "@/routes";
import AppLayout from '@/layouts/AppLayout.vue';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import { IndexLink, NewLink } from '@/components/dashboard/models';
import Search from '@/components/global/form/Search.vue';
import NewUser from '@/components/dashboard/forms/NewUser.vue';

const props = defineProps<{
    allUsers: User[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
    },
];
</script>

<template>
    <AppLayout meta-title="Users" :breadcrumbs="breadcrumbs">
        <Container
            title="Users"
            class="space-y-10"
        >
            <Search :updatable-list="allUsers"/>
            <IndexGrid>
                <NewLink title="User">
                    <NewUser class="mt-10" />
                </NewLink>
                <template v-for="_user in allUsers">
                    <IndexLink
                        class="search-indexable"
                        :title="_user.name"
                        :link="admin_users(_user.id)"
                    />
                </template>
            </IndexGrid>
        </Container>
    </AppLayout>
</template>
