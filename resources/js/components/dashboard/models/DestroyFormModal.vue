<script setup lang="ts">
import type { RouteFormDefinition } from '@/wayfinder';
import { Trash } from 'lucide-vue-next';
import { Form } from '@/components/global/form';
import ActionModal from '@/components/dashboard/ActionModal.vue';
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
            form-action="delete"
            button-text="Yes, delete this"
            :button-icon="Trash"
            :send-to="route"
        />
    </ActionModal>
</template>