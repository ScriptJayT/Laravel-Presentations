<script setup lang="ts">
import type { RouteFormDefinition } from '@/wayfinder';
import { Form, ContentField } from '@/components/global/form';
const props = defineProps<{
    descr?: string;
    to: RouteFormDefinition<'post'>;
}>();
</script>
<template>
    <Form
        :send-to="to"
        form-action="edit"
        class="space-y-10 max-w-3xl"
    >
        <ContentField
            name="description"
            label="Description"
            :value="descr ?? ''"
        />
    </Form>
</template>