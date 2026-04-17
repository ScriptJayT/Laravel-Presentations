import type { AppServiceShared, Auth, User } from '@/types';
import { computed } from "vue";
import { type InertiaLinkProps, usePage } from '@inertiajs/vue3';
import { type ClassValue, clsx } from 'clsx';
import { twMerge } from 'tailwind-merge';

export const cn = (...inputs: ClassValue[]) => twMerge(clsx(inputs));

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

export function fullscreenController(target: QueryResult) {
    function isCapable(_target: unknown): _target is HTMLElement {
        if(!document.fullscreenEnabled) return false;
        if(!_target) return false;
        return true;
    };
    const open = async () => {
        if(!isCapable(target)) return;
        if(document.fullscreenElement) return;
        return await target.requestFullscreen();
    };
    const close = async () => {
        if(!isCapable(target)) return;
        if(!document.fullscreenElement) return;
        return await document.exitFullscreen()
    };
    const toggle = async () => {
        if(!isCapable(target)) return;
        if(document.fullscreenElement) return close();
        return open();
    }
    return {open, close, toggle};
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
    if(count === 0) return `no ${word}${plural_addition}`;
    return `${count} ${word}${plural_addition}`;
}

function getAppProp(_prop: keyof AppServiceShared) {
    const props = usePage().props;
    return props[_prop];
}
export const getAppEnums = () => getAppProp('enums') as AppServiceShared['enums'];
export const getAppName = () => getAppProp("appName") as AppServiceShared['appName'];
export function getUser(_reactive: boolean) {
    const auth = usePage().props.auth as Auth;
    if(!auth) return null;
    if(_reactive) return computed(() => auth.user ?? null);
    return auth.user ?? null;
}
export function handleRoles(_user?: User) {
    const roles = _user?.roles ?? [];
    const hasAny = () => roles.length > 0;
    const getMain = () => roles[0];
    return { hasAny, getMain };
}

type FileExtension = "md" | "txt";
export function textToDownloaded(
    _content: string,
    _filename: string,
    _extension: FileExtension,
) {
    if(!document) return;
    const fileBlob = new Blob([_content], { type: 'text/md' });
    const tempLink = document.createElement('a');
    tempLink.href = URL.createObjectURL(fileBlob);
    tempLink.download = `${_filename}.${_extension}`;
    tempLink.style.display = 'none';
    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);
}