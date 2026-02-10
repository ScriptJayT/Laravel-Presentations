<script setup lang="ts">
import { type Presentation } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

import { dashboard, login } from '@/routes';

import PresentationList from '@/components/app/PresentationList.vue';
import AppContent from '@/components/AppContent.vue';


const props = defineProps<{
    allPublicPresentations: Presentation[];
    allPrivatePresentations: Presentation[];
    allCreatorPresentations: Presentation[];
    isLoggedIn: boolean;
}>();

</script>

<template>
    <Head title="Home" />

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

    <AppContent>
        <template v-if="isLoggedIn">
            <PresentationList title="Your Slideshows" :presentations="allCreatorPresentations"/>
            <PresentationList title="Private Slideshows" :presentations="allPrivatePresentations"/>
        </template>
        <PresentationList title="Public Slideshows" :presentations="allPublicPresentations"/>
    </AppContent>
</template>
