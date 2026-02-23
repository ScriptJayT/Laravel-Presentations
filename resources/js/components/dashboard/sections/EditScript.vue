<script setup lang="ts">
import { type PresentationScript } from '@/types';
import { ExternalLink } from 'lucide-vue-next';
import { admin_script_index, admin_scripts } from '@/routes';

import { SelectField } from '@/components/global/form';

const props = defineProps<{
    scripts: PresentationScript[];
    currentScript?: PresentationScript;
    error?: string;
}>();

const options: Record<string, string> = {};
props.scripts.forEach((_script)=>{
    options[_script.id] = `
        <span>${_script.title}</span>
        <span class="ml-auto italic">#${_script.id}</span>
    `;
});
</script>

<template>
    <SelectField
        name="script"
        label="Current Script:"
        null-value-text="None linked"
        :default-value="`${currentScript?.id}`"
        :options
        :error
    />

    <div class="space-y-3">
        <template v-if="currentScript">
            <a class="flex gap-1" target="_blank" :href="admin_scripts(currentScript.id).url">
                <span> Go to script: {{ currentScript.title }} </span>
                <ExternalLink class="size-4"/>
            </a>
        </template>
        <a class="flex gap-1" target="_blank" :href="admin_script_index().url">
            <span> Create a new script </span>
            <ExternalLink class="size-4"/>
        </a>
    </div>
</template>