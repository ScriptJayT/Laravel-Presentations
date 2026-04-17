<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_presentations } from '@/routes';
import { destroy, show } from '@/routes/admin_user';
import { plural, getUser } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer, Container } from '@/components/dashboard/containers';
import { DestroyFormModal } from '@/components/dashboard/models';
import EditUser from '@/components/dashboard/forms/EditUser.vue';
import ShowRoles from '@/components/dashboard/models/ShowRoles.vue';

const props = defineProps<{
    user: User,
    canDelete: boolean,
}>();
const isLoggedInUser = props.user.id === (getUser(false) as User)?.id;
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
                    <ShowRoles :roles="user.roles"/>
                </AsideZone>
                <DangerZone v-if="canDelete">
                    <DestroyFormModal
                        :id="user.id"
                        :route="destroy.form(user.id)"
                    />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
                <EditUser :user />
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