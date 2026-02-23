import type { User } from "@/types";

export type Model = HasId & HasTimestamps;

export type HasId = {
    id: number;
}
export type HasTimestamps = {
    created_at: string;
    updated_at: string;
}

export type HasTitle = {
    title: string;
}
export type IsSluggable = {
    slug: string;
}

export type IsLinkedToUser = {
    user: User;
}

export type IsOrderable = {
    order: number;
}
export type HasRenderableContent = {
    content: string;
    renderedContent: string;
}