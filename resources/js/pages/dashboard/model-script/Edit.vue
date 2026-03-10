<script setup lang="ts">
import type { PresentationScript, PresentationVisibility, BreadcrumbItem } from '@/types';
import { admin_presentation_index, admin_presentations, admin_script_index, scripts } from '@/routes';
import { destroy } from '@/routes/admin_script';
import { ExternalLink } from "lucide-vue-next";
import { plural } from '@/lib/utils';

import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import { SideZoneContainer } from '@/components/dashboard/containers';
import AppLayout from '@/layouts/AppLayout.vue';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';
import EditScript from '@/components/dashboard/forms/EditScript.vue';

const props = defineProps<{
    script: PresentationScript;
    rules: PresentationVisibility[];
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
                    <CreatedMetaInfo :model="script" :preview-url="scripts(script.id)" />
                    <hr>

                    <template v-if="!script.presentations || (script.presentations.length <= 0)">
                        <p> Not used anywhere yet </p>
                    </template>
                    <template v-else>
                        {{ plural(script.presentations, "use") }}:
                        <ul class="list-disc pl-5 mt-2 text-sm space-y-2">
                            <template v-for="_presentation in script.presentations">
                                <li>
                                    <a
                                        :href="admin_presentations(_presentation.id).url"
                                        target="_blank"
                                        :title="`Open presentation: ${_presentation.title}`"
                                        class="
                                            cursor-pointer select-none
                                            flex gap-3 justify-between items-center
                                            rounded-sm
                                            outline-sidebar-ring outline-offset-8
                                            "
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
                <EditScript
                    :script
                    :all-visibility-rules="rules"
                />
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>