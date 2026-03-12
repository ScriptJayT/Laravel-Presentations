import type { AppServiceShared, Auth } from '@/types';
import { computed } from "vue";
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
    if(count === 0) return `no ${word}${plural_addition}`;
    if(count === 1) return `${count} ${word}`;
    return `${count} ${word}${plural_addition}`;
}

function getAppProp(_prop: keyof AppServiceShared) {
    const props = (usePage().props as unknown as AppServiceShared);
    return props[_prop];
}
export function getAppEnums() {
    return getAppProp('enums') as AppServiceShared['enums'];
}
export function getAppName() {
    return getAppProp("appName") as AppServiceShared['appName'];
}
export function getUser(_reactive: boolean) {
    const page = usePage();
    const auth = page.props.auth as Auth;
    if(!auth) return null;
    if(_reactive) return computed(() => auth.user ?? null);
    return auth.user ?? null;
}

type FileExtension = "md" | "txt";
export function textToDownloaded(
    _content: string,
    _filename: string,
    _extension: FileExtension,
) {
    if(!document) return;
    const mdBlob = new Blob([_content], { type: 'text/md' });
    const tempLink = document.createElement('a');
    tempLink.href = URL.createObjectURL(mdBlob);
    tempLink.download = `${_filename}.${_extension}`;
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
}