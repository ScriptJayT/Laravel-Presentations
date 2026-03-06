export type FormFieldAttributes = {
    id?: string;
    label?: string;
    class?: string;
    error?: string;
    description?: string;
    disabled?: boolean;
    inert?: boolean;
    hidden?: boolean;
};
export type FieldAttributes = Omit<FormFieldAttributes, 'id'> & { name: string };
export type TextlikeFieldAttributes = FieldAttributes & { value?: string };
export type RangelikeFieldAttributes = FieldAttributes & {
    value?: number;
    min?: number;
    max?: number;
    step?: number;
};

export {default as Form} from "./Form.vue";
export {default as Search} from "./Search.vue";

export {default as FormField} from "./helpers/FormField.vue";
export {default as FieldInfo} from "./helpers/FieldInfo.vue";
export {default as InputError} from "./helpers/InputError.vue";
export {default as UnsavedChanges} from "./helpers/UnsavedChanges.vue";
export {default as ProcessIndicator} from "./helpers/ProcessIndicator.vue";

export {default as TextField} from "./fields/TextField.vue";
export {default as ContentField} from "./fields/ContentField.vue";
export {default as NumberField} from "./fields/NumberField.vue";
export {default as CheckboxField} from "./fields/CheckboxField.vue";
export {default as RedirectToField} from "./fields/RedirectToField.vue";
export {default as SelectField} from "./fields/SelectField.vue";
export {default as FileField} from "./fields/FileField.vue";

export const inputClasses = (): string => `outline-none grow`;