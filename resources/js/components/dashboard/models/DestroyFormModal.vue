<script setup lang="ts">
import type { RouteFormDefinition } from '@/wayfinder';
import { Trash } from 'lucide-vue-next';
import { Form } from '@/components/global/form';
import ActionModal from '@/components/dashboard/ActionModal.vue';
import { metaButtonClasses, metaButtonSpanClasses } from '@/components/dashboard/sections';
import { cn } from '@/lib/utils';

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
        :class="cn(metaButtonClasses(), 'w-full')"
    >
        <span :class="cn(metaButtonSpanClasses())"> Delete </span>
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