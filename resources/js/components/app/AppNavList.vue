<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import UserDropDown from '@/components/app/UserDropDown.vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { cn } from '@/lib/utils';
import { admin_presentation_index, login, home } from '@/routes';
import { type RouteDefinition } from '@/wayfinder';
defineProps<{ isLoggedIn: boolean }>();
const { isCurrentUrl } = useCurrentUrl();
type NavItem = {
    title: string;
    href: RouteDefinition<'get'>;
    show: 'login' | 'guest' | 'always';
};
const links: NavItem[] = [
    {
        title: 'Home',
        href: home(),
        show: 'always',
    },
    {
        title: 'Dashboard',
        href: admin_presentation_index(),
        show: 'login',
    },
    {
        title: 'Log In',
        href: login(),
        show: 'guest',
    },
];
</script>

<template>
    <ul class="flex flex-wrap items-center gap-4 text-sm leading-normal">
        <template v-for="_link in links">
            <li
                v-if="
                    (_link.show == 'guest' && !isLoggedIn) ||
                    (_link.show == 'login' && isLoggedIn) ||
                    _link.show == 'always'
                "
                class="min-w-fit"
            >
                <Link
                    :aria-current="isCurrentUrl(_link.href) ? 'page' : false"
                    :title="isCurrentUrl(_link.href) ? 'You are here' : 'Go to'"
                    :href="_link.href"
                    v-text="_link.title"
                    :class="
                        cn(
                            'block',
                            ['px-5', 'py-1.5'],
                            ['rounded-md', 'border-2'],
                            isCurrentUrl(_link.href)
                                ? ['border-amber-600', 'dark:border-amber-500']
                                : [
                                      [
                                          'border-neutral-500',
                                          'hover:border-cyan-600',
                                          'focus-visible:border-cyan-600',
                                      ],
                                      [
                                          'dark:border-cyan-900',
                                          'dark:hover:border-cyan-500',
                                          'dark:focus-visible:border-cyan-500',
                                      ],
                                  ],
                            ['outline-offset-6', 'focus-visible:outline-2'],
                            ['hover:scale-105', 'focus-visible:scale-105'],
                            ['bg-background', 'hover:bg-background/90'],
                            'transition-all',
                        )
                    "
                />
            </li>
        </template>
        <li v-if="isLoggedIn" title="User menu">
            <UserDropDown />
        </li>
    </ul>
</template>
