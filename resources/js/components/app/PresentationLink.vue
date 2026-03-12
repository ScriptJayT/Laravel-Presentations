<script setup lang="ts">
import type { Auth, Presentation } from '@/types';
import { presentations, scripts } from '@/routes';
import { usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import VisibilityBadge from "@/components/global/model/VisibilityBadge.vue"

const page = usePage();
const user = (page.props.auth as Auth)?.user ?? null;
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
            aspect-video
            px-4 py-5
            border rounded-xl border-gray-500 dark:border-gray-50/50
            bg-neutral-50 dark:bg-neutral-800
            "
    >
        <VisibilityBadge
            v-if="showGuard"
            :visibility="presentation.presentation_visibility"
            class="absolute top-0 right-4 -translate-y-1/2"
        />
        <h3 class="text-xl font-semibold">
            {{ presentation.title }}
        </h3>

        <template v-if="showUser">
            <span class="creator | block">
                by: {{ user?.id === presentation.user.id ? "You" : presentation.user.name }}
            </span>
        </template>

        <div class="mt-auto grid grid-cols-2 gap-x-4">
            <a
                :href="presentations(presentation.slug).url" target="_blank"
                :title="`Open presentation: ${presentation.title}`"
                class="
                    cursor-pointer
                    block px-5 py-1.5
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
                        cursor-pointer
                        block px-5 py-1.5
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