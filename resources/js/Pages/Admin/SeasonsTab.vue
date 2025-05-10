<script setup>
import { defineProps, ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    seasons: Array,
});

const isEditing = ref(false);
const originallyActive = ref(false);
const showSeasonModal = ref(false);
const selectedSeason = ref(null);
const confirmationText = ref("");
const showDeleteModal = ref(false);

const seasonForm = useForm({
    id: null,
    name: "",
    active: false,
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

const canActivate = computed(() => {
    return !props.seasons.some((season) => season.active);
});

const isEditingCurrentActive = computed(() => {
    return isEditing.value && !!originallyActive.value;
});

function confirmDelete() {
    if (confirmationText.value === "DELETE") {
        router.delete(route("admin.season.delete", selectedSeason.value.id));
        showDeleteModal.value = false;
    }
}

const formatDate = (dateString) => {
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(dateString).toLocaleDateString("en-EN", options);
};
</script>

<template>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-white text-2xl font-bold">TFT Seasons</h2>
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
        <table class="min-w-full bg-blue-800/40 rounded-lg overflow-hidden">
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
                            @click="openDeleteSeasonModal(season)"
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
            <p class="text-blue-300 text-lg">No seasons found.</p>
            <button
                @click="openSeasonForm()"
                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
            >
                Add your first season
            </button>
        </div>
    </div>

    <!-- Season Modal -->
    <teleport to="body">
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
    </teleport>

    <!-- delete season modal -->
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
                        All the origins, classes and challenges related to this
                        season will be deleted!
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
