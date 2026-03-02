import type {
    Model,
    HasTitle, IsSluggable,
    HasRenderableContent, IsOrderable,
    IsLinkedToUser,
} from "@/types";

export type PresentationVisibility = {
    name: string,
} & Model & HasTitle;
export type PresentationTheme = Model & HasTitle;
export type PresentationScript = {
    presentation_visibility: PresentationVisibility,
    presentations?: Array<Presentation>,
} & Model & HasTitle & HasRenderableContent;
export type PresentationSlide = {
    presentation_theme: PresentationTheme,
} & Model & HasTitle & HasRenderableContent & IsOrderable;
export type Presentation = {
    presentation_visibility: PresentationVisibility,
    presentation_theme: PresentationTheme,
    presentation_script: PresentationScript,
    slides?: Array<PresentationSlide>,
} & Model & HasTitle & IsSluggable & IsLinkedToUser;