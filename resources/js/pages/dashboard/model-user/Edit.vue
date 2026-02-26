<script setup lang="ts">
import type { Auth, User, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { admin_user_index, admin_presentations } from '@/routes';
import { update, destroy } from '@/routes/admin_user';
import { edit } from '@/routes/profile';
import { email } from '@/routes/password';

import AppLayout from '@/layouts/AppLayout.vue';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer, Container } from '@/components/dashboard/containers';
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
        <h1 class="sr-only"> User Profile </h1>
        <SideZoneContainer
            :title="isLoggedInUser
                ? `${user.name} (You)`
                : user.name
                "
            main-class="space-y-15"
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

                <Form
                    v-if="!isLoggedInUser"
                    :send-to="email.form()"
                    button-text="Send password reset link"
                    class="w-fit"
                    v-slot="{ errors }"
                >
                    {{ errors.email }}
                    <input type="hidden" name="email" :value="user.email">
                </Form>
            </template>
        </SideZoneContainer>
        <Container title="Projects" class="grid grid-cols-2">
            <div>
                <h3> Presentations </h3>
                <ul>
                    <template v-for="_presentation in user.presentations">
                        <li>
                            <a :href="admin_presentations(_presentation.id).url" >
                                #{{ _presentation.id }}
                                {{ _presentation.title }}
                            </a>
                        </li>
                    </template>
                </ul>
            </div>

            <div>
                <h3> Scripts </h3>
                <ul>
                    <template v-for="_script in user.scripts">
                        <li>
                            <a :href="admin_presentations(_script.id).url" >
                                #{{ _script.id }}
                                {{ _script.title }}
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
        </Container>
    </AppLayout>
</template>