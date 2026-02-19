<script setup lang="ts">
import FormField from '@/components/global/form/FormField.vue';
import { Spinner } from '@/components/ui/spinner';
import { Save } from 'lucide-vue-next';

import { store } from '@/routes/admin_script';
import { Form } from '@inertiajs/vue3';
</script>

<template>
    <Form
        id="update-script-form"
        class="
            grid gap-6
            inert:opacity-50
            "
        :reset-on-error="true"
        :reset-on-success="true"
        v-bind="store.form()"
        disable-while-processing
        v-slot="{ errors, processing, wasSuccessful }"
    >
        <p v-show="wasSuccessful"> New Slide was created </p>

        <FormField :error="errors.title" label="Slide Title:" id="slide-title">
            <input
                type="text" name="title" id="slide-title"
                class="grow outline-none"
            >
        </FormField>

        <label class="cursor-pointer flex gap-2 items-center">
            <span class="select-none">Directly open edit-page</span>
            <input type="checkbox" name="goto" checked>
        </label>

        <div class="flex gap-5 items-end">
            <Spinner v-if="processing" />
            <button
                class="
                    cursor-pointer select-none
                    flex items-center gap-1
                    w-fit
                    px-3 py-2 ml-auto
                    border border-green-700 rounded-md
                    outline-offset-8
                    "
            >
                <span> Create new slide </span>
                <Save class="size-4"/>
            </button>
        </div>
    </Form>
</template>