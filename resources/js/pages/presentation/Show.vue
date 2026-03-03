<script setup lang="ts">
import { type Presentation } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppWrapper from '@/components/app/AppWrapper.vue';
import AppContent from '@/components/app/AppContent.vue';
const props = defineProps<{ presentation: Required<Presentation> }>();
onMounted(()=>{
    props.presentation.slides.unshift({
        id: 0,
        order: 99999999,
        created_at: "",
        updated_at: "",
        title: props.presentation.title,
        content: "",
        renderedContent: `
            <span class="created_on | block">
                created on: ${props.presentation.created_at}
            </span>
            <span class="creator | block">
                by: ${props.presentation.user.name}
            </span>`,
        presentation_theme: props.presentation.presentation_theme,
    });
});
</script>

<template>
    <Head :title="presentation.title" />

    <AppWrapper>
        <AppContent>
            <slide-show class="relative | block h-[80vh] mt-[7.5vh] space-y-10 px-8 | text-2xl | overflow-x-clip overflow-y-scroll">
                <template v-for="(_slide, _index) in presentation.slides">
                    <slide
                        :data-theme="_slide.presentation_theme.title + ' ' + presentation.presentation_theme.title"
                        class="
                            relative isolate | block h-full
                            border rounded-4xl
                            bg-amber-200 dark:bg-amber-800
                             overflow-clip
                            "
                    >
                        <div class="slide-wrapper | grid gap-y-8 | max-h-full h-min p-8">
                            <template v-if="_index === 0">
                                <h1 class="text-center text-5xl"> {{ _slide.title }} </h1>
                            </template>
                            <template v-else>
                                <h2> {{ _slide.title }} </h2>
                            </template>

                            <div class="flow-root pl-6 | overflow-y-auto overflow-x-clip">
                                <template v-if="false">
                                    <figure class="
                                        float-end
                                        block max-w-md w-fit
                                        bg-amber-50 dark:bg-amber-950
                                        "
                                    >
                                        <img class="block w-full" src="https://picsum.photos/200/300" alt="">
                                        <figcaption class="block px-2 py-1 | text-sm text-left italic" >
                                            Image placeholder for now
                                        </figcaption>
                                    </figure>
                                </template>
                                <div
                                    class="contents space-y-5"
                                    v-html="_slide.renderedContent"
                                />
                            </div>
                        </div>
                        <PlaceholderPattern :interactable="false" />
                    </slide>
                </template>
            </slide-show>
        </AppContent>
    </AppWrapper>
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
            font-weight: 500;
            font-size: 1.2em;
        }

        & p:has(img) {
            display: contents;
        }

        & ul {
            list-style-type: square;
            list-style-position: inside;

        }
        & ol {
            list-style-type: decimal-leading-zero;
            list-style-position: inside;
        }
        & li {
            & + & {

                margin-top: 0.75ch;
            }
        }
    }
</style>