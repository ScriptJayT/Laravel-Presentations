<script setup lang="ts">
import { type Auth, type Presentation } from '@/types';
import { presentations, scripts } from '@/routes';
import { usePage } from '@inertiajs/vue3';
import { Shield, Lock, LockOpen } from "lucide-vue-next";
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
            border rounded-xl
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