<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_users } from "@/routes";
import AppLayout from '@/layouts/AppLayout.vue';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import Search from '@/components/global/form/Search.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';

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
                <NewLink title="User"/>
                <template v-for="_user in allUsers">
                    <IndexLink
                        class="search-indexable"
                        :title="_user.name"
                    >
                    <a :href="admin_users(_user.id).url"> Edit </a>
                    </IndexLink>
                </template>
            </IndexGrid>
        </Container>
    </AppLayout>
</template>
