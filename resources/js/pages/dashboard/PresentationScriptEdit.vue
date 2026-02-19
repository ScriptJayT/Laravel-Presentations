<script setup lang="ts">
import { type PresentationScript, type BreadcrumbItem } from '@/types';

import { admin_presentation_index, admin_script_index } from '@/routes';
import { destroy, update } from '@/routes/admin_script';

import { Form, FormField } from '@/components/global/form'
import { AsideZone, SaveZone, DangerZone } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';

import AppLayout from '@/layouts/AppLayout.vue';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';

const props = defineProps<{
    script: PresentationScript;
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: admin_presentation_index().url,
    },
    {
        title: 'Scripts',
        href: admin_script_index().url,
    },
    {
        title: `Script: #${props.script.id}`,
    }
];
</script>

<template>
    <AppLayout meta-title="Edit Script" :breadcrumbs="breadcrumbs">
        <SideZoneContainer :title="script.title" >
            <template v-slot:sidezone>
                <SaveZone form-id="update-script-form"/>
                <AsideZone title="Info" :hidden-title="true">
                    <span class="block">
                        Last edit: {{ script.updated_at }}
                    </span>
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal
                        id="presentation-script"
                        :route="destroy.form(script.id)"
                    />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
                <Form
                    id="update-script-form"
                    class="
                        space-y-6
                        max-w-[90ch] h-fit
                        mx-auto inert:opacity-50
                        "

                    :send-to="update.form(script.id)"
                    v-slot="{ errors }"
                >
                    <FormField
                        id="script-title" label="Title:"
                        :error="errors.title"
                    >
                        <input
                            id="script-title" name="title" type="text"
                            v-model.lazy="script.title"
                            class="grow outline-none"
                        />
                    </FormField>
                    <FormField :error="errors.content">
                        <textarea
                            aria-label="Content"
                            name="content"
                            class="
                                resize-none
                                outline-none
                                min-h-[10lh]
                                "
                            :value="script.content.trim()"
                        />
                    </FormField>
                </Form>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>