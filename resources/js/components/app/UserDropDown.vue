<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import type { Auth } from '@/types';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import UserMenuContent from '@/components/UserMenuContent.vue';

const page = usePage();
const user = (page.props.auth as Auth).user;
</script>

<template v-if="user">
    <DropdownMenu>
        <DropdownMenuTrigger :as-child="true">
            <button class="
                cursor-pointer
                relative
                block px-5 py-1.5
                rounded-md border-2
                border-neutral-500 dark:border-cyan-900
                hover:border-cyan-600 dark:hover:border-cyan-500
                focus-visible:border-cyan-600 dark:focus-visible:border-cyan-500
                outline-offset-6 focus-visible:outline-2
                hover:scale-105
                focus-visible:scale-105
                transition-all
                bg-background hover:bg-background/90
                "
            >
                Hi, {{ user.name }}
            </button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-fit">
            <UserMenuContent :user="user" />
        </DropdownMenuContent>
    </DropdownMenu>
</template>