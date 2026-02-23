<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    LayoutGrid, Presentation, Scroll,
    Users, HeartPulse,
    BookOpen, Folder,
} from 'lucide-vue-next';
import NavFooter from '@/components/dashboard/NavFooter.vue';
import NavMain from '@/components/dashboard/NavMain.vue';
import NavUser from '@/components/dashboard/NavUser.vue';
import {
    Sidebar,
    SidebarContent, SidebarFooter, SidebarHeader,
    SidebarMenu, SidebarMenuButton, SidebarMenuItem,
} from '@/components/ui/sidebar';
import {
    home,
    admin_presentation_index, admin_script_index
} from '@/routes';
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
        href: admin_presentation_index(),
        icon: Presentation,
    },
    {
        title: 'Scripts',
        href: admin_script_index(),
        icon: Scroll,
    },
    {
        title: 'Users',
        href: home(),
        icon: Users,
    },
    {
        title: 'Health',
        href: '/up',
        icon: HeartPulse,
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
                        <Link :href="admin_presentation_index()">
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
