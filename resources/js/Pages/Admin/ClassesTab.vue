<script setup>
import { defineProps, ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";

const props = defineProps({
    seasons: Array,
    classes: Array,
});

const isEditing = ref(false);
const showClasseModal = ref(false);
const showDeleteModal = ref(false);
const selectedClasse = ref(null);
const confirmationText = ref("");
const selectedSeasonId = ref(
    props.seasons.length > 0 ? props.seasons[0].id : null
);
const imagePreview = ref(null);

const classeForm = useForm({
    id: null,
    name: "",
    technical_name: "",
    season_id: selectedSeasonId,
    image: null,
    delete_image: false,
});

const filteredClasses = computed(() => {
    return props.classes.filter(
        (classe) => classe.season_id === selectedSeasonId.value
    );
});

const openClasseForm = (classe = null) => {
    isEditing.value = !!classe;

    if (classe) {
        classeForm.id = classe.id;
        classeForm.name = classe.name;
        classeForm.technical_name = classe.technical_name;
        classeForm.season_id = classe.season_id;
        classeForm.image = classe.image;
    } else {
        classeForm.id = null;
        classeForm.name = "";
        classeForm.technical_name = "";
        classeForm.season_id = selectedSeasonId;
        classeForm.image = null;
    }

    showClasseModal.value = true;
};

function openDeleteClasseModal(classe) {
    selectedClasse.value = classe;
    confirmationText.value = "";
    showDeleteModal.value = true;
}

function confirmDelete() {
    if (confirmationText.value === "DELETE") {
        router.delete(route("admin.classe.delete", selectedClasse.value.id));
        showDeleteModal.value = false;
    }
}

function onImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        classeForm.image = file;
        imagePreview.value = URL.createObjectURL(file);
        classeForm.delete_image = false;
    }
}

function deleteImage() {
    classeForm.delete_image = true;
    classeForm.image = null;
    imagePreview.value = null;
}
</script>

