<script setup lang="ts">
import type { Presentation } from '@/types';
import { presentations, scripts } from '@/routes';
import { getUser, cn } from '@/lib/utils';
import { SubSectionHeadingClasses } from '../global/text';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import VisibilityBadge from '@/components/global/model/VisibilityBadge.vue';
const user = getUser(false);
withDefaults(
    defineProps<{
        presentation: Presentation;
        showGuard?: boolean;
        showUser?: boolean;
    }>(),
    {
        showGuard: false,
        showUser: true,
    },
);
const buttonStyles = cn(
    'grow',
    ['cursor-pointer', 'select-none'],
    'block',
    ['min-w-fit', 'max-w-1/2'],
    ['px-5', 'py-1.5'],
    ['rounded-md', 'border-2'],
    [
        'border-neutral-500',
        'hover:border-cyan-600',
        'focus-visible:border-cyan-600',
    ],
    [
        'dark:border-cyan-900',
        'dark:hover:border-cyan-500',
        'dark:focus-visible:border-cyan-500',
    ],
    ['outline-offset-6', 'focus-visible:outline-2'],
    'text-center',
    ['hover:scale-105', 'focus-visible:scale-105'],
    ['bg-background', 'hover:bg-background/90'],
    'transition-all',
);
</script>

<template>
    <div
        data-component="app/PresentationLink"
        :data-guard="presentation.presentation_visibility.title"
        :data-user="presentation.user.name"
        :class="
            cn(
                ['relative', 'flex', 'flex-col'],
                // ['min-h-50', 'sm:min-h-auto'],
                ['aspect-video'],
                ['px-4', 'py-5'],
                ['rounded-xl', 'border'],
                ['border-gray-500', 'dark:border-gray-50/50'],
                ['bg-neutral-50', 'dark:bg-neutral-800'],
            )
        "
    >
        <VisibilityBadge
            v-if="showGuard"
            :visibility="presentation.presentation_visibility"
            class="absolute top-0 right-4 -translate-y-1/2"
        />
        <h3 :class="cn(SubSectionHeadingClasses(), 'mb-2')">
            {{ presentation.title }}
        </h3>

        <template v-if="showUser">
            <span class="creator | mb-4 block italic">
                by:
                {{
                    user?.id === presentation.user.id
                        ? 'You'
                        : presentation.user.name
                }}
            </span>
        </template>

        <div
            class="ct-inline-size | mt-auto flex flex-wrap gap-x-4 gap-y-2 sm:justify-center"
        >
            <a
                :href="presentations(presentation.slug).url"
                target="_blank"
                :title="`Open presentation: ${presentation.title}`"
                :class="buttonStyles"
            >
                Present
            </a>
            <a
                v-if="presentation.presentation_script"
                :href="scripts(presentation.presentation_script.id).url"
                target="_blank"
                :title="`Open script: ${presentation.presentation_script.title}`"
                :class="buttonStyles"
            >
                Read
            </a>
        </div>

        <PlaceholderPattern :interactable="false" />
    </div>
</template>
