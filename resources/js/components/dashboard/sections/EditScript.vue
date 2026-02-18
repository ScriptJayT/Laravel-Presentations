<script setup lang="ts">
import { type PresentationScript } from '@/types';
import { ExternalLink } from 'lucide-vue-next';
import { admin_script_index, admin_scripts } from '@/routes';

import FormField from '@/components/global/form/FormField.vue';

const props = defineProps<{
    scripts: PresentationScript[];
    currentScript?: PresentationScript;
}>();
</script>

<template>
    <FormField label="Current Script:" id="select-script" >
        <select
            :value="currentScript?.id"
            name="script" id="select-script"
            class="
                cursor-pointer
                block grow
                px-2 border-transparent
                "
        >
            <button> <selectedcontent></selectedcontent> </button>
            <option value="" class="italic"> * None linked * </option>
            <template v-for="_script in scripts">
                <option class="px-2" :value="_script.id">
                    <span>
                        {{ _script.title }}
                    </span>
                    <span>
                        #{{ _script.id }}
                    </span>
                </option>
            </template>
        </select>
    </FormField>
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