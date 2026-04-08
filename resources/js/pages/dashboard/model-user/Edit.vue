<script setup lang="ts">
import type { Auth, User, BreadcrumbItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { admin_user_index, admin_presentations, send_password } from '@/routes';
import { update, destroy } from '@/routes/admin_user';
import { edit } from '@/routes/profile';
import { plural } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { Form, TextField, FileField } from '@/components/global/form';
import { ActionLink } from '@/components/dashboard/buttons';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer, Container } from '@/components/dashboard/containers';
import { DestroyFormModal } from '@/components/dashboard/models';

const page = usePage();
const loggedInUser = (page.props.auth as Auth).user;
const props = defineProps<{ user: User }>();
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

console.log(props.user);

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
                        <ActionLink
                            v-if="isLoggedInUser"
                            :url="edit().url"
                            text="Edit your profile"
                        />
                        <TextField
                            label="Name:" name="name"
                            :value="user.name" :disabled="!canEdit"
                        />
                        <TextField
                            label="Email:" name="email"
                            :value="user.email" :disabled="!canEdit"
                        />
                        <TextField
                            label="Email validated:" name=""
                            :value="user.email_verified_at ? 'Yes' : 'No'" disabled
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
                    :send-to="send_password.form()"
                    button-text="Send password reset link"
                    class="w-fit"
                    v-slot="{ errors, wasSuccessful }"
                >
                    <div v-if="wasSuccessful"> Reset-link send </div>
                    <div v-if="errors.email"> The users email is invalid? </div>
                    <div v-if="errors.status"> Something went wrong </div>
                    <input type="hidden" name="email" :value="user.email">
                </Form>
            </template>
        </SideZoneContainer>
        <Container title="Projects" class="grid grid-cols-2 pb-20">
            <div class="space-y-3">
                <SubSectionHeading
                    title="Presentations"
                    :description="`${user.name} has ${plural(user.presentations, 'Presentation')}`"
                />
                <ul class="space-y-1">
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
            <div class="space-y-3">
                <SubSectionHeading
                    title="Scripts"
                    :description="`${user.name} has ${plural(user.presentation_scripts, 'Script')}`"
                />
                <ul class="space-y-1">
                    <template v-for="_script in user.presentation_scripts">
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