<script setup lang="ts">
import { AppearanceTabs } from '@/components/auth';
import { SectionHeading } from '@/components/global/text'
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { edit } from '@/routes/profile';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Profile',
        href: edit().url,
    },
    {
        title: 'Appearance settings',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems" meta-title="Appearance settings">
        <h1 class="sr-only"> Appearance Settings </h1>
        <SettingsLayout>
            <div class="space-y-6">
                <SectionHeading
                    variant="small"
                    title="Appearance settings"
                    description="Update your account's appearance settings"
                />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
