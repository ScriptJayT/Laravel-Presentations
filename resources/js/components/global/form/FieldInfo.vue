<script setup lang="ts">
import { Info } from 'lucide-vue-next';

defineProps<{
    description?: string;
    class?: string;
}>();

const id = `field-info-${crypto.randomUUID()}`;
</script>

<template>
    <div
        data-component="global/form/FieldInfo"
        v-show="description"
        :class
        class="flex gap-2 items-center"
    >
        <button
            type="button"
            command="toggle-popover" :commandfor="id"
            title="Show Hint"
            class="cursor-help text-cyan-950"
        >
            <Info class="size-5" aria-hidden="true" />
        </button>
        <span
            :id popover="hint"
            class="
                block px-2
                border-b border-current
                bg-background
                "
        >
            {{ description }}
        </span>
    </div>
</template>

<style scoped>
div {
    anchor-scope: --field-info;
}
button {
    anchor-name: --field-info;
}
span {
    inset: unset;
    position-area: center left;
    margin-inline: 1ch;
    /* bottom: anchor(top); */
    /* left: anchor(right); */
}
</style>