<script setup lang="ts">
import { type Presentation } from '@/types';
import { onMounted, onUnmounted, useId } from 'vue';
import { safeQuery, fullscreenController } from '@/lib/utils';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import AppWrapper from '@/components/app/AppWrapper.vue';
import AppContent from '@/components/app/AppContent.vue';
const props = defineProps<{ presentation: Required<Presentation> }>();
const id = `slideshow--${useId()}`;
const abortSignal = new AbortController();
onMounted(() => {
    // add frontslide, if not yet added
    if(props.presentation.slides[0].id !== -1) {
        props.presentation.slides.unshift({
            id: -1,
            order: -1,
            created_at: "",
            updated_at: "",
            title: props.presentation.title,
            content: "",
            renderedContent: `
                <p class="text-center mt-5 mx-auto">
                    <span class="created_on | block">
                        created on: ${props.presentation.created_at}
                    </span>
                    <span class="creator | block">
                        by: ${props.presentation.user.name}
                    </span>
                </p>`,
            presentation_theme: props.presentation.presentation_theme,
        });
    } else {
        console.log("prevented frontslide from duplicating");
    }
    // add functionality
    const slideShow = safeQuery(`#${id}`);
    const fullscreen = fullscreenController(slideShow);
    document.addEventListener("keypress", (_e: KeyboardEvent) => {
        if(!slideShow) return;
        if(_e.key !== "f") return;
        if(_e.altKey || _e.ctrlKey) return;
        fullscreen.toggle();
    }, {signal: abortSignal.signal});
});
onUnmounted(() => {
    console.log("closing");
    abortSignal.abort();
});
</script>

<template>
    <AppWrapper :meta-title="presentation.title">
        <AppContent>
            <slide-show
                :id
                tabindex="0"
                :data-theme="presentation.presentation_theme.title"
                class="
                    relative
                    block h-[80vh]
                    mt-[7.5vh]
                    space-y-10
                    px-8
                    overflow-x-clip overflow-y-scroll
                    "
            >
                <template v-for="(_slide, _index) in presentation.slides">
                    <slide
                        :data-theme="_slide.presentation_theme.title"
                        class="
                            ct-inline-size
                            relative isolate
                            block h-full
                            border rounded-4xl
                            bg-amber-200 dark:bg-amber-800
                            overflow-clip
                            "
                    >
                        <div class="slide-wrapper | grid gap-y-5 max-h-full h-min pt-4 pb-8">
                            <header class="slide-header | pl-10 pr-6">
                                <template v-if="_index === 0">
                                    <h1 class="text-center text-5xl">
                                        {{ _slide.title }}
                                    </h1>
                                </template>
                                <template v-else>
                                    <h2 class="text-3xl underline underline-offset-3">
                                        {{ _slide.title }}
                                    </h2>
                                </template>
                            </header>

                            <div class="
                                slide-content |
                                flow-root
                                pl-18 pr-6
                                text-lg
                                overflow-y-auto overflow-x-clip
                                "
                            >
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
                                    class="render | contents space-y-6"
                                    v-html="_slide.renderedContent"
                                />
                            </div>
                        </div>
                        <PlaceholderPattern transparent />
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
        /* & .slide-header {} */
        & .slide-content {
            scrollbar-width: thin;
        }
    }
    .render {
        font-size: calc(1rem + 1.5cqmin);

        & p,
        & :where(ul, ol),
        & :where(h3, h4, h5, h6) {
            max-width: 50ch;
        }

        & p {
            text-wrap: pretty;
            line-height: 1.5;

            &:has(img) {
                display: contents;
            }
        }
        & :where(h3, h4, h5, h6) {
            text-wrap: balance;
            font-weight: 500;
            font-size: 1.2em;
        }

        & ul {
            list-style-type: square;
            list-style-position: inside;

            &:has(li>[type=checkbox]) {
                list-style: none;
            }
        }
        & ol {
            list-style-type: decimal-leading-zero;
            list-style-position: inside;
        }
        & li {
            & + & {
                margin-top: .25em;
            }
        }
        & dl {
            & dt {
                font-weight: 500;

                &::after {
                    content: ":";
                }

                dd + & {
                    margin-top: 0.25em;
                }
            }
            & dd {
                font-style: italic;
            }
        }

        & blockquote {
            border-inline-start: 5px solid var(--color-muted-foreground);
            padding-inline-start: 1.5ch;
        }

        & hr {
            margin-block: 2em;
            border-width: 2px;
            border-color: var(--color-muted-foreground);
        }

        & p code {
            padding-inline: 0.5ch;
            border-radius: 5px;
            background-color: hsl(from var(--color-background) h s l / 0.5);
        }

        & pre {
            padding: 1rem;
            min-height: 1lh;
            border-radius: 15px;
            background-color: hsl(from var(--color-background) h s l / 0.5);
        }

        & mark {
            padding-inline: 0.5ch;
        }

        & a {
            border-bottom: 2px solid;

            &.external-link::after {
                content: '\2197';
                display: inline-block;
                margin-inline: 0.5ch 0.25ch;
            }
        }
    }
</style>