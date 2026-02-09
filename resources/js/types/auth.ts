import { type Model } from "@/types";

export type User = {
    name: string;
    email: string;
    avatar?: string;
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
