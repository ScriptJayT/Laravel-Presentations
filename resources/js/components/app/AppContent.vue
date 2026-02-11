<script setup lang="ts">

defineProps<{
    class?: string
}>();

</script>

<template>
    <main id="site-content" :class>
        <slot />
    </main>
</template>