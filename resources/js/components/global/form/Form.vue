<script setup lang="ts">
import { type RouteFormDefinition } from '@/wayfinder';
import { Form } from '@inertiajs/vue3';
import { Save, Trash } from 'lucide-vue-next';
import { type FunctionalComponent } from 'vue';
import { cn } from '@/lib/utils';
import { UnsavedChanges, ProcessIndicator } from '.';

const props = withDefaults(
    defineProps<{
        sendTo: RouteFormDefinition<'post'>;
        id?: string;
        class?: string;
        formAction?: 'neutral' | 'edit' | 'create' | 'delete';
        successMessage?: string;
        showButton?: boolean;
        buttonText?: string;
        buttonIcon?: FunctionalComponent;
        onError?: (..._args: unknown[]) => void;
        onSuccess?: (..._arg: unknown[]) => void;
    }>(),
    {
        formAction: 'neutral',
        showButton: true,
        buttonText: 'Submit',
    },
);
const icon =
    props.buttonIcon ??
    (props.formAction === 'create' || props.formAction === 'edit'
        ? Save
        : props.formAction === 'delete'
          ? Trash
          : null);
const btnColors: Record<typeof props.formAction, string> = {
    create: 'green-700',
    edit: 'cyan-700',
    delete: 'red-700',
    neutral: 'neutral-700',
};

function success(_response: unknown) {
    if (props.onSuccess) props.onSuccess(_response);
}
function fail(_response: unknown) {
    console.log('[DEV]', _response);
    if (props.onError) props.onError(_response);
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
        :reset-on-success="formAction !== 'edit'"
        :set-defaults-on-success="formAction === 'edit'"
        disable-while-processing
        v-slot="{ errors, processing, isDirty, wasSuccessful, hasErrors }"
    >
        <template v-if="formAction === 'edit' && !showButton">
            <div class="form--meta | absolute right-0 bottom-full m-0">
                <ProcessIndicator :is-in-process="processing" />
                <UnsavedChanges :has-unsaved-changes="isDirty && !processing" />
            </div>
        </template>

        <slot :hasErrors :errors :wasSuccessful />

        <template v-if="showButton">
            <button
                type="submit"
                :class="
                    cn(
                        'form-submit--button',
                        ['cursor-pointer', 'select-none'],
                        ['sticky', 'bottom-0'],
                        ['flex', 'items-center', 'gap-3'],
                        ['w-fit', 'px-3', 'py-2', 'mx-auto'],
                        ['rounded-md border', 'outline-offset-8'],
                        `border-${btnColors[formAction]}`,
                        [
                            'bg-neutral-800',
                            'hover:bg-accent',
                            'dark:hover:bg-accent/50',
                        ],
                    )
                "
            >
                <ProcessIndicator :is-in-process="processing" />
                <template v-if="formAction == 'edit'">
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
                            class="absolute inset-0 block h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"
                        />
                    </span>
                </template>
                <span> {{ buttonText }} </span>
                <span class="form-submit--icon" aria-hidden="true">
                    <component v-if="icon" :is="icon" class="size-4" />
                </span>
            </button>
        </template>

        <div v-if="successMessage" v-show="wasSuccessful" aria-live="polite">
            {{ successMessage }}
        </div>
    </Form>
</template>
