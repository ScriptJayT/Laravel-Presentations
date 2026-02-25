<script setup lang="ts">
import type { PresentationScript, BreadcrumbItem } from '@/types';
import { admin_presentation_index, admin_presentations, admin_script_index } from '@/routes';
import { destroy, update } from '@/routes/admin_script';
import { ExternalLink } from "lucide-vue-next";

import { Form, FormField, ContentField } from '@/components/global/form'
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
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
                    <CreatedMetaInfo :model="script" />
                    <hr>

                    <template v-if="!script.presentations || script.presentations.length < 0">
                        <p>Not used anywhere yet</p>
                    </template>
                    <template v-else>
                        {{ script.presentations.length }} use:
                        <ul class="list-disc pl-5 text-sm space-y-2">
                            <template v-for="_presentation in script.presentations">
                                <li>
                                    <a
                                        :href="admin_presentations(_presentation.id).url"
                                        target="_blank"
                                        :title="`Open: ${_presentation.title}`"
                                        class="flex gap-3 justify-between items-center"
                                    >
                                        <span class="flex gap-1">
                                            <span class="text-muted-foreground">
                                                #{{ _presentation.id }}
                                            </span>
                                            <span class="block max-w-[20ch] italic text-ellipsis text-nowrap overflow-clip">
                                                {{ _presentation.title }}
                                            </span>
                                        </span>
                                        <span aria-hidden="true">
                                            <ExternalLink class="size-3" />
                                        </span>
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </template>
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
                    form-action="edit"
                    class="
                        space-y-6
                        max-w-[90ch] h-fit
                        mx-auto inert:opacity-50
                        "
                    :show-button="false"
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

                    <ContentField
                        name="content"
                        :error="errors.content"
                        :value="script.content.trim()"
                    />
                </Form>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>