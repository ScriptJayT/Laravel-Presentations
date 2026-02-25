<script setup lang="ts">
import type { User, BreadcrumbItem } from '@/types';
import { admin_presentation_index, admin_presentations,  } from '@/routes';
import { destroy, update } from '@/routes/admin_script';

import { Form } from '@/components/global/form'
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';

import AppLayout from '@/layouts/AppLayout.vue';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';

const props = defineProps<{
    user: User;
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: admin_presentation_index().url,
    },
    {
        title: `User: `,
    }
];
</script>

<template>
    <AppLayout meta-title="Edit Script" :breadcrumbs="breadcrumbs">
        <SideZoneContainer :title="user.name" >
            <template v-slot:sidezone>
                <SaveZone form-id="update-script-form"/>
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo :model="user" />
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal
                        id="presentation-script"
                        :route="destroy.form(user.id)"
                    />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
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
                >



                </Form>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>