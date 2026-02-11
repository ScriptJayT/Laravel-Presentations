<script setup lang="ts">
import { type Presentation } from '@/types';

import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import AppContent from '@/components/AppContent.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

const props = defineProps<{
    presentation: Required<Presentation>;
}>();

onMounted(()=>{
    props.presentation.slides.unshift({
        id: 0,
        created_at: "",
        updated_at: "",
        title: props.presentation.title,
        content: `  <span class="created_on | block">
                        created on: ${ props.presentation.created_at }
                    </span>
                    <span class="creator | block">
                        by: ${ props.presentation.user.name }
                    </span>`,
        presentation_theme: props.presentation.presentation_theme,
    });
});
</script>

<template>
    <Head :title="presentation.title" />

    <AppContent>
        <slide-show class="relative | h-screen space-y-10 pi-8 | text-2xl | overflow-x-clip overflow-y-scroll">
            <template v-for="(_slide, _index) in presentation.slides">
                <slide
                    :data-theme="_slide.presentation_theme.title + ' ' + presentation.presentation_theme.title"
                    class="relative | block h-full | border rounded-4xl | bg-amber-200 | overflow-clip"
                >
                    <div class="slide-wrapper | grid gap-y-8 | max-h-full h-min p-8">
                        <template v-if="_index === 0">
                            <h1 class="text-center text-5xl"> {{ _slide.title }} </h1>
                        </template>
                        <template v-else>
                            <h2> {{ _slide.title }} </h2>
                        </template>

                        <div
                            class="content-wrapper | space-y-5 pl-6 overflow-y-auto overflow-x-clip"
                            v-html="_slide.content"
                        />
                    </div>
                    <PlaceholderPattern :interactable="false" />
                </slide>
            </template>
        </slide-show>
    </AppContent>
</template>

<style is="scoped">
    slide-show {
        scroll-snap-type: y mandatory;

        & > slide {
            scroll-snap-align: start;
        }
    }
    slide {
        &[data-theme^='base'] {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        & > .slide-wrapper {
            grid-template-rows: auto 1fr;
        }

        & p,
        & :where(h3, h4, h5, h6) {
            max-width: 50ch;
        }
        & p {
            text-wrap: pretty;
        }
        & :where(h3, h4, h5, h6) {
            text-wrap: balance;
        }
    }
</style>