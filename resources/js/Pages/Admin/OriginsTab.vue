<script setup>
import { defineProps, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import { computed } from "vue";

const props = defineProps({
    seasons: Array,
    origins: Array,
});

const isEditing = ref(false);
const showOriginModal = ref(false);
const showDeleteModal = ref(false);
const selectedOrigin = ref(null);
const confirmationText = ref("");
const selectedSeasonId = ref(
    props.seasons.length > 0 ? props.seasons[0].id : null
);

const originForm = useForm({
    id: null,
    name: "",
    technical_name: "",
    season_id: selectedSeasonId,
});

const filteredOrigins = computed(() => {
    return props.origins.filter(
        (origin) => origin.season_id === selectedSeasonId.value
    );
});

const openOriginForm = (origin = null) => {
    isEditing.value = !!origin;

    if (origin) {
        originForm.id = origin.id;
        originForm.name = origin.name;
        originForm.technical_name = origin.technical_name;
        originForm.season_id = origin.season_id;
    } else {
        originForm.id = null;
        originForm.name = "";
        originForm.technical_name = "";
        originForm.season_id = selectedSeasonId;
    }

    showOriginModal.value = true;
};

function openDeleteOriginModal(origin) {
    selectedOrigin.value = origin;
    confirmationText.value = "";
    showDeleteModal.value = true;
}

function confirmDelete() {
    if (confirmationText.value === "DELETE") {
        Inertia.delete(route("admin.origin.delete", selectedOrigin.value.id));
        showDeleteModal.value = false;
    }
}
</script>

<template>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-white text-2xl font-bold">TFT Origins</h2>
        </div>
        <div class="flex space-x-4">
            <div class="relative">
                <select
                    v-model="selectedSeasonId"
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
                @click="openOriginForm()"
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div
            v-for="origin in filteredOrigins"
            :key="origin.id"
            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
        >
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold text-yellow-400">
                    {{ origin.name }}
                </h3>
                <span
                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                >
                    {{ origin.season.name }}
                </span>
            </div>
            <p class="text-white flex-grow mb-4">
                {{ origin.description }}
            </p>
            <div class="flex justify-end space-x-2 mt-auto">
                <button
                    @click="openOriginForm(origin)"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                    title="Edit origin"
                >
                    Edit
                </button>
                <button
                    @click="openDeleteOriginModal(origin)"
                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                    title="Delete class"
                >
                    Delete
                </button>
            </div>
        </div>

        <!-- Empty state for no origins -->
        <div
            v-if="filteredOrigins.length === 0"
            class="col-span-2 text-center py-10 bg-blue-800/40 rounded-lg"
        >
            <p class="text-blue-300 text-lg">
                No origins found for this season.
            </p>
            <button
                @click="openOriginForm()"
                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
            >
                Add your first origin
            </button>
        </div>
    </div>
    <teleport to="body">
        <div v-if="showOriginModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div
                    class="fixed inset-0 bg-black/70 transition-opacity"
                    @click="showOriginModal = false"
                ></div>

                <div
                    class="relative bg-blue-900 rounded-lg max-w-md w-full p-6 shadow-xl border border-blue-800"
                >
                    <h3 class="text-xl font-bold text-white mb-4">
                        {{ isEditing ? "Edit Origin" : "Add New Origin" }}
                    </h3>

                    <form
                        @submit.prevent="
                            originForm.put(route('admin.origin.upsert'));
                            showOriginModal = false;
                        "
                    >
                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-yellow-400 text-sm font-medium mb-1"
                                    >Name</label
                                >
                                <input
                                    v-model="originForm.name"
                                    type="text"
                                    class="w-full bg-blue-800 border border-blue-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    required
                                />
                            </div>
                            <div class="flex items-center">
                                <label
                                    class="block text-yellow-400 text-sm font-medium mb-1"
                                    >Technical Name</label
                                >
                                <input
                                    v-model="originForm.technical_name"
                                    type="text"
                                    class="w-full bg-blue-800 border border-blue-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    required
                                />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button
                                type="button"
                                @click="showOriginModal = false"
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
    </teleport>
    <teleport to="body">
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <!-- Overlay -->
                <div
                    class="fixed inset-0 bg-black/70 transition-opacity"
                    @click="showDeleteModal = false"
                ></div>

                <!-- Modal Content -->
                <div
                    class="relative bg-blue-900 rounded-lg max-w-md w-full p-6 shadow-xl border border-blue-800"
                >
                    <h2 class="text-xl font-bold text-white mb-4">
                        Confirm Deletion
                    </h2>

                    <h3 class="text-yellow-400 mb-2">
                        The origin will be deleted. Players history might be
                        impacted!
                    </h3>
                    <p class="text-white mb-4">
                        Confirm deletion by typing
                        <strong class="text-yellow-400">DELETE</strong> below:
                    </p>

                    <input
                        v-model="confirmationText"
                        type="text"
                        class="w-full bg-blue-800 border border-blue-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 mb-4"
                        placeholder="Type DELETE to confirm"
                    />

                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showDeleteModal = false"
                            class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors"
                        >
                            Cancel
                        </button>

                        <button
                            :disabled="confirmationText !== 'DELETE'"
                            @click="confirmDelete"
                            class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-bold px-4 py-2 rounded-lg transition-colors disabled:opacity-50"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
