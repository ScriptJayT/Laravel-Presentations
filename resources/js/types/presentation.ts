import { type User, type Model } from "@/types";

export type PresentationVisibility = {
    id: number,
    title: string,
    name: string,
} & Model;
export type PresentationTheme = {
    id: number,
    title: string,
} & Model;
export type PresentationScript = {
    id: number,
    title: string,
    content: string,
    renderedContent: string,
} & Model;
export type PresentationSlide = {
    id: number,
    title: string,
    content: string,
    presentation_theme: PresentationTheme,
} & Model;
export type Presentation = {
    id: number,
    user: User,
    title: string,
    slug: string,
    presentation_visibility: PresentationVisibility,
    presentation_theme: PresentationTheme,
    presentation_script: PresentationScript,
    slides?: Array<PresentationSlide>,
} & Model;