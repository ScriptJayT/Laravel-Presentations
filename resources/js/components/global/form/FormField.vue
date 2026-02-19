<script setup lang="ts">
import InputError from '@/components/global/form/InputError.vue';
import FieldInfo from '@/components/global/form/FieldInfo.vue';

defineProps<{
    id?: string;
    label?: string;
    class?: string;
    error?: string;
    descr?: string;
}>();
</script>

<template>
    <div :class data-component="global/form/FormField">
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
        <div class="flex gap-3 justify-between mt-1">
            <InputError :message="error" />
            <FieldInfo :description="descr" class="ml-auto" />
        </div>
    </div>
</template>