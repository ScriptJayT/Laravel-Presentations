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
            <div class="order-2 space-y-6" :class="sideClass">
                <slot name="sidezone" />
            </div>
            <div class="ct-inline-size | order-1" :class="mainClass">
                <slot name="mainzone" />
            </div>
        </div>
    </Container>
</template>

<style scoped>
    .field {
        grid-template-columns: 1fr auto;
        /* a column with auto is not able to be/contain a inline size container */
    }
</style>