<script setup lang="ts">
import { useId } from 'vue';
import { cn } from '@/lib/utils';
import { InputError, FieldInfo, type FormFieldAttributes } from '@/components/global/form';
type Props = FormFieldAttributes & { idPrefix?: string }
const props = withDefaults(
    defineProps<Props>(),
    {
        idPrefix: "prefix",
    }
);
const fieldId = props.id ?? `${props.idPrefix}--${useId()}`;
</script>

<template>
    <div data-component="global/form/FormField">
        <field
            :data-disabled="disabled || inert"
            :class="cn(
                ['flex', 'gap-2', 'flex-wrap'],
                ['p-4'],
                ['border-2', 'rounded-md'],
                ['outline-offset-4', 'focus-within:outline-2'],
                props.class
            )"
        >
            <template v-if="label">
                <label
                    :for="fieldId"
                    :class="cn(
                        disabled ? '' : 'cursor-pointer select-none',
                        ['underline-offset-2', 'dark:underline'],
                        ['font-semibold', 'italic'],
                    )"
                >
                    {{ label }}
                </label>
            </template>
            <slot :fieldId />
        </field>
        <div class="flex gap-3 justify-between mt-1">
            <InputError :message="error" />
            <FieldInfo :description class="ml-auto" />
        </div>
    </div>
</template>