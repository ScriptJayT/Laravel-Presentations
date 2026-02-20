import type { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export type QueryResult<T = HTMLElement> = T | null;
export type QueryAllResult<T = HTMLElement> = Array<T>;
export function safeQuery<T extends HTMLElement>(query: string): QueryResult<T> {
    try { return document.querySelector<T>(`${query}`); }
    catch (error) { return null; }
}
export function safeQueryAll<T extends HTMLElement>(query: string): QueryAllResult<T> {
    try { return Array.from(document.querySelectorAll<T>(`${query}`)); }
    catch (error) { return []; }
}