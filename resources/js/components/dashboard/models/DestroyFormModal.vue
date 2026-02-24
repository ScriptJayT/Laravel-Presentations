<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';

import { Spinner } from '@/components/ui/spinner';
import ActionModal from '@/components/dashboard/ActionModal.vue';
import { RouteFormDefinition } from '@/wayfinder';

const props = defineProps<{
    id: string|number;
    route: RouteFormDefinition<'post'>;
}>();
</script>

<template>
    <button
        type="button"
        command="show-modal"
        :commandfor="`destroy-dialog-for-${id}`"
        class="
            cursor-pointer select-none
            flex items-center justify-between gap-1
            w-full
            rounded-sm
            outline-sidebar-ring
            outline-offset-8
            "
    >
        <span> Delete </span>
        <Trash class="size-4"/>
    </button>
    <ActionModal :id="`destroy-dialog-for-${id}`">
        <p class="my-5">
            Are you sure you want to delete this entry? This is irreversible.
        </p>
        <Form
            v-bind="route"
            v-slot="{ processing }"
        >
            <button
                class="
                    cursor-pointer select-none
                    flex items-center gap-1
                    w-fit
                    px-2 py-1 mx-auto
                    border border-red-900 rounded-md
                    outline-offset-8
                    "
            >
                <span> Yes, delete this </span>
                <Trash class="size-4"/>
            </button>
            <Spinner v-if="processing" />
        </Form>
    </ActionModal>
</template>