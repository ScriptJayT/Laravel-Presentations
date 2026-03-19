import { cn } from '@/lib/utils';

export {default as DoubleIconLink} from './DoubleIconLink.vue';
export {default as ActionLink} from './ActionLink.vue';
export {default as ActionButton} from './ActionButton.vue';

const cursorStyles = [
    'cursor-pointer',
    'disabled:cursor-not-allowed',
    'select-none',
];
const interactionStyles = [
    'outline-color-ring',
    'outline-offset-4', 'focus-visible:outline-2',
    'hover:bg-accent', 'dark:hover:bg-accent/50',
    'disabled:opacity-50',
    'transition-colors',
];
const borderStyles = [
    'border', 'rounded-md',
];

export const actionButtonClasses = () => cn(
    cursorStyles,
    interactionStyles,
    borderStyles,
    'block', 'w-fit',
    'px-3', 'py-2',
);
export const formfieldButtonClasses = () => cn(
    cursorStyles,
    interactionStyles,
    borderStyles,
    'min-w-fit', 'p-4',
    'text-center', 'text-balance',
);
export const doubleIconButtonClasses = () => [
    'flex',
    'gap-3',
    'justify-between',
    'items-center'
];