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
                <SaveZone form-id="update-script-form"/>
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo :model="user" />
                </AsideZone>
            </template>
            <template v-slot:mainzone>
                <UserAvatar :avatar="user.avatar" :user-name="user.name" :inline="false"/>
                <Form
                    id="update-script-form"
                    form-action="edit"
                    class="
                        space-y-6
                        max-w-[90ch] h-fit
                        mx-auto inert:opacity-50
                        "
                    :show-button="false"
                    :send-to="update.form(user.id)"
                    v-slot="{ errors }"
                />
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>