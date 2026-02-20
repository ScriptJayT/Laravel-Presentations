<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { Search, X } from 'lucide-vue-next'
import { type QueryAllResult, safeQueryAll } from '@/lib/utils';

type SearchFilterResult = [ QueryAllResult, QueryAllResult ];

const props = withDefaults(
    defineProps<{
        class?: string;
        indexClass?: string;
        searchIn?: string;
        updatableList?: Array<unknown>;
        cacheIndex?: boolean;
        cacheResult?: boolean;
    }>(),
    {
        indexClass: "search-indexable",
        searchIn: "h1, h2, h3, h4, h5, h6",
        cacheIndex: true,
        cacheResult: true,
        updatableList: () => [],
    }
);
let initialCount = props.updatableList.length;
const searchTerm = ref('');
const resultCount = ref(-1);
const cache = new Map<string, SearchFilterResult>();
let elements: QueryAllResult = [];
onMounted(() => {
    //# reset in case of remount and desync
    console.clear();
    resultCount.value = -1;
    cache.clear();
    empty(); // resets input + list-view

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
        console.log("> found it in:", searchField);
        positives.push(_el);
    });
    const result: SearchFilterResult = [ positives, negatives ];
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
        !(searchTerm.value == "" && (_e.key === "Delete" || _e.key==="Backspace")) // delete | backspace on empty input
        && !((_e.altKey || _e.ctrlKey) && _e.key === "Delete") // pressed alt.delete ctrl.delete
    ) return;
    empty();
}
function search(): void {
    // cleanup
    searchTerm.value = searchTerm.value.trim().toLowerCase();
    if(searchTerm.value.length < 1) {
        // shortcircuit if no search term
        resultCount.value = -1;
        markElements(elements, "remove");
        return
    };
    // sync
    console.groupCollapsed("searchin ...");
    if(initialCount !== props.updatableList.length) {
        // clear cache & re-index; list got updated / create-delete
        console.log("Found desync; syncing ...");
        cache.clear();
        elements = indexElements();
        initialCount === elements.length;
    }
    if(!props.cacheIndex) {
        // clear cache & re-index if cache is disabled
        console.log("Reindexed:", elements.length, 'items');
        cache.clear();
        elements = indexElements();
    }
    // search
    const results = filterThrough(searchTerm.value, props.searchIn);
    markElements(results[0], "positive");
    markElements(results[1], "negative");
    console.groupEnd();
}
</script>
<template>
    <search
        :title="`Search through ${updatableList.length} records`"
        :class class="block w-full max-w-2xl mx-auto text-lg"
    >
        <noscript> This search-function needs JavaScript to work </noscript>
        <form
            v-on:submit.prevent="search"
            v-on:reset="empty"
            class="
                flex gap-2
                px-3 py-2
                border rounded-sm
                "
        >
            <input
                id="search" type="text"
                v-on:keyup="resetOnEmpty"
                v-model="searchTerm"
                placeholder="Title"
                class="outline-none grow placeholder:italic"
            >
            <button
                type="reset"
                tabindex="-1"
                title="Reset Filter"
                class="cursor-pointer select-none outline-none"
            >
                <span aria-hidden="true">
                    <X class="size-4" />
                </span>
            </button>
            <button
                type="submit"
                tabindex="-1"
                :title="searchTerm ? `Search for: ${searchTerm}` : 'Search'"
                class="cursor-pointer select-none outline-none"
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