<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_user_index } from '@/routes';
import { update } from '@/routes/admin_user';
import AppLayout from '@/layouts/AppLayout.vue';
import { Form } from '@/components/global/form'
import { AsideZone, SaveZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';
import UserAvatar from '@/components/global/model/UserAvatar.vue';

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
    <AppLayout meta-title="Edit Script" :breadcrumbs>
        <SideZoneContainer :title="user.name" >
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