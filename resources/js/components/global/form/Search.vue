<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { Search, X } from 'lucide-vue-next'
import { type QueryAllResult, safeQueryAll } from '@/lib/utils';

type SearchFilterResult = [ QueryAllResult, QueryAllResult ];

const props = withDefaults(
    defineProps<{
        indexClass?: string;
        searchIn?: string;
        cacheIndex?: boolean;
        cacheResult?: boolean;
    }>(),
    {
        indexClass: "search-indexable",
        searchIn: "h1, h2, h3, h4, h5, h6",
        cacheIndex: true,
        cacheResult: true,
    }
);

const searchTerm = ref('');
const resultCount = ref(-1);
const cache = new Map<string, SearchFilterResult>();
let elements: QueryAllResult = [];
onMounted(() => {
    console.clear();
    if(props.cacheIndex) elements = indexElements();
    console.log(elements.length, "searchables indexed in cache");
});

function indexElements(): QueryAllResult {
    return safeQueryAll(`.${props.indexClass}`);
}
function filterThrough(_searchTerm: string, _searchIn: string): SearchFilterResult {
    console.log("Looking for:", _searchTerm);
    if(props.cacheResult && cache.has(_searchTerm)) {
        const cacheResult = cache.get(_searchTerm);
        if(cacheResult) {
            console.log("Found result in cache");
            return cacheResult;
        }
    }
    if(!props.cacheIndex) {
        console.log("Reindexed:", elements.length, 'items');
        elements = indexElements();
    }
    const positives: QueryAllResult = [];
    const negatives: QueryAllResult = [];
    elements.forEach(_el => {
        const searchField = safeQueryAll(`${_searchIn}`, _el)
            .map(_el => _el.innerText)
            .join("")
            .toLowerCase();
        if(searchField.search(`${_searchTerm}`) < 0) {
            negatives.push(_el);
            return
        };
        console.log("found it in:", searchField);
        positives.push(_el);
    });
    const result: SearchFilterResult = [ positives, negatives ];
    console.log(result);
    if(props.cacheResult) cache.set(_searchTerm, result);

    return result;
}
function markElements(_els: Array<HTMLElement>, _mode: "positive" | "negative" | "remove"): void {
    switch (_mode) {
        case "positive":
            resultCount.value = _els.length;
            _els.forEach(_el => {
                _el.classList.add('search-result');
                _el.classList.remove('search-hide');
            });
            break;
        case "negative":
            _els.forEach(_el => {
                _el.classList.add('search-hide');
                _el.classList.remove('search-result');
            });
            break;
        case "remove":
            resultCount.value = -1;
            _els.forEach(_el => {
                _el.classList.remove('search-result');
                _el.classList.remove('search-hide');
            });
            break;
    }
}
function empty(): void {
    searchTerm.value = '';
    search();
}
function resetOnEmpty(_e: KeyboardEvent): void {
    if(
        !(searchTerm.value == "" && (_e.key === "Delete" || _e.key==="Backspace")) // delete backspace on empty input
        && !((_e.altKey || _e.ctrlKey) && _e.key === "Delete") // pressed alt.delete ctrl.delete
    ) return;
    empty();
}
function search(): void {
    searchTerm.value = searchTerm.value.trim().toLowerCase();
    if(searchTerm.value.length < 1) {
        resultCount.value = -1;
        markElements(elements, "remove");
        return
    };
    console.groupCollapsed("searchin ...");
    const results = filterThrough(searchTerm.value, props.searchIn);
    markElements(results[0], "positive");
    markElements(results[1], "negative");
    console.groupEnd();
}
</script>
<template>
    <search
        title="Script"
        class="
            block
            w-fit
            mx-auto
            "
    >
        <noscript> This search-function needs JavaScript to work </noscript>
        <form
            v-on:submit.prevent="search"
            v-on:reset="empty"
            class="
                flex gap-2
                px-2 py-1
                border rounded-sm
                "
        >
            <input
                id="search" type="text"
                v-on:keyup="resetOnEmpty"
                v-model="searchTerm"
                placeholder="title"
                class="outline-none"
            >
            <button
                type="reset"
                tabindex="-1"
                title="Reset Filter"
                class="
                    cursor-pointer select-none
                    outline-none
                    "
            >
                <span aria-hidden="true">
                    <X class="size-4" />
                </span>
            </button>
            <button
                type="submit"
                tabindex="-1"
                :title="searchTerm ? `Search for: ${searchTerm}` : 'Search'"
                class="
                    cursor-pointer select-none
                    outline-none
                    "
            >
                <span aria-hidden="true">
                    <Search class="size-4" />
                </span>
            </button>
        </form>
        <output
            v-show="resultCount > -1"
            aria-live="polite"
            class="block w-fit ml-auto"
        >
            {{ resultCount }} results found
        </output>
    </search>
</template>

<style>
    .search-result {
        border-color: lime;
    }
    .search-hide {
        opacity: 0.2;
    }
</style>