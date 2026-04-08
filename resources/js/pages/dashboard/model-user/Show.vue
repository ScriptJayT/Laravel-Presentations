<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_user_index, admin_presentations } from '@/routes';
import { edit as admin_edit } from '@/routes/admin_user';
import { edit } from '@/routes/profile';
import { plural, getUser } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { TextField } from '@/components/global/form';
import { ActionLink } from '@/components/dashboard/buttons';
import UserAvatar from '@/components/global/model/UserAvatar.vue';
import { AsideZone } from '@/components/dashboard/sections';
import { SideZoneContainer, Container } from '@/components/dashboard/containers';
import PropList from '@/components/dashboard/models/PropList.vue';

const props = defineProps<{
    user: User,
    canEdit: boolean,
}>();
const isLoggedInUser = props.user.id === getUser(false)?.id;
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
                <AsideZone title="Info" :hidden-title="true">
                    <span class="block">
                        Member since: {{ user.created_at }}
                    </span>
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
                <AsideZone class="empty:none">
                    <ActionLink
                        v-if="isLoggedInUser"
                        :url="edit().url"
                        text="Edit your profile"
                    />
                    <ActionLink
                        v-if="canEdit"
                        :url="admin_edit(user.id).url"
                        text="Edit this user"
                    />
                </AsideZone>
            </template>
            <template v-slot:mainzone>
                <UserAvatar
                    :avatar="user.avatar"
                    :user-name="user.name"
                    :inline="false"
                />
                <PropList
                    :list="{
                        'Name': user.name,
                        'Email': user.email,
                        'Email validated': user.email_verified_at ? 'Yes' : 'No',
                    }"
                    class="space-y-10"
                />
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