<script setup lang="ts">
import { useId } from 'vue';
import { FormField, type FieldAttributes, inputClasses } from '@/components/global/form';
const props = withDefaults(
    defineProps<FieldAttributes & {
        options: Record<string, string>;
        selected?: string;
        defaultValue?: string;
        allowNullValue?: boolean;
        nullValueText?: string;
        onSelect?: (_input: HTMLSelectElement) => void;
    }>(),
    {
        allowNullValue: true,
        nullValueText: "Default",
    }
);
function handleSelect(_e: Event) {
    if(!props.onSelect) return;
    const input = _e.target as HTMLSelectElement;
    if(!input) return;
    props.onSelect(input);
}
const id = `selectfield-${useId()}`;
</script>

<template>
     <FormField :label :class :error :description :id :disabled :hidden>
        <select
            v-on:change="handleSelect"
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