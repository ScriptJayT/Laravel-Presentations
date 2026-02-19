<script setup lang="ts">
import { RouteFormDefinition } from '@/wayfinder';
import { Form } from '@inertiajs/vue3';

import { UnsavedChanges, ProcessIndicator } from '@/components/global/form'

defineProps<{
    sendTo: RouteFormDefinition<'post'>;
    id?: string;
    class?: string;
}>();
</script>

<template>
    <Form
        :id
        :class
        v-bind="sendTo"

        :reset-on-error="false"
        :reset-on-success="false"
        disable-while-processing
        v-slot="{ errors, processing, isDirty }"
    >
        <div class="form--meta | absolute bottom-full right-0 m-0">
            <ProcessIndicator :is-in-process="processing"/>
            <UnsavedChanges :has-unsaved-changes="isDirty"/>
        </div>
        <slot :errors />
    </Form>
</template>