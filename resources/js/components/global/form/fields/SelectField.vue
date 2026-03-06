<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type FieldAttributes, inputClasses } from '@/components/global/form';
withDefaults(
    defineProps<FieldAttributes & {
        options: Record<string, string>;
        selected?: string;
        defaultValue?: string;
        allowNullValue?: boolean;
        nullValueText?: string;
    }>(),
    {
        allowNullValue: true,
        nullValueText: "Default",
    }
);
const id = `selectfield-${useId()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden>
        <select
            :name
            :id
            :data-value="defaultValue ?? selected"
            :class="inputClasses()"
            class="cursor-pointer border-transparent"
        >
            <button>
                <selectedcontent></selectedcontent>
            </button>
            <template v-if="allowNullValue">
                <option value="" class="px-2 my-1">
                    * {{ nullValueText }} *
                </option>
            </template>
            <template v-for="_text, _value in options">
                <option
                    :value="_value"
                    v-html="_text"
                    :selected="_value === (defaultValue ?? selected)"
                    class="px-2 my-1"
                />
            </template>
        </select>
    </FormField>
</template>

<style scoped>
    ::picker(select) {
        max-height: 10lh;
        color: var(--foreground);
        background-color: var(--background);
    }
</style>