<script setup>
import { defineProps, ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";

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
        <div>
            <h2 class="text-primary-light text-2xl font-bold">TFT Seasons</h2>
            <p class="text-primary-light/70 text-sm">
                Manage game seasons and set active season
            </p>
        </div>
        <button
            @click="openSeasonForm()"
            class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold py-2.5 px-4 rounded-lg transition-all shadow-lg flex items-center"
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

    <div
        class="overflow-x-auto rounded-lg border-2 border-primary-blue/40 shadow-lg"
    >
        <table class="min-w-full bg-primary-dark">
            <thead>
                <tr
                    class="bg-primary-blue/20 border-b-2 border-primary-blue/40"
                >
                    <th
                        class="px-6 py-3.5 text-primary-first font-semibold uppercase tracking-wider text-sm text-left"
                    >
                        Name
                    </th>
                    <th
                        class="px-6 py-3.5 text-primary-first font-semibold uppercase tracking-wider text-sm text-left"
                    >
                        Creation Date
                    </th>
                    <th
                        class="px-6 py-3.5 text-primary-first font-semibold uppercase tracking-wider text-sm text-left"
                    >
                        Status
                    </th>
                    <th
                        class="px-6 py-3.5 text-primary-first font-semibold uppercase tracking-wider text-sm text-left"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-primary-blue/30">
                <tr
                    v-for="season in props.seasons"
                    :key="season.id"
                    class="hover:bg-primary-blue/10 transition-colors"
                >
                    <td class="px-6 py-4 text-primary-light font-medium">
                        {{ season.name }}
                    </td>
                    <td class="px-6 py-4 text-primary-light/80">
                        {{ formatDate(season.created_at) }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            v-if="season.active"
                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30"
                        >
                            Active
                        </span>
                        <span
                            v-else
                            class="px-3 py-1 rounded-full text-sm font-medium bg-primary-blue/20 text-primary-light border border-primary-blue/30"
                        >
                            Inactive
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <button
                            @click="openSeasonForm(season)"
                            class="bg-primary-blue hover:bg-primary-blue/80 text-primary-light px-4 py-1.5 rounded-md transition-colors"
                            title="Edit season"
                        >
                            Edit
                        </button>
                        <button
                            @click="openDeleteSeasonModal(season)"
                            class="bg-red-600 hover:bg-red-500 text-white px-4 py-1.5 rounded-md transition-colors"
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
            class="text-center py-12 bg-primary-dark"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-16 w-16 mx-auto text-primary-blue/60 mb-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                />
            </svg>
            <p class="text-primary-light/70 text-lg mb-4">No seasons found.</p>
            <button
                @click="openSeasonForm()"
                class="mt-2 bg-primary-first hover:bg-primary-first/90 text-primary-dark font-medium py-2 px-6 rounded-lg transition-colors shadow-lg"
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
                    class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"
                    @click="showSeasonModal = false"
                ></div>

                <div
                    class="relative bg-primary-dark rounded-lg max-w-md w-full p-6 shadow-xl border-2 border-primary-blue/60"
                >
                    <h3
                        class="text-xl font-bold text-primary-first mb-6 flex items-center"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-2 text-primary-first"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                        {{ isEditing ? "Edit Season" : "Add New Season" }}
                    </h3>

                    <form
                        @submit.prevent="
                            seasonForm.put(route('admin.season.upsert'));
                            showSeasonModal = false;
                        "
                    >
                        <div class="space-y-5">
                            <div>
                                <label
                                    class="block text-primary-first text-sm font-medium mb-2"
                                    >Season Name</label
                                >
                                <input
                                    v-model="seasonForm.name"
                                    type="text"
                                    class="w-full bg-primary-dark border-2 border-primary-blue/60 rounded-lg px-4 py-2.5 text-primary-light focus:outline-none focus:ring-2 focus:ring-primary-first"
                                    placeholder="e.g. Set 10: Remix Rumble"
                                    required
                                />
                            </div>
                            <div
                                class="flex items-center p-3 bg-primary-blue/10 rounded-lg border border-primary-blue/30"
                            >
                                <input
                                    id="active-checkbox"
                                    v-model="seasonForm.active"
                                    type="checkbox"
                                    :disabled="
                                        !seasonForm.active &&
                                        !canActivate &&
                                        !isEditingCurrentActive
                                    "
                                    class="h-5 w-5 text-primary-first focus:ring-primary-first border-primary-blue/60 rounded"
                                />
                                <label
                                    for="active-checkbox"
                                    class="ml-2 block text-primary-light"
                                >
                                    Set as active season
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-8">
                            <button
                                type="button"
                                @click="showSeasonModal = false"
                                class="bg-primary-dark hover:bg-primary-dark/80 border-2 border-primary-blue/60 text-primary-light px-5 py-2.5 rounded-lg transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold px-5 py-2.5 rounded-lg transition-colors shadow-md"
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
                    class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"
                    @click="showDeleteModal = false"
                ></div>

                <!-- Modal Content -->
                <div
                    class="relative bg-primary-dark rounded-lg max-w-md w-full p-6 shadow-xl border-2 border-primary-blue/60"
                >
                    <h2
                        class="text-xl font-bold text-primary-first mb-4 flex items-center"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-2 text-red-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                        Confirm Deletion
                    </h2>

                    <div
                        class="p-4 bg-red-500/10 border border-red-500/30 rounded-lg mb-4"
                    >
                        <h3 class="text-primary-first mb-2 font-medium">
                            Warning: This action cannot be undone
                        </h3>
                        <p class="text-primary-light/90 text-sm">
                            All the origins, classes and challenges related to
                            this season will be deleted!
                        </p>
                    </div>

                    <p class="text-primary-light mb-4">
                        Confirm deletion by typing
                        <strong class="text-primary-first">DELETE</strong>
                        below:
                    </p>

                    <input
                        v-model="confirmationText"
                        type="text"
                        class="w-full bg-primary-dark border-2 border-primary-blue/60 rounded-lg px-4 py-2.5 text-primary-light focus:outline-none focus:ring-2 focus:ring-primary-first mb-6"
                        placeholder="Type DELETE to confirm"
                    />

                    <div class="flex justify-end space-x-3">
                        <button
                            @click="showDeleteModal = false"
                            class="bg-primary-dark hover:bg-primary-dark/80 border-2 border-primary-blue/60 text-primary-light px-5 py-2.5 rounded-lg transition-colors"
                        >
                            Cancel
                        </button>

                        <button
                            :disabled="confirmationText !== 'DELETE'"
                            @click="confirmDelete"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold px-5 py-2.5 rounded-lg transition-colors disabled:opacity-50 shadow-md"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
