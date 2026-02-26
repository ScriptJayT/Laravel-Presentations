<script setup lang="ts">
import type { User } from '@/types';
import { computed } from 'vue';
import { Users } from 'lucide-vue-next';
import { useInitials } from '@/composables/useInitials';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
const props = withDefaults(
    defineProps<{
        userName: string;
        avatar?: Required<User['avatar']>;
        inline?: boolean;
    }>(),
    {
        inline: true,
        avatar: 'https://picsum.photos/200/300',
    }
);
const showAvatar = computed(() => props.avatar && props.avatar !== '');
const { getInitials } = useInitials();
</script>

<template>
    <div data-component="global/model/UserAvatar" class="flow-root w-fit">
        <template v-if="inline">
            <Avatar class="size-8 overflow-hidden rounded-lg">
                <AvatarImage
                    v-if="showAvatar"
                    :src="avatar!"
                    :alt="userName"
                />
                <AvatarFallback class="rounded-lg text-black dark:text-white">
                    {{ getInitials(userName) }}
                </AvatarFallback>
            </Avatar>
        </template>

        <template v-else>
            <Avatar
                v-if="showAvatar"
                class="
                    size-30
                    border-4 rounded-full
                    "
            >
                <AvatarImage :src="avatar!" :alt="userName" class="rounded-[inherit]" />
            </Avatar>
            <template v-else>
                <div class="relative isolate w-fit mt-3 mr-3">
                    <Avatar
                        class="
                            absolute bottom-full left-full
                            size-10
                            text-lg
                            -translate-x-2/3
                            translate-y-2/3
                            rounded-lg
                            overflow-hidden
                            "
                    >
                        <AvatarFallback
                            class="
                                rounded-lg
                                text-black dark:text-white
                                "
                        >
                            {{ getInitials(userName) }}
                        </AvatarFallback>
                    </Avatar>
                    <div
                        role="presentation"
                        class="
                            size-30
                            p-2
                            border-4 rounded-full
                            "
                    >
                        <Users class="w-full h-full" stroke-width="1"/>
                    </div>
                </div>
            </template>
        </template>
    </div>
</template>
