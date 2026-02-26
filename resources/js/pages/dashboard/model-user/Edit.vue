<script setup lang="ts">
import type { Auth, User, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { admin_user_index } from '@/routes';
import AppLayout from '@/layouts/AppLayout.vue';
import { AsideZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';
import UserAvatar from '@/components/global/model/UserAvatar.vue';

const page = usePage();
const loggedInUser = (page.props.auth as Auth).user;
const props = defineProps<{
    user: User;
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: admin_user_index().url,
    },
    {
        title: `User: #${props.user.id}`,
    }
];
</script>

<template>
    <AppLayout meta-title="User" :breadcrumbs>
        <SideZoneContainer
            :title="user.id == loggedInUser.id
                ? `${user.name} (You)`
                : user.name
                "
        >
            <template v-slot:sidezone>
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo :model="user" />
                </AsideZone>
            </template>
            <template v-slot:mainzone>
                <UserAvatar :avatar="user.avatar" :user-name="user.name" :inline="false"/>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>