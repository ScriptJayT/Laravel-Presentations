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
            <p>
                <template v-if="user.roles.length > 0">
                    You are a:
                    {{ user.roles[0].name }}
                    meaning you have
                </template>
                <template v-else>
                    You have no assigned roles, meaning you have nothing to do here;
                    <br> check with an admin if this is correct.
                </template>
            </p>
        </Container>
    </AppLayout>
</template>