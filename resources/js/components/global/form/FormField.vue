<script setup lang="ts">
import InputError from '@/components/InputError.vue';

defineProps<{
    id?: string;
    label?: string;
    class?: string;
    error?: string;
}>();
</script>

<template>
    <div :class data-component="global/form/FormField">
        <InputError :message="error" class="mb-2" />
        <field
            class="
                flex gap-2 flex-wrap
                p-4 border-2 rounded-md
                outline-offset-4
                focus-within:outline-2
                "
        >
            <template v-if="id && label">
                <label class="cursor-pointer select-none font-semibold italic" :for="id"> {{ label }} </label>
            </template>
            <slot/>
        </field>
    </div>
</template>