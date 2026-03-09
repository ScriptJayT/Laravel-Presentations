<script setup lang="ts">
import type {
    Presentation, PresentationVisibility, PresentationScript,
    BreadcrumbItem,
} from '@/types';
import { admin_presentation_index, presentations } from '@/routes';
import { destroy } from '@/routes/admin_presentation';

import EditPresentation from '@/components/dashboard/forms/EditPresentation.vue';
import NewSlide from '@/components/dashboard/forms/NewSlide.vue';
import NewLink from '@/components/dashboard/models/NewLink.vue';
import Slide from '@/components/dashboard/models/Slide.vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { SubSectionHeading } from '@/components/global/text';
import { SideZoneContainer } from '@/components/dashboard/containers';
import { AsideZone, SaveZone, DangerZone, CreatedMetaInfo } from '@/components/dashboard/sections';
import DestroyFormModal from '@/components/dashboard/models/DestroyFormModal.vue';

const props = defineProps<{
    presentation: Presentation;
    rules: PresentationVisibility[];
    scripts: PresentationScript[];
}>();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Presentations',
        href: admin_presentation_index().url,
    },
    {
        title: `Presentation: #${props.presentation.id}`,
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" meta-title="Edit Presentation">
        <SideZoneContainer
            :title="presentation.title"
            main-class="space-y-20"
        >
            <template v-slot:sidezone>
                <SaveZone form-id="update-presentation-form" />
                <AsideZone title="Info" :hidden-title="true">
                    <CreatedMetaInfo
                        :model="presentation"
                        :preview-url="presentations(presentation.slug)"
                    />
                </AsideZone>
                <DangerZone>
                    <DestroyFormModal id="presentation" :route="destroy.form(presentation.id)" />
                </DangerZone>
            </template>
            <template v-slot:mainzone>
                <h3 class="sr-only"> Presentation </h3>
                <EditPresentation
                    :presentation
                    :all-scripts="scripts"
                    :all-visibility-rules="rules"
                />
                <div class="space-y-5">
                    <h2 class="text-lg font-semibold"> Slides </h2>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <NewLink title="Slide">
                            <NewSlide :parent-id="presentation.id"/>
                        </NewLink>
                        <template v-for="_slide in presentation.slides">
                            <Slide :slide="_slide" :presentation/>
                        </template>
                    </div>
                </div>
            </template>
        </SideZoneContainer>
    </AppLayout>
</template>
