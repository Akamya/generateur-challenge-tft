<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";

const props = defineProps({
    initialResults: Array,
    searchResults: Array,
});

const searchQuery = ref("");
const searchResults = ref(props.initialResults || []);
const isSearching = ref(false);
const showResults = ref(false);

// Create a debounced search function
const debouncedSearch = debounce(async () => {
    if (searchQuery.value.trim().length < 2) {
        searchResults.value = [];
        showResults.value = false;
        return;
    }

    isSearching.value = true;

    try {
        const response = await fetch(
            route("user.search") +
                `?query=${encodeURIComponent(searchQuery.value)}`
        );
        const data = await response.json();

        searchResults.value = data.searchResults || [];
        showResults.value = true;
    } catch (error) {
        console.error("Erreur de recherche :", error);
        searchResults.value = [];
    } finally {
        isSearching.value = false;
    }
}, 300);

// Watch for changes to the search query
watch(searchQuery, () => {
    debouncedSearch();
});

const viewUserHistory = (userId) => {
    searchQuery.value = "";
    searchResults.value = [];
    showResults.value = false;
    router.visit(route("history", userId));
};

const handleClickOutside = (event) => {
    if (!event.target.closest(".search-container")) {
        showResults.value = false;
    }
};

// Close results when clicking outside
if (typeof window !== "undefined") {
    document.addEventListener("click", handleClickOutside);
}
</script>

<template>
    <div class="search-container relative">
        <div class="relative">
            <input
                v-model="searchQuery"
                @focus="showResults = searchResults.length > 0"
                type="text"
                placeholder="E.g. Nordous"
                class="w-full bg-primary-blue/60 border border-primary-blue rounded-full py-2 px-4 text-primary-light placeholder-primary-light/50 focus:outline-none focus:ring-2 focus:ring-primary-first"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <font-awesome-icon
                    v-if="!isSearching"
                    :icon="['fas', 'magnifying-glass']"
                    class="text-primary-light/70"
                    fill="currentColor"
                />

                <svg
                    v-else
                    class="animate-spin h-5 w-5 text-primary-light/70"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
            </div>
        </div>

        <!-- Search Results Dropdown -->
        <div
            v-if="showResults && searchResults.length > 0"
            class="absolute z-50 mt-2 w-full bg-primary-dark border border-primary-blue rounded-lg shadow-lg py-1 max-h-60 overflow-y-auto"
        >
            <div
                v-for="user in searchResults"
                :key="user.id"
                @click="viewUserHistory(user.id)"
                class="px-4 py-2 hover:bg-primary-blue/40 cursor-pointer transition-colors"
            >
                <div class="flex items-center">
                    <div>
                        <div class="text-primary-light font-medium">
                            {{ user?.username }}
                        </div>
                        <div class="text-primary-first text-sm">
                            {{ user?.riot_username }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Results Message -->
        <div
            v-if="
                showResults &&
                searchQuery.trim().length >= 2 &&
                searchResults.length === 0 &&
                !isSearching
            "
            class="absolute z-50 mt-2 w-full bg-primary-dark border border-primary-blue rounded-lg shadow-lg py-4 px-4 text-center"
        >
            <p class="text-primary-light/70">No players found</p>
        </div>
    </div>
</template>
