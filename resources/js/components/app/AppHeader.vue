<script setup lang="ts">
import { admin_presentation_index, login, home } from '@/routes';
import { type RouteDefinition } from '@/wayfinder';
import { safeQuery, getUser } from "@/lib/utils";
import { Link } from '@inertiajs/vue3';
import UserDropDown from '@/components/app/UserDropDown.vue';
import { AppLogo } from '../global/logo';
const user = getUser(true);
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
async function skipToContent(_e: MouseEvent) {
    const content = safeQuery("#site-content")
    if(!content) return;
    _e.preventDefault();
    content.focus({preventScroll: true});
    content.scrollIntoView({ behavior: "smooth" });
}
</script>

<template>
    <a
        href="#site-content"
        @click="skipToContent"
        class="
            skip-content |
            fixed top-3 left-5
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
        Skip to Content
    </a>

    <header
        id="site-header"
        class="
            border-b-2 dark:border-b-3
            border-cyan-300 dark:border-cyan-900
            bg-neutral-50 dark:bg-neutral-950
            "
    >
        <div class="
            flex items-center justify-between gap-6 flex-wrap
            max-w-7xl
            mx-auto
            py-5 px-4
            "
        >
            <div class="mr-auto flex gap-3 items-center">
                <AppLogo />
            </div>
            <nav class="select-none block min-w-fit w-fit">
                <ul class="
                    flex items-center justify-end gap-4 flex-wrap
                    text-sm leading-normal
                    "
                >
                    <template v-for="_link in links">
                        <li v-if="
                                (_link.show == 'guest' && !user)
                                || (_link.show == 'login' && user)
                                || _link.show == 'always'
                            "
                            class="min-w-fit"
                        >
                            <Link
                                :href="_link.href"
                                v-text="_link.title"
                                class="
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
                            />
                        </li>
                    </template>
                    <li v-if="user">
                        <UserDropDown/>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<style scoped>
    .skip-content {
        translate: 0 calc(-100% - var(--spacing) * 3);

        &:focus-visible {
            translate: 0 0;
        }
    }
</style>