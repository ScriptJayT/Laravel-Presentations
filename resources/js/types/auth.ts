import type { Model, Presentation, PresentationScript } from "@/types";

type Permission = {
    id: number;
    name: string;
    description: string;
};
export type Role = {
    id: number;
    name: string;
    permissions: Array<Permission>;
    description: string;
};

export type User = {
    name: string;
    email: string;
    avatar?: string;
    presentations?: Array<Presentation>;
    presentation_scripts?: Array<PresentationScript>;
    email_verified_at: string | null;
    roles: Array<Role>;
    [key: string]: unknown;
} & Model;

export type Auth = { user: User };

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
