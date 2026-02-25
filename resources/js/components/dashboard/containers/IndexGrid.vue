<script setup lang="ts">
defineProps<{
    class?: string;
}>();
</script>

<template>
    <div
        data-component="dashboard/containers/IndexGrid"
        :class
        class="grid auto-rows-min gap-x-6 gap-y-12"
    >
        <slot />
    </div>
</template>

<style scoped>
    div {
        grid-template-columns: repeat(var(--col-count, 1), 1fr);

        /* md */
        @container(width >= 48rem) {
            --col-count: 3;
        }
        /* lg */
        @container(width >= 64rem) {
            --col-count: 4;
        }
        /* fallback */
        @supports not (container-type: inline-size) {
            background: red;

            @media (width >= 48rem) {
                --col-count: 3;
            }
            @media (width >= 64rem) {
                --col-count: 4;
            }
        }
    }
</style>