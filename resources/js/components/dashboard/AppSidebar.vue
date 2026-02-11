<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, House } from 'lucide-vue-next';
import NavFooter from '@/components/dashboard/NavFooter.vue';
import NavMain from '@/components/dashboard/NavMain.vue';
import NavUser from '@/components/dashboard/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { home, dashboard } from '@/routes';
import AppLogo from '@/components/AppLogo.vue';

import { type NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Home',
        href: home(),
        icon: House,
    },
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
];
const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/ScriptJayT/Laravel-Presentations',
        icon: Folder,
    },
    {
        title: 'Github Repo Laravel-Vue',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation Laravel',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
