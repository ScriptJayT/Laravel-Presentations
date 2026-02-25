<script setup lang="ts">
    const props = defineProps<{
        id: string;
    }>();
</script>

<template>
    <dialog
        :id
        class="
            px-4 pt-4 pb-10
            m-auto
            border rounded-xl
            text-foreground
            bg-background
            "
    >
        <button
            command="close"
            :commandfor="id"
            class="
                cursor-pointer select-none
                block w-fit
                ml-auto
                border-b border-b-transparent hover:border-b-current
                outline-offset-4
                transition-colors duration-300
                "
            aria-label="Click or press the Escape-key to close this popup"
        >
            <span aria-hidden="true"> Close <kbd>ESC</kbd> </span>
        </button>
        <slot/>
    </dialog>
</template>

<style>
:root:has(dialog[open]) {
    overflow: clip;
}
</style>

<style scoped>
dialog {
    --bg: hsl(from var(--foreground) h s calc(l * 0.5) / 0.5);
    &::backdrop {
        backdrop-filter: blur(1px);
        background-color: var(--bg);
    }
}
kbd {
    &::before {
        content: "[";
    }
    &::after {
        content: "]";
    }
}
</style>