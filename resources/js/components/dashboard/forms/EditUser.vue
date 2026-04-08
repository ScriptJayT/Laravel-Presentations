<script setup lang="ts">
import type { User } from '@/types';
import { Form, TextField, FileField } from '@/components/global/form';
import { update } from '@/routes/admin_user';
import UserAvatar from '@/components/global/model/UserAvatar.vue';

defineProps<{ user: User }>();
</script>
<template>
    <Form
        id="update-form-edit"
        :send-to="update.form(user.id)"
        :show-button="false"
        class="grid grid-cols-2 gap-10"
    >
        <fieldset class="space-y-5">
            <legend class="sr-only">Credentials</legend>
            <TextField label="Name:" name="name" :value="user.name" />
            <TextField label="Email:" name="email" :value="user.email" />
            <TextField
                label="Email validated:"
                name="--"
                :value="user.email_verified_at ? 'Yes' : 'No'"
                disabled
            />
        </fieldset>
        <fieldset class="space-y-5">
            <legend class="sr-only">Visual Representation</legend>
            <UserAvatar
                :avatar="user.avatar"
                :user-name="user.name"
                :inline="false"
                class="ml-auto"
            />
            <FileField label="Avatar:" name="avatar" />
        </fieldset>
    </Form>
</template>
