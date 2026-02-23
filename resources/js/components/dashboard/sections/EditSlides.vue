<script setup lang="ts">
import { PresentationSlide, Presentation } from '@/types';
import ActionModal from '../ActionModal.vue';
import NewSlide from '../forms/NewSlide.vue';
import NewLink from '../models/NewLink.vue';
import IndexLink from '../models/IndexLink.vue';
import EditSlide from '../forms/EditSlide.vue';

const props = defineProps<{
    presentation: Presentation;
    slides?: PresentationSlide[];
}>();
</script>

<template>
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <NewLink title="Slide">
            <h2 class="text-lg font-semibold my-5"> New Slide: </h2>
            <NewSlide :parent-id="presentation.id"/>
        </NewLink>
        <template v-for="_slide in slides">
            <IndexLink
                :data-id="_slide.id"
                :title="`${_slide.title}`" :unsemantic-title="true"
            >
                <span> Order magn.: {{ _slide.order }} </span>
                <button
                    class="
                        model-create--button |
                        cursor-pointer
                        absolute inset-0
                        grid place-content-center
                        border-2 rounded-xl hover:border-cyan-700 focus-visible:border-cyan-700
                        outline-offset-8
                        "
                    :title="`Open: ${_slide.title}`"
                    command="show-modal"
                    :commandfor="`modal-for-slide-${_slide.id}`"
                />
            </IndexLink>
            <ActionModal :id="`modal-for-slide-${_slide.id}`" class="w-[80vw]">
                <EditSlide :slide="_slide" :parent-id="presentation.id" class="mt-10" />
            </ActionModal>
        </template>
    </div>
</template>