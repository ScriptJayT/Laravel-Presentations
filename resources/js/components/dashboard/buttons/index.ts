export {default as DoubleIconLink} from './DoubleIconLink.vue';

export const actionButtonClasses = () => [
    'block', 'w-fit',
    'px-3', 'py-2',
    'border', 'rounded-md',
    'outline-offset-8',
    'transition-colors',
    'hover:bg-accent', 'dark:hover:bg-accent/50',
];
export const formfieldButtonClasses = () => [
    'min-w-fit', 'p-4',
    'border-2', 'rounded-md',
    'outline-offset-4',
    'text-center', 'text-balance',
    'transition-colors',
    'hover:bg-accent', 'dark:hover:bg-accent/50',
];
export const doubleIconButtonClasses = () => [
    'flex',
    'gap-3',
    'justify-between',
    'items-center'
];