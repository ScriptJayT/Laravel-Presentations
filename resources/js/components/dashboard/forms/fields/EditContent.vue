<script setup lang="ts">
import { ref } from 'vue';
import { Download } from 'lucide-vue-next';
import { textToDownloaded, safeQuery } from '@/lib/utils';
import { ActionButton } from '@/components/dashboard/buttons';
import {
    FileField, ContentField, SelectField,
    type TextlikeFieldAttributes
} from '@/components/global/form';
type Props = Omit<TextlikeFieldAttributes, 'name'> & {
    titleInputQuery: string;
};
const props = withDefaults(
    defineProps<Props>(),
    { value: '' }
);

const contentHistory: Array<string> = [];
const insertModeOptions = {
    'before': 'Insert Before',
    'after': 'Insert After',
    'replace': 'Fully replace',
};
const insertOptions = Object.keys(insertModeOptions);

const uploadFailed = ref(false);
const fileProgressPercent = ref(-1);
const fileSize = ref("0 bytes");
const fileName = ref("");
const disabledInput = ref(false);
const fileContent = ref("");
const insertMode = ref(insertOptions[0]);
const content = ref(props.value);

function errorUpload(_input: HTMLInputElement) {
    _input.value = '';
    uploadFailed.value = true;
    fileProgressPercent.value = -1;
    fileSize.value = "0 bytes";
    fileName.value = "";
    fileContent.value = "";
}
function insertFile() {
    // get new content
    let newContent = "";
    switch (insertMode.value) {
        case insertOptions[0]:
            newContent = `${fileContent.value}\n\n${content.value}`;
            break;
        case insertOptions[1]:
            newContent = `${content.value}\n\n${fileContent.value}`;
            break;
        case insertOptions[2]:
            newContent = fileContent.value;
            break;
        default:
            newContent = content.value;
            break;
    }
    // place old value in history
    contentHistory.push(content.value);
    // replace
    content.value = newContent;
    // reset
    fileContent.value = '';
    fileProgressPercent.value = 0;
    fileSize.value = "0 bytes";
    fileName.value = "";
}
function handleChange(_input: HTMLInputElement) {
    const files = _input.files;
    if(!files) return errorUpload(_input);
    if(files.length < 1) return errorUpload(_input);
    const desiredFile = files[0];
    //.md, .txt
    if(!['','text/plain'].includes(desiredFile.type))
        return errorUpload(_input);

    uploadFailed.value = false;
    disabledInput.value = true;
    fileContent.value = '';
    fileProgressPercent.value = 0;
    fileSize.value = `${desiredFile.size} bytes`;
    fileName.value = `${desiredFile.name}`;

    const reader = new FileReader();
    reader.onload = () => {
        disabledInput.value = false;
        _input.value = '';
        const res = reader.result?.toString()?.trim();
        if(!res) return;
        fileContent.value = res;
    };
    reader.onerror = (_err) => {
        disabledInput.value = false;
        errorUpload(_input);
    };
    reader.onprogress = (_p: ProgressEvent) => {
        fileProgressPercent.value = Math.round((_p.loaded/_p.total) * 100);
    };
    reader.readAsText(desiredFile);
}
function popHistory() {
    if(contentHistory.length < 1) return;
    content.value = contentHistory.pop() ?? content.value;
}

function updateInsertMode(_input: HTMLSelectElement) {
    insertMode.value = _input.value;
}
function updateContent(_input: HTMLTextAreaElement) {
    content.value = _input.value;
}

function downloadAsMd() {
    const titleInput = safeQuery<HTMLInputElement>(`input${props.titleInputQuery}`);
    const fileName = titleInput?.value?.trim() || "Hell'Press Download";
    textToDownloaded(content.value, fileName, "md");
}
</script>

<template>
    <fieldset data-component="dashboard/forms/fields/EditContent">
        <div class="flex gap-x-3 justify-end flex-wrap">
            <FileField
                name="--"
                :on-change="handleChange"
                accept=".md,.txt"
                :disabled="disabledInput"
                class="p-2"
            />
            <SelectField
                :on-select="updateInsertMode"
                name="--"
                :allow-null-value="false"
                :options="insertModeOptions"
                :selected="insertMode"
                class="p-2"
            />
            <div>
                <ActionButton
                    :on-click="insertFile"
                    :disabled="!fileContent"
                    text="Paste File"
                />
            </div>
            <div>
                <ActionButton
                    :on-click="popHistory"
                    :disabled="contentHistory.length < 1"
                    text="Undo Paste"
                />
            </div>
        </div>
        <div class="flex justify-end">
            <output
                v-show="uploadFailed"
                aria-live="polite"
                class="text-red-600 dark:text-red-500"
            >
                Something went wrong; make sure you upload a valid file
            </output>
        </div>
        <div class="flex gap-5 justify-end mb-2 text-sm text-muted-foreground">
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
                    class="block w-40 h-2 ml-auto border"
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
        <div class="flex justify-end mt-2">
            <ActionButton
                class="flex gap-2 items-center"
                :on-click="downloadAsMd"
                :disabled="!content"
            >
                <span> Download as Markdown File </span>
                <Download class="size-4 shrink-0" />
            </ActionButton>
        </div>
    </fieldset>
</template>