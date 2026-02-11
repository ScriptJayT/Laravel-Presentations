<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import UserMenuContent from '@/components/UserMenuContent.vue';

const page = usePage();
const user = page.props.auth.user;

</script>

<template v-if="user">
    <DropdownMenu>
        <DropdownMenuTrigger :as-child="true">
            <button class="
                cursor-pointer
                relative
                block w-fit px-5 py-1.5
                rounded-sm border
                border-[#19140035] dark:border-[#3E3E3A]
                hover:border-[#1915014a] dark:hover:border-[#62605b]
                text-[#1b1b18] dark:text-[#EDEDEC]
                bg-gray-50 dark:bg-gray-700"
            >
                Hi, {{ user.name }}
            </button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-fit">
            <UserMenuContent :user="user" />
        </DropdownMenuContent>
    </DropdownMenu>
</template>