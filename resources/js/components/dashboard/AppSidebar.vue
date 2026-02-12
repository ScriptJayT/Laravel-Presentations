<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Presentation, House, Scroll, Users } from 'lucide-vue-next';
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
import AppLogo from '@/components/global/AppLogo.vue';

import { type NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Front',
        href: home(),
        icon: LayoutGrid,
    },
];
const dashboardNavItems: NavItem[] = [
    {
        title: 'Presentations',
        href: dashboard(),
        icon: Presentation,
    },
    {
        title: 'Scripts',
        href: home(),
        icon: Scroll,
    },
    {
        title: 'Users',
        href: home(),
        icon: Users,
    },
];
const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/ScriptJayT/Laravel-Presentations',
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
            <NavMain :items="mainNavItems" label="Platform" />
            <NavMain :items="dashboardNavItems" label="Dashboard"/>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
