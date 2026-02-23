<script setup lang="ts">
import { type Auth, type Presentation } from '@/types';
import { presentations, scripts } from '@/routes';
import { usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

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
        data-component="PresentationLink"
        class="
            relative
            flex flex-col
            aspect-video p-4
            border rounded-xl
            "
    >
        <template v-if="showGuard">
            <span
                :data-guard="presentation.presentation_visibility.title"
                class="
                    pointer-events-none select-none
                    absolute top-0 right-4
                    block px-2
                    border rounded-sm
                    -translate-y-1/2
                    italic text-sm
                    bg-white
                    "
            >
                {{ presentation.presentation_visibility.name }}
            </span>
        </template>
        <h3 class="font-semibold">
            {{ presentation.title }}
        </h3>

        <template v-if="showUser">
            <span class="creator | block">
                by: {{ user?.id === presentation.user.id ? "You" : presentation.user.name }}
            </span>
        </template>

        <div class="mt-auto grid grid-cols-2 gap-x-2">
            <a
                :href="presentations(presentation.slug).url" target="_blank"
                :title="`Open presentation: ${presentation.title}`"
                class="
                    grid place-content-center
                    px-2
                    text-center
                    bg-gray-100
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
                        grid place-content-center
                        px-2
                        text-center
                        bg-gray-100
                    "
                >
                    Read
                </a>
            </template>
        </div>

        <PlaceholderPattern :interactable="false" />
    </div>
</template>