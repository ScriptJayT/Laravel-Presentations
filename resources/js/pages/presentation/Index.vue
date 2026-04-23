<script setup lang="ts">
import type { Presentation } from '@/types';
import { User, Shield, LockOpen } from '@lucide/vue';
import AppWrapper from '@/components/app/AppWrapper.vue';
import AppHeader from '@/components/app/AppHeader.vue';
import AppContent from '@/components/app/AppContent.vue';
import AppFooter from '@/components/app/AppFooter.vue';
import Container from '@/components/app/Container.vue';
import PresentationList from '@/components/app/PresentationList.vue';
defineProps<{
    allPublicPresentations: Presentation[];
    allPrivatePresentations: Presentation[];
    allCreatorPresentations: Presentation[];
    isLoggedIn: boolean;
}>();
</script>

<template>
    <AppWrapper meta-title="Home">
        <AppHeader :is-logged-in="isLoggedIn" />
        <AppContent class="pt-15 pb-25">
            <Container class="space-y-15">
                <template v-if="isLoggedIn">
                    <PresentationList
                        title="Your Slideshows:"
                        :show-guard="true"
                        :show-user="false"
                        :icon="User"
                        :presentations="allCreatorPresentations"
                        class="min-h-50 md:min-h-80"
                    />
                    <PresentationList
                        title="Protected slideshows from everyone:"
                        :presentations="allPrivatePresentations"
                        class="mt-25"
                        :icon="Shield"
                    />
                </template>
                <PresentationList
                    title="Public Slideshows from everyone:"
                    :presentations="allPublicPresentations"
                    :icon="LockOpen"
                />
            </Container>
        </AppContent>
        <AppFooter />
    </AppWrapper>
</template>
