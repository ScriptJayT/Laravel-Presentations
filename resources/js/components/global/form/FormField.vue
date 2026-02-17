<script setup lang="ts">
defineProps<{
    id?: string;
    label?: string;
    class?: string;
}>();
</script>

<template>
    <field
        :class
        class="
            flex gap-2
            outline-offset-4
            focus-within:outline-2
            "
    >
        <template v-if="id && label">
            <label class="cursor-pointer select-none" :for="id"> {{ label }} </label>
        </template>
        <slot/>
    </field>
</template>