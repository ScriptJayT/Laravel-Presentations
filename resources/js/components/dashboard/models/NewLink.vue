<script setup lang="ts">
import IndexLink from '@/components/dashboard/models/IndexLink.vue';
import { Plus } from '@lucide/vue';
import { cn } from '@/lib/utils';
import { FalseHeading } from '@/components/global/text';
import ActionModal from '../ActionModal.vue';

const props = withDefaults(
    defineProps<{
        title: string;
        headingLevel?: 2 | 3;
    }>(),
    {
        headingLevel: 2,
    },
);
</script>

<template>
    <IndexLink :title="`<New ${title}>`" :unsemantic-title="true">
        <button
            :class="
                cn(
                    'model-create--button',
                    'cursor-pointer',
                    ['absolute', 'inset-0'],
                    ['grid', 'place-content-center'],
                    ['border-2', 'rounded-xl'],
                    [
                        'hover:border-green-700',
                        'focus-visible:border-green-700',
                    ],
                    [
                        'outline-offset-8',
                        'outline-ring',
                        'focus-visible:outline-2',
                    ],
                )
            "
            :title="`Create a New ${title}`"
            command="show-modal"
            :commandfor="`newlink-modal-for-${title.toLowerCase()}`"
        >
            <Plus class="size-[15cqw] opacity-15" />
        </button>
    </IndexLink>
    <ActionModal
        :id="`newlink-modal-for-${title.toLowerCase()}`"
        class="max-w-4xl min-w-[30vw]"
    >
        <FalseHeading
            :semantic-lvl="headingLevel"
            :title="`Create a new ${title}`"
            class="my-5"
        />
        <slot />
    </ActionModal>
</template>
