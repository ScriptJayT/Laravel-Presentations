<script setup lang="ts">
import type { User } from '@/types';
import { getUser } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
const user = getUser(false) as User; //we are in dashboard; only accessible if user is logged in
</script>

<template>
    <AppLayout meta-title="Dashboard" >
        <Container>
            <h1 class="text-center text-5xl">
                Welcome to your Hell'press dashboard,
                <span> {{ user.name }} </span>
            </h1>
            <div v-if="user.roles.length > 0">
                You are a:
                {{ user.roles[0].name }}
                meaning you have
            </div>
        </Container>
    </AppLayout>
</template>