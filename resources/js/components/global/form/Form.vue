<script setup lang="ts">
import { RouteFormDefinition } from '@/wayfinder';
import { Form } from '@inertiajs/vue3';

import { UnsavedChanges, ProcessIndicator } from '@/components/global/form'

const props = defineProps<{
    sendTo: RouteFormDefinition<'post'>;
    id?: string;
    class?: string;
    formAction?: "edit" | "create";
    successMessage?: string;
    onError?: (_arg: unknown) => void;
    onSuccess?: (_arg: unknown) => void;
}>();

function success(_response: unknown) {
    if(props.onSuccess) props.onSuccess(_response);
}
function fail(_response: unknown) {
    console.log(_response);
    if(props.onError) props.onError(_response);
}
</script>

<template>
    <Form
        data-component="global/form/Form"
        :id
        :class
        class="inert:opacity-50"
        v-bind="sendTo"
        v-on:success="success"
        v-on:error="fail"
        :reset-on-error="false"
        :reset-on-success="false"
        disable-while-processing
        v-slot="{ errors, processing, isDirty, wasSuccessful, hasErrors }"
    >
        <div class="form--meta | absolute bottom-full right-0 m-0">
            <ProcessIndicator :is-in-process="processing"/>
            <UnsavedChanges
                v-if="formAction==='edit'"
                :has-unsaved-changes="isDirty && !processing"
            />
        </div>

        <slot :hasErrors :errors :wasSuccessful />

        <template v-if="successMessage">
            <div v-show="wasSuccessful" aria-live="polite">
                {{ successMessage }}
            </div>
        </template>
    </Form>
</template>