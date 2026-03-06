<script setup lang="ts">
import { FileField, ContentField, type TextlikeFieldAttributes } from '@/components/global/form';
type Props = Omit<TextlikeFieldAttributes, 'name'>;
defineProps<Props>();

function handleChange(_input: HTMLInputElement) {
    const files = _input.files;
    if(!files) return;
    if(files.length < 1) return;

    const reader = new FileReader();
    reader.onload = () => {
        const res = reader.result?.toString()?.trim();
        if(!res) return;
        console.groupCollapsed('content');
        console.log(res);
        console.groupEnd();
    };
    reader.onerror = () => {
        _input.value = '';
    };
    reader.onprogress = (_p: ProgressEvent) => {
        // console.log(_p);
    };

    Array.from(files).forEach(_file => {
        // const { type } = _file;
        // console.log(type);
        // console.log(_file);
        reader.readAsText(_file);
    });
}
</script>

<template>
    <fieldset data-component="dashboard/models/EditContent">
        <FileField
            :on-change="handleChange"
            class="w-fit ml-auto"
            name="--"
            accept=".md,.txt"
        />
        <ContentField
            name="content"
            :error
            :value="value?.trim()"
        />
    </fieldset>
</template>