<script setup lang="ts">
import { type Presentation } from '@/types';

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
        <AppHeader/>
        <AppContent class="mt-15 mb-25">
            <Container class="space-y-15">
                <template v-if="isLoggedIn">
                    <PresentationList
                        title="Your Slideshows:"
                        :show-guard="true"
                        :presentations="allCreatorPresentations"
                    />
                    <PresentationList
                        title="Protected slideshows from everyone"
                        :presentations="allPrivatePresentations"
                    />
                </template>
                <PresentationList
                    title="Public Slideshows from everyone"
                    :presentations="allPublicPresentations"
                />
            </Container>
        </AppContent>
        <AppFooter />
    </AppWrapper>
</template>
