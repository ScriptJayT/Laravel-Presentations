<script setup lang="ts">
import type { PresentationScript } from '@/types';
import Container from '@/components/app/Container.vue';
import AppWrapper from '@/components/app/AppWrapper.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import AppContent from '@/components/app/AppContent.vue';
import AppFooter from '@/components/app/AppFooter.vue';
defineProps<{
    script: Required<PresentationScript>;
}>();
</script>

<template>
    <AppWrapper :meta-title="`Script: ${script.title}`">
        <AppHeader />
        <AppContent class="pt-15 pb-25">
            <Container>
                <h1 class="mb-10 text-center text-5xl">
                    {{ script.title }}
                </h1>
                <div
                    v-html="script.renderedContent"
                    class="script-content mx-auto max-w-3xl space-y-5 text-lg"
                />
            </Container>
        </AppContent>
        <AppFooter />
    </AppWrapper>
</template>

<style>
.script-content {
    & p {
        text-wrap: pretty;
        line-height: 1.7;

        &:has(img) {
            display: contents;
        }
    }
    & :where(h2, h3, h4, h5, h6) {
        text-wrap: balance;
        font-weight: 500;
        font-size: var(--text-xl);
    }
    & h2 {
        font-size: var(--text-3xl);
    }
    & h3 {
        font-size: var(--text-2xl);
    }

    & ul {
        list-style-type: square;
        list-style-position: inside;

        &:has(li > [type='checkbox']) {
            list-style: none;
        }
    }
    & ol {
        list-style-type: decimal-leading-zero;
        list-style-position: inside;
    }
    & li + li {
        margin-top: 0.25em;
    }
    & dl {
        & dt {
            font-weight: 500;

            &::after {
                content: ':';
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

    & *:not(pre) > code {
        padding-inline: 0.5ch;
        border-radius: 5px;
        background-color: hsl(from var(--color-accent) h s l / 0.5);
    }

    & pre {
        padding: 1rem;
        min-height: 1lh;
        border-radius: 15px;
        background-color: hsl(from var(--color-accent) h s l / 0.5);
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
