export type Model = Id & Timestamps;

export type Id = {
    id: string;
}
export type Timestamps = {
    created_at: string;
    updated_at: string;
}