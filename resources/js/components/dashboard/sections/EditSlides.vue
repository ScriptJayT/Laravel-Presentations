<script setup lang="ts">
import { PresentationSlide } from '@/types';
import ActionModal from '../ActionModal.vue';
import NewSlide from '../form/NewSlide.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Plus } from 'lucide-vue-next';
import NewLink from '../models/NewLink.vue';
import IndexLink from '../models/IndexLink.vue';

const props = defineProps<{
    slides?: PresentationSlide[];
}>();
</script>

<template>
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <NewLink title="Slide">
            <h2 class="text-lg font-semibold my-5"> New Slide: </h2>
            <NewSlide/>
        </NewLink>

        <template v-for="_slide in slides">
            <IndexLink :title="`${_slide.title}`" :unsemantic-title="true">
                <button
                    class="
                        model-create--button |
                        cursor-pointer
                        absolute inset-0
                        grid place-content-center
                        border-2 rounded-xl hover:border-cyan-700 focus-visible:border-cyan-700
                        outline-offset-8
                        "
                    :title="`Create a New Slide`"
                    command="show-modal"
                    :commandfor="`modal-for-slide-${_slide.id}`"
                />
            </IndexLink>
            <ActionModal :id="`modal-for-slide-${_slide.id}`" class="min-w-[30vw]">
                <slot/>
            </ActionModal>
        </template>
    </div>
</template>