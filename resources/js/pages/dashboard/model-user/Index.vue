<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { edit, show } from "@/routes/admin_user";
import AppLayout from '@/layouts/AppLayout.vue';
import { Container, IndexGrid } from '@/components/dashboard/containers';
import { IndexLink, NewLink } from '@/components/dashboard/models';
import Search from '@/components/global/form/Search.vue';
import NewUser from '@/components/dashboard/forms/NewUser.vue';

const props = defineProps<{
    allUsers: User[],
    canAdd: boolean,
    canEdit: boolean,
}>();
const breadcrumbs: BreadcrumbItem[] = [ { title: 'Users' } ];
</script>

<template>
    <AppLayout
        meta-title="Users"
        :breadcrumbs
    >
        <Container
            title="Users"
            class="space-y-10"
        >
            <Search :updatable-list="allUsers" />
            <IndexGrid>
                <NewLink v-if="canAdd" title="User">
                    <NewUser class="mt-10" />
                </NewLink>
                <template v-for="_user in allUsers">
                    <IndexLink
                        class="search-indexable"
                        :title="_user.name"
                        :link="canEdit ? edit(_user.id) : show(_user.id)"
                    />
                </template>
            </IndexGrid>
        </Container>
    </AppLayout>
</template>
