export {default as DoubleIconLink} from './DoubleIconLink.vue';
export {default as ActionLink} from './ActionLink.vue';
export {default as ActionButton} from './ActionButton.vue';

export const actionButtonClasses = () => [
    'cursor-pointer', 'disabled:cursor-not-allowed',
    'select-none',
    'block', 'w-fit',
    'px-3', 'py-2',
    'border', 'rounded-md',
    'outline-offset-4', 'focus-visible:outline-2',
    'disabled:opacity-50',
    'hover:bg-accent', 'dark:hover:bg-accent/50',
    'transition-colors',
];
export const formfieldButtonClasses = () => [
    'min-w-fit', 'p-4',
    'border-2', 'rounded-md',
    'outline-offset-4',
    'text-center', 'text-balance',
    'hover:bg-accent', 'dark:hover:bg-accent/50',
    'transition-colors',
];
export const doubleIconButtonClasses = () => [
    'flex',
    'gap-3',
    'justify-between',
    'items-center'
];