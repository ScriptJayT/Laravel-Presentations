<script setup lang="ts">
import Container from './Container.vue';

defineProps<{
    title?: string;
    mainClass?: string;
    sideClass?: string;
}>();
</script>
<template>
    <Container :title>
        <div
            data-component="dashboard/SideZoneContainer"
            class="field | relative grid gap-12"
        >
            <div class="ct-inline-size" :class="mainClass">
                <slot name="mainzone" />
            </div>
            <aside class="ct-inline-size | space-y-6" :class="sideClass">
                <slot name="sidezone" />
            </aside>
        </div>
    </Container>
</template>

<style scoped>
    .field {
        @container (width > 54rem) {
            grid-template-columns: 1fr 350px;
        }
    }
</style>