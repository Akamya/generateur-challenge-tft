<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { computed } from "vue";

const props = defineProps({
    seasons: Array,
    origins: Array,
    classes: Array,
});

// Active tab state
const activeTab = ref("seasons");
const originallyActive = ref(false);

const canActivate = computed(() => {
    return !props.seasons.some((season) => season.active);
});

console.log("canActivate", canActivate.value);
// Modal states
const showSeasonModal = ref(false);
const isEditing = ref(false);

const seasonForm = useForm({
    id: null,
    name: "",
    active: false,
});

const showDeleteModal = ref(false);
const selectedSeason = ref(null);
const confirmationText = ref("");

const isEditingCurrentActive = computed(() => {
    return isEditing.value && !!originallyActive.value;
});

const openSeasonForm = (season = null) => {
    isEditing.value = !!season;

    if (season) {
        seasonForm.id = season.id;
        seasonForm.name = season.name;
        seasonForm.active = !!season.active;
        originallyActive.value = !!season.active;
    } else {
        seasonForm.id = null;
        seasonForm.name = "";
        seasonForm.active = false;
    }

    showSeasonModal.value = true;
};

function openDeleteSeasonModal(season) {
    selectedSeason.value = season;
    confirmationText.value = "";
    showDeleteModal.value = true;
}

function confirmDelete() {
    if (confirmationText.value === "DELETE") {
        Inertia.delete(route("admin.season.delete", selectedSeason.value.id));
        showDeleteModal.value = false;
    }
}

// Format date for display
const formatDate = (dateString) => {
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(dateString).toLocaleDateString("en-EN", options);
};

// Format date for input fields (YYYY-MM-DD)
const formatDateForInput = (dateString) => {
    const date = new Date(dateString);
    return date.toISOString().split("T")[0];
};
</script>

