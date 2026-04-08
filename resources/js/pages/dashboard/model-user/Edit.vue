<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_presentations } from '@/routes';
import { update, destroy, show } from '@/routes/admin_user';
import { plural, getUser } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { Form, TextField, FileField } from '@/components/global/form';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer, Container } from '@/components/dashboard/containers';
import { DestroyFormModal } from '@/components/dashboard/models';

const props = defineProps<{
    user: User,
    canDelete: boolean,
}>();
const isLoggedInUser = props.user.id === getUser(false)?.id;
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: admin_user_index().url,
    },
    {
        title: `User: #${props.user.id}`,
        href: show(props.user.id).url,
    },
    {
        title: 'Edit',
    }
];
</script>

<template>
    <AppLayout
        meta-title="Edit User"
        :breadcrumbs
    >
        <h1 class="sr-only"> Edit User Profile </h1>
        <SideZoneContainer
            :title="isLoggedInUser
                ? `${user.name} (You)`
                : user.name
                "
            main-class="space-y-15"
        >
            <template v-slot:sidezone>
                <SaveZone form-id="update-form-edit" />
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo :model="user" />
                </AsideZone>
                <AsideZone title="Permissions" :hidden-title="false">
                    <span
                        v-if="user.roles.length < 1"
                        class="text-sm text-muted-foreground"
                    >
                        None granted
                    </span>
                    <ul
                        v-else
                        class="space-y-3"
                    >
                        <li v-for="_role in user.roles">
                            <span class="block mb-1 capitalize">
                                {{_role.name}}:
                            </span>
                            <ul class="list-disc pl-5">
                                <li v-for="_perm in _role.permissions">
                                    <span>
                                        {{ _perm.name }}
                                    </span>
                                </li>
                            </ul>
                        </li>
                    </ul>
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
                >
                    <fieldset class="space-y-5">
                        <legend class="sr-only"> Credentials </legend>
                        <TextField
                            label="Name:" name="name"
                            :value="user.name"
                        />
                        <TextField
                            label="Email:" name="email"
                            :value="user.email"
                        />
                        <TextField
                            label="Email validated:" name="--"
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
                        <FileField
                            label="Avatar:"
                            name="avatar"
                        />
                    </fieldset>
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