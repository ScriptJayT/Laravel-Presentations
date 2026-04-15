<script setup lang="ts">
import { type RouteFormDefinition } from '@/wayfinder';
import { Form } from '@inertiajs/vue3';
import { Save, Trash, } from 'lucide-vue-next';
import { type FunctionalComponent } from 'vue';
import { UnsavedChanges, ProcessIndicator } from '.'

const props = withDefaults(
    defineProps<{
        sendTo: RouteFormDefinition<'post'>;
        id?: string;
        class?: string;
        formAction?: "edit" | "create" | "delete";
        successMessage?: string;
        showButton?: boolean;
        buttonText?: string;
        buttonIcon?: FunctionalComponent;
        onError?: (..._args: unknown[]) => void;
        onSuccess?: (..._arg: unknown[]) => void;
    }>(),
    {
        showButton: true,
        buttonText: "Submit",
    }
);
const icon = props.buttonIcon ?? (
    (props.formAction === "create") || (props.formAction === "edit")
    ? Save
    : props.formAction === "delete"
        ? Trash
        : null
);

function success(_response: unknown) {
    if(props.onSuccess) props.onSuccess(_response);
}
function fail(_response: unknown) {
    console.log("[DEV]", _response);
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
        :reset-on-success="formAction!=='edit'"
        :set-defaults-on-success="formAction==='edit'"
        disable-while-processing
        v-slot="{ errors, processing, isDirty, wasSuccessful, hasErrors }"
    >
        <template v-if="formAction==='edit' && !showButton">
            <div class="form--meta | absolute bottom-full right-0 m-0">
                <ProcessIndicator :is-in-process="processing"/>
                <UnsavedChanges :has-unsaved-changes="isDirty && !processing" />
            </div>
        </template>

        <slot :hasErrors :errors :wasSuccessful />

        <template v-if="showButton">
            <button
                type="submit"
                :class="
                    formAction === 'create' ? 'border-green-700' : '' +
                    formAction === 'edit' ? 'border-cyan-700' : '' +
                    formAction === 'delete' ? 'border-red-700' : ''
                    "
                class="
                    form-submit--button |
                    cursor-pointer select-none
                    flex items-center gap-3
                    w-fit px-3 py-2
                    border rounded-md mx-auto
                    outline-offset-8
                    transition-colors
                    hover:bg-accent dark:hover:bg-accent/50
                    "
            >
                <ProcessIndicator :is-in-process="processing"/>
                <template v-if="formAction=='edit'">
                    <span
                        v-show="isDirty && !processing"
                        aria-live="polite"
                        class="relative"
                    >
                        <span class="sr-only"> There are unsaved changes </span>
                        <span
                            aria-hidden="true"
                            class="block size-3 rounded-full bg-orange-700"
                        />
                        <span
                            aria-hidden="true"
                            class="
                                absolute inset-0
                                block h-full w-full
                                rounded-full
                                bg-orange-400 opacity-75
                                animate-ping
                                "
                        />
                    </span>
                </template>
                <span> {{ buttonText }} </span>
                <span class="form-submit--icon" aria-hidden="true">
                    <component v-if="icon" :is="icon" class="size-4" />
                </span>
            </button>
        </template>

        <template v-if="successMessage">
            <div v-show="wasSuccessful" aria-live="polite">
                {{ successMessage }}
            </div>
        </template>
    </Form>
</template>