<template>
    <div>
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4"
        >
            <div>
                <h2 class="text-primary-light text-2xl font-bold">
                    TFT Classes
                </h2>
                <p class="text-primary-light/70 text-sm">
                    Manage classes for different seasons
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative">
                    <select
                        v-model="selectedSeasonId"
                        class="w-full sm:w-auto bg-primary-dark border-2 border-primary-blue rounded-lg px-4 py-2.5 appearance-none pr-10 focus:outline-none focus:ring-2 focus:ring-primary-first text-primary-light"
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
                            class="w-5 h-5 text-primary-first"
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
                    @click="openClasseForm()"
                    class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold py-2.5 px-4 rounded-lg transition-all shadow-lg flex items-center justify-center"
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

        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
            <div
                v-for="classe in filteredClasses"
                :key="classe.id"
                class="bg-primary-dark border-2 border-primary-blue/40 hover:border-primary-blue rounded-lg overflow-hidden shadow-lg flex flex-col h-full transition-all"
            >
                <div class="p-5">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-primary-first">
                            {{ classe.name }}
                        </h3>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium bg-primary-blue/30 text-primary-light"
                        >
                            {{ classe.season.name }}
                        </span>
                    </div>
                    <p class="text-primary-light/90 flex-grow mb-4">
                        {{ classe.description }}
                    </p>

                    <!-- Icon displayed smaller and centered -->
                    <div v-if="classe.image" class="flex justify-center mb-4">
                        <div
                            class="bg-primary-blue/20 p-2 rounded-lg border border-primary-blue/40"
                        >
                            <img
                                :src="`/storage/${classe.image}`"
                                alt="Class Icon"
                                class="w-16 h-16 object-contain"
                            />
                        </div>
                    </div>
                </div>

                <div
                    class="p-4 mt-auto bg-primary-blue/20 border-t border-primary-blue/40"
                >
                    <div class="flex justify-end space-x-2">
                        <button
                            @click="openClasseForm(classe)"
                            class="bg-primary-blue hover:bg-primary-blue/80 text-primary-light px-4 py-1.5 rounded-md transition-colors"
                            title="Edit class"
                        >
                            Edit
                        </button>
                        <button
                            @click="openDeleteClasseModal(classe)"
                            class="bg-red-600 hover:bg-red-500 text-white px-4 py-1.5 rounded-md transition-colors"
                            title="Delete class"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty state for no classes -->
            <div
                v-if="filteredClasses.length === 0"
                class="col-span-full text-center py-12 bg-primary-dark border-2 border-primary-blue/40 rounded-lg"
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
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                    />
                </svg>
                <p class="text-primary-light/70 text-lg mb-4">
                    No classes found for this season.
                </p>
                <button
                    @click="openClasseForm()"
                    class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-medium py-2 px-6 rounded-lg transition-colors shadow-lg"
                >
                    Add your first class
                </button>
            </div>
        </div>
    </div>

    <!-- Class Modal -->
    <teleport to="body">
        <div v-if="showClasseModal" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div
                    class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity"
                    @click="showClasseModal = false"
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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            />
                        </svg>
                        {{ isEditing ? "Edit Class" : "Add New Class" }}
                    </h3>

                    <form
                        @submit.prevent="
                            classeForm.post(route('admin.classe.upsert'), {
                                forceFormData: true,
                                onSuccess: () => {
                                    showClasseModal = false;
                                },
                            })
                        "
                    >
                        <div class="space-y-5">
                            <div>
                                <label
                                    class="block text-primary-first text-sm font-medium mb-2"
                                    >Name</label
                                >
                                <input
                                    v-model="classeForm.name"
                                    type="text"
                                    class="w-full bg-primary-dark border-2 border-primary-blue/60 rounded-lg px-4 py-2.5 text-primary-light focus:outline-none focus:ring-2 focus:ring-primary-first"
                                    required
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-primary-first text-sm font-medium mb-2"
                                    >Technical Name</label
                                >
                                <input
                                    v-model="classeForm.technical_name"
                                    type="text"
                                    class="w-full bg-primary-dark border-2 border-primary-blue/60 rounded-lg px-4 py-2.5 text-primary-light focus:outline-none focus:ring-2 focus:ring-primary-first"
                                    required
                                />
                            </div>
                            <div>
                                <label
                                    class="block text-primary-first text-sm font-medium mb-2"
                                    >Icon</label
                                >
                                <input
                                    type="file"
                                    @change="onImageChange"
                                    accept="image/*"
                                    class="w-full bg-primary-dark border-2 border-primary-blue/60 rounded-lg px-4 py-2.5 text-primary-light focus:outline-none focus:ring-2 focus:ring-primary-first"
                                />

                                <!-- Preview for new image -->
                                <div
                                    v-if="imagePreview"
                                    class="mt-3 p-3 bg-primary-blue/10 rounded-lg border border-primary-blue/40"
                                >
                                    <p class="text-primary-first text-sm mb-2">
                                        New icon:
                                    </p>
                                    <div class="flex items-center">
                                        <div
                                            class="bg-primary-blue/20 p-2 rounded-lg border border-primary-blue/40"
                                        >
                                            <img
                                                :src="imagePreview"
                                                class="w-16 h-16 object-contain"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="deleteImage"
                                            class="ml-3 text-red-400 hover:text-red-300 text-sm flex items-center"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1"
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
                                            Remove icon
                                        </button>
                                    </div>
                                </div>

                                <!-- Preview for existing image -->
                                <div
                                    v-else-if="
                                        classeForm.image &&
                                        !classeForm.delete_image
                                    "
                                    class="mt-3 p-3 bg-primary-blue/10 rounded-lg border border-primary-blue/40"
                                >
                                    <p class="text-primary-first text-sm mb-2">
                                        Current icon:
                                    </p>
                                    <div class="flex items-center">
                                        <div
                                            class="bg-primary-blue/20 p-2 rounded-lg border border-primary-blue/40"
                                        >
                                            <img
                                                :src="`/storage/${classeForm.image}`"
                                                class="w-16 h-16 object-contain"
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            @click="deleteImage"
                                            class="ml-3 text-red-400 hover:text-red-300 text-sm flex items-center"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 mr-1"
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
                                            Remove icon
                                        </button>
                                    </div>
                                </div>

                                <input
                                    type="hidden"
                                    name="delete_image"
                                    :value="classeForm.delete_image ? 1 : 0"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-8">
                            <button
                                type="button"
                                @click="showClasseModal = false"
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

    <!-- Delete Modal -->
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
                            The class will be permanently deleted. Players
                            history might be impacted!
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
