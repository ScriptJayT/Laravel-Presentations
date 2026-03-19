<script setup lang="ts">
import { admin_presentation_index, login, home } from '@/routes';
import { type RouteDefinition } from '@/wayfinder';
import { safeQuery, getUser, cn } from '@/lib/utils';
import { Link } from '@inertiajs/vue3';
import UserDropDown from '@/components/app/UserDropDown.vue';
import { AppLogo } from '../global/logo';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
const user = getUser(true);
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
async function skipToContent(_e: MouseEvent) {
    const content = safeQuery('#site-content');
    if (!content) return;
    _e.preventDefault();
    content.focus({ preventScroll: true });
    content.scrollIntoView({ behavior: 'smooth' });
}
const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <a
        href="#site-content"
        @click="skipToContent"
        class="skip-content | fixed top-3 left-5 block rounded-md border-2 border-neutral-500 bg-background px-5 py-1.5 outline-offset-6 transition-all hover:scale-105 hover:border-cyan-600 hover:bg-background/90 focus-visible:scale-105 focus-visible:border-cyan-600 focus-visible:outline-2 dark:border-cyan-900 dark:hover:border-cyan-500 dark:focus-visible:border-cyan-500"
    >
        Skip to Content
    </a>

    <header
        id="site-header"
        class="border-b-2 border-cyan-300 bg-neutral-50 dark:border-b-3 dark:border-cyan-900 dark:bg-neutral-950"
    >
        <div
            class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-6 px-4 py-5"
        >
            <div class="mr-auto flex items-center gap-3">
                <AppLogo />
            </div>
            <nav class="block w-fit min-w-fit select-none">
                <ul
                    class="flex flex-wrap items-center gap-4 text-sm leading-normal"
                >
                    <template v-for="_link in links">
                        <li
                            v-if="
                                (_link.show == 'guest' && !user) ||
                                (_link.show == 'login' && user) ||
                                _link.show == 'always'
                            "
                            class="min-w-fit"
                        >
                            <Link
                                :aria-current="
                                    isCurrentUrl(_link.href) ? 'page' : false
                                "
                                :title="
                                    isCurrentUrl(_link.href)
                                        ? 'You are here'
                                        : 'Go to'
                                "
                                :href="_link.href"
                                v-text="_link.title"
                                :class="
                                    cn(
                                        'block',
                                        ['px-5', 'py-1.5'],
                                        ['rounded-md', 'border-2'],
                                        isCurrentUrl(_link.href)
                                            ? [
                                                  'border-amber-600',
                                                  'dark:border-amber-500',
                                              ]
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
                                        [
                                            'outline-offset-6',
                                            'focus-visible:outline-2',
                                        ],
                                        [
                                            'hover:scale-105',
                                            'focus-visible:scale-105',
                                        ],
                                        [
                                            'bg-background',
                                            'hover:bg-background/90',
                                        ],
                                        'transition-all',
                                    )
                                "
                            />
                        </li>
                    </template>
                    <li v-if="user" title="User menu">
                        <UserDropDown />
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
