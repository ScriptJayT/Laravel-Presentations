<script setup lang="ts">

import { Link } from '@inertiajs/vue3';
import { dashboard, login } from '@/routes';
import { RouteDefinition } from '@/wayfinder';

type NavItem = {
    title: string;
    href: RouteDefinition<"get">;
    show: "login" | "guest" | "always"
};

const links: NavItem[] = [
    {
        title: "Dashboard",
        href: dashboard(),
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
                <ul class="flex items-center justify-end gap-4 flex-wrap">
                    <template v-for="_link in links">
                        <template v-if="
                            (_link.show == 'guest' && !$page.props.auth.user)
                            || (_link.show == 'login' && $page.props.auth.user)
                            || _link.show == 'always'
                            "
                        >
                            <li class="min-w-fit">
                                <Link :href="_link.href"
                                    class="
                                        px-5 py-1.5
                                        bg-gray-50 dark:bg-gray-700
                                        rounded-sm border
                                        border-[#19140035] dark:border-[#3E3E3A]
                                        hover:border-[#1915014a] dark:hover:border-[#62605b]
                                        text-[#1b1b18] dark:text-[#EDEDEC]
                                        text-sm leading-normal
                                        "
                                >
                                    {{ _link.title }}
                                </Link>
                            </li>
                        </template>
                    </template>
                </ul>
            </nav>
        </div>
    </header>
</template>