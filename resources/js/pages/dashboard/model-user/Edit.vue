<script setup lang="ts">
import type { Auth, User, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { admin_user_index } from '@/routes';
import { update } from '@/routes/admin_user';
import AppLayout from '@/layouts/AppLayout.vue';
import { AsideZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
import { Form, TextField } from '@/components/global/form';
import FormField from '@/components/global/form/helpers/FormField.vue';

const page = usePage();
const loggedInUser = (page.props.auth as Auth).user;
const canEdit = false;
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
                <Form
                    :send-to="update.form(user.id)"
                    :show-button="false"
                    class="grid grid-cols-2 gap-10"
                >
                    <fieldset class="space-y-5">
                        <legend class="sr-only"> Credentials </legend>
                        <TextField
                            label="Name:" name="name"
                            :value="user.name" :disabled="canEdit"
                        />
                        <TextField
                            label="Email:" name="email"
                            :value="user.email" :disabled="canEdit"
                        />
                    </fieldset>
                    <fieldset>
                        <legend class="sr-only"> Visual Representation </legend>
                        <UserAvatar
                            :avatar="user.avatar"
                            :user-name="user.name"
                            :inline="false"
                            class="ml-auto"
                        />
                    </fieldset>
                </Form>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>