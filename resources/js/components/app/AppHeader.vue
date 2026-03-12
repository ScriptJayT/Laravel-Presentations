<script setup lang="ts">
import { type Auth } from "@/types";
import { type RouteDefinition } from '@/wayfinder';
import { computed } from "vue";
import { Link, usePage } from '@inertiajs/vue3';
import { admin_presentation_index, login, home } from '@/routes';
import UserDropDown from '@/components/app/UserDropDown.vue';
import { safeQuery } from "@/lib/utils";
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
        <div class="max-w-5xl mx-auto flex items-center justify-between gap-6 flex-wrap">
            <div class="mr-auto"></div>
            <nav class="select-none block min-w-fit w-fit py-3">
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

<style scoped>
    .skip-content {
        translate: 0 calc(-100% - var(--spacing) * 3);

        &:focus-visible {
            translate: 0 0;
        }
    }
</style>