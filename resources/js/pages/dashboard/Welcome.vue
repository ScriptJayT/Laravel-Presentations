<script setup lang="ts">
import type { User } from '@/types';
import { getUser, handleRoles } from '@/lib/utils';
import AppLayout from '@/layouts/AppLayout.vue';
import { Container } from '@/components/dashboard/containers';
const user = getUser(false) as User; //we are in dashboard; only accessible if user is logged in
const roles = handleRoles(user);
</script>

<template>
    <AppLayout meta-title="Dashboard" >
        <Container>
            <h1 class="text-center text-5xl">
                Welcome to your Hell'press dashboard,
                <span> {{ user.name }} </span>
            </h1>
            <p class="mt-15 text-center text-xl">
                <template v-if="roles.hasAny()">
                    You are a:
                    {{ roles.getMain().name }}
                    meaning you have {{ roles.getMain().description }}
                </template>
                <template v-else>
                    You have no assigned roles, meaning you have nothing to do here;
                    <br> check with an admin if this is correct.
                </template>
            </p>
        </Container>
    </AppLayout>
</template>