<template>
    <AppLayout :show-background="true">
        <main class="relative flex-grow flex flex-col items-center py-12 px-4">
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-10">
                <div
                    class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6 shadow-lg shadow-blue-900/50"
                >
                    <img
                        src="/placeholder.svg?height=64&width=64"
                        alt="TFT Logo"
                        class="h-16 w-16"
                    />
                </div>
                <h1 class="text-white text-5xl font-bold mb-2 tracking-wider">
                    ADMIN PANEL
                </h1>
                <div
                    class="w-64 h-1 bg-gradient-to-r from-yellow-500 via-yellow-400 to-yellow-500 mb-6 rounded-full"
                ></div>
            </div>

            <!-- Admin Interface -->
            <div class="max-w-6xl w-full mx-auto">
                <!-- Navigation Tabs -->
                <div class="flex mb-8 border-b border-blue-700">
                    <button
                        @click="activeTab = 'seasons'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'seasons'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Seasons
                    </button>
                    <button
                        @click="activeTab = 'classes'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'classes'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Classes
                    </button>
                    <button
                        @click="activeTab = 'origins'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'origins'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Origins
                    </button>
                </div>

                <!-- Seasons Tab (Table Layout) -->
                <div
                    v-if="activeTab === 'seasons'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-white text-2xl font-bold">
                            TFT Seasons
                        </h2>
                        <button
                            @click="openSeasonForm()"
                            class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold py-2 px-4 rounded-lg transition-colors shadow-md flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Add Season
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full bg-blue-800/40 rounded-lg overflow-hidden"
                        >
                            <thead>
                                <tr class="bg-blue-800/60 text-left">
                                    <th
                                        class="px-6 py-3 text-yellow-400 font-semibold uppercase tracking-wider text-sm"
                                    >
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-yellow-400 font-semibold uppercase tracking-wider text-sm"
                                    >
                                        Creation Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-yellow-400 font-semibold uppercase tracking-wider text-sm"
                                    >
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-700/50">
                                <tr
                                    v-for="season in props.seasons"
                                    :key="season.id"
                                    class="hover:bg-blue-700/30 transition-colors"
                                >
                                    <td class="px-6 py-4 text-white">
                                        {{ season.name }}
                                    </td>
                                    <td class="px-6 py-4 text-white">
                                        {{ formatDate(season.created_at) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            v-if="season.active"
                                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400"
                                        >
                                            Active
                                        </span>
                                        <span
                                            v-else
                                            class="px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400"
                                        >
                                            Inactive
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <button
                                            @click="openSeasonForm(season)"
                                            class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                            title="Edit season"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            @click="
                                                openDeleteSeasonModal(season)
                                            "
                                            class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                            title="Delete season"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Empty state for no seasons -->
                        <div
                            v-if="!props.seasons || props.seasons.length === 0"
                            class="text-center py-10 bg-blue-800/40 rounded-lg mt-4"
                        >
                            <p class="text-blue-300 text-lg">
                                No seasons found.
                            </p>
                            <button
                                @click="openSeasonForm()"
                                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
                            >
                                Add your first season
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Classes Tab -->
                <div
                    v-if="activeTab === 'classes'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-white text-2xl font-bold">
                                Classes
                            </h2>
                            <p class="text-blue-300">
                                Manage champion classes for TFT
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <div class="relative">
                                <select
                                    class="bg-blue-800 text-white border border-blue-700 rounded-lg px-4 py-2 appearance-none pr-10 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                >
                                    <option
                                        v-for="season in props.seasons"
                                        :key="season.id"
                                        :value="season.id"
                                    >
                                        {{ season.name }}
                                    </option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none"
                                >
                                    <svg
                                        class="w-5 h-5 text-yellow-400"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <button
                                class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold py-2 px-4 rounded-lg transition-colors shadow-md flex items-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Add Class
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Example classes - replace with actual data -->
                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    Hyperpop
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                Hyperpop champions create a beat that grows in
                                intensity.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit class"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete class"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    Disco
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                Disco champions dance around the board, healing
                                allies.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit class"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete class"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    EDM
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                EDM champions drop the bass, stunning nearby
                                enemies.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit class"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete class"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <!-- Empty state for no classes -->
                        <div
                            v-if="false"
                            class="col-span-2 text-center py-10 bg-blue-800/40 rounded-lg"
                        >
                            <p class="text-blue-300 text-lg">
                                No classes found for this season.
                            </p>
                            <button
                                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
                            >
                                Add your first class
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Origins Tab -->
                <div
                    v-if="activeTab === 'origins'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-white text-2xl font-bold">
                                Origins
                            </h2>
                            <p class="text-blue-300">
                                Manage champion origins for TFT
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <div class="relative">
                                <select
                                    class="bg-blue-800 text-white border border-blue-700 rounded-lg px-4 py-2 appearance-none pr-10 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                >
                                    <option
                                        v-for="season in props.seasons"
                                        :key="season.id"
                                        :value="season.id"
                                    >
                                        {{ season.name }}
                                    </option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none"
                                >
                                    <svg
                                        class="w-5 h-5 text-yellow-400"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <button
                                class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold py-2 px-4 rounded-lg transition-colors shadow-md flex items-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Add Origin
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Example origins - replace with actual data -->
                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    K/DA
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                K/DA members gain stacking AP when they cast
                                abilities.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    Pentakill
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                Pentakill members gain AD after scoring a
                                takedown.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    True Damage
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                True Damage members deal bonus true damage with
                                attacks.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <!-- Empty state for no origins -->
                        <div
                            v-if="false"
                            class="col-span-2 text-center py-10 bg-blue-800/40 rounded-lg"
                        >
                            <p class="text-blue-300 text-lg">
                                No origins found for this season.
                            </p>
                            <button
                                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
                            >
                                Add your first origin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Season Modal -->
        <div v-if="showSeasonModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div
                    class="fixed inset-0 bg-black/70 transition-opacity"
                    @click="showSeasonModal = false"
                ></div>

                <div
                    class="relative bg-blue-900 rounded-lg max-w-md w-full p-6 shadow-xl border border-blue-800"
                >
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ isEditing ? "Edit Season" : "Add New Season" }}
                    </h3>

                    <form
                        @submit.prevent="
                            seasonForm.put(route('admin.season.upsert'));
                            showSeasonModal = false;
                        "
                    >
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-yellow-400 text-sm font-medium mb-1"
                                    >Season Name</label
                                >
                                <input
                                    v-model="seasonForm.name"
                                    type="text"
                                    class="w-full bg-blue-800 border border-blue-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    placeholder="e.g. Set 10: Remix Rumble"
                                    required
                                />
                            </div>
                            <div class="flex items-center">
                                <input
                                    id="active-checkbox"
                                    v-model="seasonForm.active"
                                    type="checkbox"
                                    :disabled="
                                        !seasonForm.active &&
                                        !canActivate &&
                                        !isEditingCurrentActive
                                    "
                                    class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-blue-700 rounded"
                                />
                                <label
                                    for="active-checkbox"
                                    class="ml-2 block text-white"
                                >
                                    Set as active season
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button
                                type="button"
                                @click="showSeasonModal = false"
                                class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold px-4 py-2 rounded-lg transition-colors"
                            >
                                {{ isEditing ? "Update" : "Create" }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- delete season modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-lg font-semibold mb-4">
                    Confirmer la suppression
                </h2>

                <h3>
                    All the origins, classes and challenges related to this
                    season will be deleted !
                </h3>
                <p class="mb-4">
                    Pour supprimer cette saison, tape
                    <strong>DELETE</strong> ci-dessous :
                </p>

                <input
                    v-model="confirmationText"
                    type="text"
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                    placeholder="Tapez DELETE pour confirmer"
                />

                <div class="flex justify-end gap-2">
                    <button
                        @click="showDeleteModal = false"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                    >
                        Annuler
                    </button>

                    <button
                        :disabled="confirmationText !== 'DELETE'"
                        @click="confirmDelete"
                        class="px-4 py-2 bg-red-600 text-white rounded disabled:opacity-50"
                    >
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
