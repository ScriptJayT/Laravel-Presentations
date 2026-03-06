<script setup lang="ts">
import { ref } from 'vue';
import {
    FileField, ContentField, SelectField,
    type TextlikeFieldAttributes
} from '@/components/global/form';
type Props = Omit<TextlikeFieldAttributes, 'name'>;
const props = defineProps<Props>();

const fileProgressPercent = ref(-1);
const fileSize = ref("0 bytes");
const fileName = ref("");
const disabledInput = ref(false);
const fileContent = ref("");
const insertMode = ref("before");
const content = ref(props.value ?? "");

function insertFile() {
    console.log(insertMode.value);
    // console.log(fileContent.value);
    // console.log(content.value);
}

function handleChange(_input: HTMLInputElement) {
    const files = _input.files;
    if(!files) return;
    if(files.length < 1) return;

    disabledInput.value = true;
    fileContent.value = '';
    fileProgressPercent.value = 0;
    fileSize.value = `${files[0].size} bytes`;
    fileName.value = `${files[0].name}`;

    const reader = new FileReader();
    reader.onload = () => {
        disabledInput.value = false;
        const res = reader.result?.toString()?.trim();
        if(!res) return;
        fileContent.value = res;
    };
    reader.onerror = (_err) => {
        console.log(_err);
        _input.value = '';
    };
    reader.onprogress = (_p: ProgressEvent) => {
        fileProgressPercent.value = Math.round((_p.loaded/_p.total) * 100);
    };
    reader.readAsText(files[0]);
}

function updateContent(_input: HTMLTextAreaElement) {
    content.value = _input.value;
}
</script>

<template>
    <fieldset data-component="dashboard/models/EditContent">
        <div class="flex gap-3 justify-end">
            <FileField
                name="--"
                :on-change="handleChange"
                accept=".md,.txt"
                :disabled="disabledInput"
                class="p-2"
            />
            <SelectField
                name="---"
                :allow-null-value="false"
                :options="{
                    'before': 'Insert Before',
                    'after': 'Insert After',
                    'replace': 'Fully replace',
                    }"
                :selected="insertMode"
                class="p-2"
            />
            <button
                v-on:click="insertFile"
                :disabled="!fileContent"
                type="button"
                :class="!fileContent ? 'cursor-not-allowed' : 'cursor-pointer'"
                class="border-2 rounded-md p-2"
            >
                Paste
            </button>
        </div>

        <div class="flex gap-5 w-fit ml-auto mb-2">
            <output
                v-show="fileName"
                aria-live="polite"
            >
                Current file: {{ fileName }}
            </output>
            <output
                v-show="fileProgressPercent >= 0"
                aria-live="polite"
            >
                {{ fileProgressPercent }}% of
                {{ fileSize }} loaded
                <span
                    aria-hidden="true"
                    class="block w-40 h-3 ml-auto border"
                >
                    <span
                        class="block size-full origin-right scale-x-0 transition-transform bg-green-500"
                        :style="`scale:${fileProgressPercent}%`"
                    />
                </span>
            </output>
        </div>

        <ContentField
            :on-input="updateContent"
            name="content"
            :error
            :value="content"
        />
    </fieldset>
</template>