<script setup lang="ts">
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import { Plus } from 'lucide-vue-next';
import { SectionHeading, SubSectionHeading, FalseHeading } from '@/components/global/text';
import ActionModal from '../ActionModal.vue';

const props = withDefaults(
    defineProps<{
        title: string;
        headingLevel?: 2 | 3;
    }>(),
    {
        headingLevel: 2,
    }
);
</script>

<template>
    <IndexLink :title="`<New ${title}>`" :unsemantic-title="true">
        <button
            class="
                model-create--button |
                cursor-pointer
                absolute inset-0
                grid place-content-center
                border-2 rounded-xl hover:border-green-700 focus-visible:border-green-700
                outline-offset-8
                "
            :title="`Create a New ${title}`"
            command="show-modal"
            :commandfor="`newlink-modal-for-${title.toLowerCase()}`"
        >
            <Plus class="size-[15cqw] opacity-15" />
        </button>
    </IndexLink>
    <ActionModal :id="`newlink-modal-for-${title.toLowerCase()}`" class="min-w-[30vw] max-w-4xl">
        <FalseHeading
            :semantic-lvl="headingLevel"
            :title="`Create a new ${title}`"
            class="my-5"
        />
        <slot/>
    </ActionModal>
</template>