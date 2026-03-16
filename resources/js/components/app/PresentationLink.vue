<script setup lang="ts">
import type { Presentation } from '@/types';
import { presentations, scripts } from '@/routes';
import { getUser } from '@/lib/utils';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import VisibilityBadge from "@/components/global/model/VisibilityBadge.vue"
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
    }
);
</script>

<template>
    <div
        data-component="app/PresentationLink"
        :data-guard="presentation.presentation_visibility.title"
        :data-user="presentation.user.name"
        class="
            relative
            flex flex-col
            px-4 py-5
            min-h-60
            md:aspect-video
            border rounded-xl border-gray-500 dark:border-gray-50/50
            bg-neutral-50 dark:bg-neutral-800
            "
    >
        <VisibilityBadge
            v-if="showGuard"
            :visibility="presentation.presentation_visibility"
            class="absolute top-0 right-4 -translate-y-1/2"
        />
        <h3 class="text-xl font-semibold mb-2">
            {{ presentation.title }}
        </h3>

        <template v-if="showUser">
            <span class="creator | block mb-4">
                by: {{ user?.id === presentation.user.id ? "You" : presentation.user.name }}
            </span>
        </template>

        <div class="
            ct-inline-size
            flex flex-wrap
            gap-x-4 gap-y-2
            mt-auto
            "
        >
            <a
                :href="presentations(presentation.slug).url" target="_blank"
                :title="`Open presentation: ${presentation.title}`"
                class="
                    grow
                    cursor-pointer
                    block min-w-fit
                    px-5 py-1.5
                    rounded-md border-2
                    border-neutral-500 dark:border-cyan-900
                    hover:border-cyan-600 dark:hover:border-cyan-500
                    focus-visible:border-cyan-600 dark:focus-visible:border-cyan-500
                    outline-offset-6 focus-visible:outline-2
                    hover:scale-105
                    focus-visible:scale-105
                    text-center
                    transition-all
                    bg-background hover:bg-background/90
                "
            >
                Present
            </a>
            <template v-if="presentation.presentation_script">
                <a
                    :href="scripts(presentation.presentation_script.id).url" target="_blank"
                    :title="`Open script: ${presentation.presentation_script.title}`"
                    class="
                        grow
                        cursor-pointer
                        block min-w-fit
                        px-5 py-1.5
                        rounded-md border-2
                        border-neutral-500 dark:border-cyan-900
                        hover:border-cyan-600 dark:hover:border-cyan-500
                        focus-visible:border-cyan-600 dark:focus-visible:border-cyan-500
                        outline-offset-6 focus-visible:outline-2
                        hover:scale-105
                        focus-visible:scale-105
                        text-center
                        transition-all
                        bg-background hover:bg-background/90
                    "
                >
                    Read
                </a>
            </template>
        </div>

        <PlaceholderPattern :interactable="false" />
    </div>
</template>