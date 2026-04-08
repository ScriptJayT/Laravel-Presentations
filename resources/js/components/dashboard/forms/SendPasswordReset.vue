<script setup lang="ts">
import { send_password } from '@/routes';
import { Form } from '@/components/global/form';
defineProps<{ email: string }>();
</script>

<template>
    <Form
        :send-to="send_password.form()"
        button-text="Send password reset link"
        class="w-fit"
        v-slot="{ errors, wasSuccessful }"
    >
        <div v-if="wasSuccessful"> Reset-link send </div>
        <div v-if="errors.email"> The users email is invalid? </div>
        <div v-if="errors.status"> Something went wrong </div>
        <input type="hidden" name="email" :value="email">
    </Form>
</template>