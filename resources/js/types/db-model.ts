import { Fn } from "@vueuse/core";

export type Model = Id & Timestamps;

export type Id = {
    id: number | string;
}
export type Timestamps = {
    created_at: string;
    updated_at: string;
}