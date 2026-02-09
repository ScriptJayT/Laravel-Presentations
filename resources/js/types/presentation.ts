import { type User, type Model } from "@/types";

export type PresentationVisibility = {
    id: number,
    title: string,
} & Model;
export type PresentationTheme = {
    id: number,
    title: string,
} & Model;
export type PresentationScript = {
    id: number,
    title: string,
    content: string,
} & Model;
export type Presentation = {
    user: User,
    title: string,
    presentation_visibility: PresentationVisibility,
    presentation_theme: PresentationTheme,
    presentation_script: PresentationScript,
} & Model;