<script setup lang="ts">
import { FormField } from '@/components/global/form';
withDefaults(
    defineProps<{
        name: string;
        defaultValue?: string;
        nullValueText?: string;
        label?: string;
        class?: string;
        error?: string;
        descr?: string;
        options: Record<string, string>;
    }>(),
    {
        nullValueText: "Default",
    }
);
const id = `selectfield-${crypto.randomUUID()}`;
</script>

<template>
     <FormField :label :class :error :descr :id >
        <select
            :name
            :id
            :data-value="defaultValue"
            class="
                cursor-pointer
                grow
                px-2
                border-transparent outline-none
                "
        >
            <button>
                <selectedcontent></selectedcontent>
            </button>
            <option value="" class="px-2">
                * {{ nullValueText }} *
            </option>
            <template v-for="_text, _value in options">
                <option
                    :value="_value"
                    v-html="_text"
                    :selected="_value === defaultValue"
                    class="px-2"
                />
            </template>
        </select>
    </FormField>
</template>
