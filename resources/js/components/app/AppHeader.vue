<script setup lang="ts">
import { type Auth } from "@/types";
import { type RouteDefinition } from '@/wayfinder';
import { computed } from "vue";
import { Link, usePage } from '@inertiajs/vue3';
import { admin_presentation_index, login, home } from '@/routes';
import UserDropDown from '@/components/app/UserDropDown.vue';

const page = usePage();
const user = computed(() => (page.props.auth as Auth)?.user ?? null);

type NavItem = {
    title: string;
    href: RouteDefinition<"get">;
    show: "login" | "guest" | "always"
};
const links: NavItem[] = [
    {
        title: "Home",
        href: home(),
        show: "always",
    },
    {
        title: "Dashboard",
        href: admin_presentation_index(),
        show: "login",
    },
    {
        title: "Log In",
        href: login(),
        show: "guest",
    }
];
</script>

<template>
    <header id="site-header" class="bg-violet-200">
        <div class="max-w-5xl mx-auto flex items-center justify-between gap-6 flex-wrap">
            <div class="mr-auto"></div>
            <nav class="block min-w-fit w-fit py-3">
                <ul class="flex items-center justify-end gap-4 flex-wrap text-sm leading-normal">
                    <template v-for="_link in links">
                        <template v-if="
                            (_link.show == 'guest' && !user)
                            || (_link.show == 'login' && user)
                            || _link.show == 'always'
                            "
                        >
                            <li class="min-w-fit">
                                <Link :href="_link.href"
                                    class="
                                        block px-5 py-1.5
                                        bg-gray-50 dark:bg-gray-700
                                        rounded-sm border
                                        border-[#19140035] dark:border-[#3E3E3A]
                                        hover:border-[#1915014a] dark:hover:border-[#62605b]
                                        text-[#1b1b18] dark:text-[#EDEDEC]
                                        "
                                >
                                    {{ _link.title }}
                                </Link>
                            </li>
                        </template>
                    </template>

                    <template v-if="user">
                        <li> <UserDropDown/> </li>
                    </template>
                </ul>
            </nav>
        </div>
    </header>
</template>