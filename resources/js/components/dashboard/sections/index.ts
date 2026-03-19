export {default as AsideZone} from './AsideZone.vue';
export {default as SaveZone} from './SaveZone.vue';
export {default as DangerZone} from './DangerZone.vue';

export {default as CreatedMetaInfo} from './CreatedMetaInfo.vue';

export const metaButtonClasses = () => [
    'cursor-pointer',
    'select-none',
    'flex',
    'justify-between',
    'gap-1',
    'rounded-sm',
    'outline-sidebar-ring',
    'outline-offset-8',
    'group',
];
export const metaButtonSpanClasses = () => [
    'block', 'w-fit',
    'border-b', 'border-transparent',
    'transition-colors',
    'group-hover:border-current'
];