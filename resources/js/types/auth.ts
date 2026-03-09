import type { Model, Presentation, PresentationScript } from "@/types";

export type User = {
    name: string;
    email: string;
    avatar?: string;
    presentations?: Array<Presentation>;
    presentation_scripts?: Array<PresentationScript>;
    email_verified_at: string | null;
    [key: string]: unknown;
} & Model;

export type Auth = {
    user: User;
};

export type TwoFactorConfigContent = {
    title: string;
    description: string;
    buttonText: string;
};
