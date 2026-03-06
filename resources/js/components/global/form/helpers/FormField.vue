<script setup lang="ts">
import { cn } from '@/lib/utils';
import { InputError, FieldInfo, type FormFieldAttributes } from '@/components/global/form';
const props = defineProps<FormFieldAttributes>();
</script>

<template>
    <div data-component="global/form/FormField">
        <field
            :data-disabled="disabled || inert"
            :class="cn(
                `
                    flex gap-2 flex-wrap
                    p-4
                    border-2 rounded-md
                    outline-offset-4 focus-within:outline-2
                `,
                props.class
                )"
        >
            <template v-if="id && label">
                <label
                    :for="id"
                    class="
                        font-semibold
                        underline-offset-2 dark:underline
                        italic
                        "
                    :class="disabled ? '' : 'cursor-pointer select-none'"
                >
                    {{ label }}
                </label>
            </template>
            <slot/>
        </field>
        <div class="flex gap-3 justify-between mt-1">
            <InputError :message="error" />
            <FieldInfo :description class="ml-auto" />
        </div>
    </div>
</template>