import type { AppServiceShared } from '@/types';
import { type InertiaLinkProps, usePage } from '@inertiajs/vue3';
import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export type QueryScope = Element | Document;
export type QueryResult<T = HTMLElement> = T | null;
export type QueryAllResult<T = HTMLElement> = Array<T>;
export function safeQuery<T extends HTMLElement>(query: string, scope: QueryScope = document): QueryResult<T> {
    try { return scope.querySelector<T>(`${query}`); }
    catch (error) { return null; }
}
export function safeQueryAll<T extends HTMLElement>(query: string, scope: QueryScope = document): QueryAllResult<T> {
    try { return Array.from(scope.querySelectorAll<T>(`${query}`)); }
    catch (error) { return []; }
}

export async function wait(timeInSeconds: number): Promise<void> {
    return new Promise((_resolve, _reject) => {
        setTimeout(() => _resolve(), timeInSeconds * 1000);
    });
}

type Nill = undefined | null;
type Countable = Nill | string | Array<unknown> | Record<string|number|symbol, unknown>;
export function plural(countable: Countable, word: string, plural_addition: string = 's'): string {
    const count = !countable
        ? 0
        : typeof countable === "object" && !Array.isArray(countable)
            ? Object.keys(countable).length
            : countable.length;
    if(count === 1) return `${count} ${word}`;
    return `${count} ${word}${plural_addition}`;
}

export function getAppEnums() {
    return (usePage().props.enums as AppServiceShared['enums']);
}