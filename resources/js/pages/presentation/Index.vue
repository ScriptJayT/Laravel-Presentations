<script setup lang="ts">
import { 
    type Presentation,
} from '@/types';
import { Head } from '@inertiajs/vue3';
import { presentations } from '@/routes';

import PlaceholderPattern from '@/components/PlaceholderPattern.vue';

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

    <div class="space-y-4 p-4" >
        <h2>Public Presentations</h2>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <template v-for="_presentation in allPublicPresentations">
                <div class="relative | aspect-video | p-4 | border rounded-xl">
                    <h3> {{ _presentation.title }} </h3>

                    <span class="creator | block">
                        by: {{ _presentation.user.name }}
                    </span>
                    <span class="created_on | block">
                        created on: {{ _presentation.created_at }}
                    </span>
                    <span class="last_edit | block">
                        last edit: {{ _presentation.updated_at }}
                    </span>

                    <a :href="presentations(_presentation.slug).url">
                        /{{ _presentation.slug }} 
                    </a>

                    <div class="pointer-events-none" role="presentation">
                        <PlaceholderPattern />
                    </div>
                </div>
            </template>
        </div>
    </div>

    <template v-if="isLoggedIn">
        <div class="space-y-4 p-4" >
            <h2>Private Presentations</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allPrivatePresentations">
                    <div class="relative | aspect-video | p-4 | border rounded-xl">
                        <h3> {{ _presentation.title }} </h3>
    
                        <span class="creator | block">
                            by: {{ _presentation.user.name }}
                        </span>
                        <span class="created_on | block">
                            created on: {{ _presentation.created_at }}
                        </span>
                        <span class="last_edit | block">
                            last edit: {{ _presentation.updated_at }}
                        </span>
    
                        <a :href="presentations(_presentation.slug).url">
                            /{{ _presentation.slug }} 
                        </a>
    
                        <div class="pointer-events-none" role="presentation">
                            <PlaceholderPattern />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    
        <div class="space-y-4 p-4" >
            <h2>Your Presentations</h2>
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <template v-for="_presentation in allCreatorPresentations">
                    <div class="relative | aspect-video | p-4 | border rounded-xl">
                        <h3> {{ _presentation.title }} </h3>
    
                        <span class="creator | block">
                            by: {{ _presentation.user.name }}
                        </span>
                        <span class="created_on | block">
                            created on: {{ _presentation.created_at }}
                        </span>
                        <span class="last_edit | block">
                            last edit: {{ _presentation.updated_at }}
                        </span>
    
                        <a :href="presentations(_presentation.slug).url">
                            /{{ _presentation.slug }} 
                        </a>
    
                        <div class="pointer-events-none" role="presentation">
                            <PlaceholderPattern />
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>

</template>
