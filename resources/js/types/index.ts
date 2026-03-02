import type { Auth } from './auth';

export * from './auth';
export * from './navigation';
export * from './ui';

export * from './shared';
export * from './db-model';
export * from './presentation';

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
};
