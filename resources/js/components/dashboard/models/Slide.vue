<script setup lang="ts">
import type { PresentationSlide, Presentation } from '@/types';
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import ActionModal from '@/components/dashboard/ActionModal.vue';
import EditSlide from '@/components/dashboard/forms/EditSlide.vue';
defineProps<{
    presentation: Presentation;
    slide: PresentationSlide;
}>();
</script>

<template>
    <div data-component="dashboard/sections/Slide">
        <IndexLink
            :data-id="slide.id"
            :title="`${slide.title} #${slide.id}`"
            :unsemantic-title="false"
        >
            <span> Order magn.: {{ slide.order }} </span>
            <button
                class="
                    model-create--button |
                    cursor-pointer
                    absolute inset-0
                    grid place-content-center
                    border-2 rounded-xl hover:border-cyan-700 focus-visible:border-cyan-700
                    outline-offset-8
                    "
                :title="`Open: ${slide.title}`"
                command="show-modal"
                :commandfor="`modal-for-slide-${slide.id}`"
            />
        </IndexLink>
        <ActionModal :id="`modal-for-slide-${slide.id}`" class="w-[80vw]">
            <EditSlide
                :slide
                :parent-id="presentation.id"
                class="mt-10"
            />
        </ActionModal>
    </div>
</template>