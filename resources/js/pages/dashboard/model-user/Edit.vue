<script setup lang="ts">
import type { Auth, User, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { admin_user_index } from '@/routes';
import { update, destroy } from '@/routes/admin_user';
import { edit } from '@/routes/profile';

import AppLayout from '@/layouts/AppLayout.vue';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
import { Form, TextField } from '@/components/global/form';
import { DestroyFormModal } from '@/components/dashboard/models';
import FileField from '@/components/global/form/fields/FileField.vue';

const page = usePage();
const loggedInUser = (page.props.auth as Auth).user;
const props = defineProps<{
    user: User;
}>();
const isLoggedInUser = props.user.id === loggedInUser.id;
const canEdit = false;
const canDelete = false;
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
            :title="isLoggedInUser
                ? `${user.name} (You)`
                : user.name
                "
        >
            <template v-slot:sidezone>
                <SaveZone v-if="canEdit" form-id="update-form-edit" />
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo :model="user" />
                </AsideZone>
                <DangerZone v-if="canDelete">
                    <DestroyFormModal
                        :id="user.id"
                        :route="destroy.form(user.id)"
                    />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
                <Form
                    id="update-form-edit"
                    :send-to="update.form(user.id)"
                    :show-button="false"
                    class="grid grid-cols-2 gap-10"
                    :disabled="!canEdit"
                >
                    <fieldset class="space-y-5">
                        <legend class="sr-only"> Credentials </legend>

                        <template v-if="isLoggedInUser">
                            <a
                                :href="edit().url"
                                class="
                                    block w-fit
                                    px-3 py-2
                                    border rounded-md
                                    outline-offset-8
                                    transition-colors
                                    hover:bg-accent dark:hover:bg-accent/50
                                    "
                            >
                                Edit your profile
                            </a>
                        </template>

                        <TextField
                            label="Name:" name="name"
                            :value="user.name" disabled
                        />
                        <TextField
                            label="Email:" name="email"
                            :value="user.email" :disabled="!canEdit"
                        />
                    </fieldset>

                    <fieldset class="space-y-5">
                        <legend class="sr-only"> Visual Representation </legend>
                        <UserAvatar
                            :avatar="user.avatar"
                            :user-name="user.name"
                            :inline="false"
                            class="ml-auto"
                        />
                        <template v-if="canEdit">
                            <FileField
                                label="Avatar:" name="avatar"
                                :disabled="canEdit"
                            />
                        </template>
                    </fieldset>
                </Form>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>