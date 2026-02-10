<script setup lang="ts">
import { type Presentation } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { dashboard, login } from '@/routes';

import PresentationLink from '@/components/app/PresentationLink.vue';
import AppContent from '@/components/AppContent.vue';


const props = defineProps<{
    allPublicPresentations: Presentation[];
    allPrivatePresentations: Presentation[];
    allCreatorPresentations: Presentation[];
    isLoggedIn: boolean;
}>();

console.log(
    props.allCreatorPresentations, props.allPrivatePresentations, 
    props.allPublicPresentations, props.isLoggedIn
);
</script>

<template>
    <Head title="Home" />

    <AppContent>
        <header>
            <nav class="flex items-center justify-end gap-4">
                    <Link v-if="$page.props.auth.user"
                        :href="dashboard()"
                        class="rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="login()"
                            class="rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                        >
                            Log in
                        </Link>
                    </template>
                </nav>
        </header>
        <div class="space-y-4 p-4" >
            <h2>Public Presentations</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allPublicPresentations">
                    <PresentationLink :presentation="_presentation" />
                </template>
            </div>
        </div>
        <template v-if="isLoggedIn">
            <div class="space-y-4 p-4" >
                <h2>Private Presentations</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <template v-for="_presentation in allPrivatePresentations">
                        <PresentationLink :presentation="_presentation" />
                    </template>
                </div>
            </div>
            <div class="space-y-4 p-4" >
                <h2>Your Presentations</h2>
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <template v-for="_presentation in allCreatorPresentations">
                        <PresentationLink :presentation="_presentation" />
                    </template>
                </div>
            </div>
        </template>
    </AppContent>
</template>
