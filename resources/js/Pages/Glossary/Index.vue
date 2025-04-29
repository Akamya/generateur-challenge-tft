<script setup>
import { ref, defineProps } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: Object,
    origins: Array,
    positions: Array,
    classes: Array,
    constraints: Array,
});

// Active category state
const activeCategory = ref("origins"); // Default to origins tab

// Function to change active category
const setActiveCategory = (category) => {
    activeCategory.value = category;
};

// Search functionality
const searchQuery = ref("");
const filteredItems = (items) => {
    if (!searchQuery.value) return items;
    return items.filter(
        (item) =>
            item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (item.description &&
                item.description
                    .toLowerCase()
                    .includes(searchQuery.value.toLowerCase()))
    );
};
</script>

<template>
    <AppLayout>
        <Head title="Glossaire - Opération TFT" />

        <div class="min-h-screen flex flex-col relative overflow-hidden">
            <!-- Background image -->
            <div class="absolute inset-0 z-0">
                <img
                    src="/storage/tft-wallpaper.jpg"
                    alt="TFT Background"
                    class="w-full h-full object-cover opacity-100"
                />
                <div class="absolute inset-0 bg-blue-900/70"></div>
            </div>

            <!-- Main Content -->
            <main
                class="relative flex-grow flex flex-col items-center py-12 px-4"
            >
                <!-- Logo and Title -->
                <div class="flex flex-col items-center mb-8">
                    <div
                        class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6"
                    >
                        <img
                            src="/placeholder.svg"
                            alt="TFT Logo"
                            class="h-16 w-16"
                        />
                    </div>
                    <h1 class="text-white text-5xl font-bold mb-2">
                        GLOSSAIRE TFT
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                    <p class="text-white text-xl mb-6">
                        Toutes les informations sur les origines, positions,
                        classes et contraintes
                    </p>
                </div>

                <!-- Category Navigation -->
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <button
                        @click="setActiveCategory('origins')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'origins'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Origines
                    </button>
                    <button
                        @click="setActiveCategory('positions')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'positions'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Positions
                    </button>
                    <button
                        @click="setActiveCategory('classes')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'classes'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Classes
                    </button>
                    <button
                        @click="setActiveCategory('constraints')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'constraints'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Contraintes
                    </button>
                </div>

                <!-- Search Bar -->
                <div class="w-full max-w-md mb-8">
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Rechercher..."
                            class="w-full px-4 py-2 bg-blue-900/60 border border-blue-700 rounded-full text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        />
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-blue-300"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full">
                    <!-- Origins Content -->
                    <div v-if="activeCategory === 'origins'" class="space-y-6">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            ORIGINES
                        </h2>

                        <div
                            v-if="props.origins && props.origins.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        >
                            <div
                                v-for="origin in filteredItems(props.origins)"
                                :key="origin.id"
                                class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ origin.name }}
                                    </h3>
                                </div>
                                <p class="text-white text-sm ml-12">
                                    {{ origin.description }}
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-center text-white">
                            Aucune origine trouvée.
                        </div>
                    </div>

                    <!-- Positions Content -->
                    <div
                        v-if="activeCategory === 'positions'"
                        class="space-y-6"
                    >
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            POSITIONS
                        </h2>

                        <div
                            v-if="props.positions && props.positions.length > 0"
                            class="space-y-8"
                        >
                            <div
                                v-for="position in filteredItems(
                                    props.positions
                                )"
                                :key="position.id"
                                class="bg-blue-800/60 rounded-lg p-6 hover:bg-blue-800/80 transition-colors"
                            >
                                <div
                                    class="flex flex-col md:flex-row md:items-center gap-4"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="bg-orange-500 rounded-full p-3 mr-3"
                                        >
                                            <div
                                                class="text-white text-xl font-bold"
                                            >
                                                ★
                                            </div>
                                        </div>
                                        <h3
                                            class="text-white text-xl font-bold"
                                        >
                                            {{ position.name }}
                                        </h3>
                                    </div>

                                    <div
                                        v-if="position.image_url"
                                        class="md:ml-auto"
                                    >
                                        <img
                                            :src="position.image_url"
                                            :alt="position.name"
                                            class="h-24 w-24 object-cover rounded-lg border-2 border-yellow-500"
                                        />
                                    </div>
                                </div>

                                <p class="text-white mt-4">
                                    {{ position.description }}
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-center text-white">
                            Aucune position trouvée.
                        </div>
                    </div>

                    <!-- Classes Content -->
                    <div v-if="activeCategory === 'classes'" class="space-y-6">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            CLASSES
                        </h2>

                        <div
                            v-if="props.classes && props.classes.length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        >
                            <div
                                v-for="classe in filteredItems(props.classes)"
                                :key="classe.id"
                                class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ classe.name }}
                                    </h3>
                                </div>
                                <p class="text-white text-sm ml-12">
                                    {{ classe.description }}
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-center text-white">
                            Aucune classe trouvée.
                        </div>
                    </div>

                    <!-- Constraints Content -->
                    <div
                        v-if="activeCategory === 'constraints'"
                        class="space-y-6"
                    >
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            CONTRAINTES
                        </h2>

                        <div
                            v-if="
                                props.constraints &&
                                props.constraints.length > 0
                            "
                            class="space-y-6"
                        >
                            <div
                                v-for="constraint in filteredItems(
                                    props.constraints
                                )"
                                :key="constraint.id"
                                class="bg-blue-800/60 rounded-lg p-6 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-4">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ constraint.name }}
                                    </h3>
                                </div>
                                <p class="text-white ml-12">
                                    {{ constraint.description }}
                                </p>
                            </div>
                        </div>
                        <div v-else class="text-center text-white">
                            Aucune contrainte trouvée.
                        </div>
                    </div>
                </div>

                <!-- Back to Home Button -->
                <div class="mt-8">
                    <Link
                        :href="route('homepage')"
                        class="bg-blue-900/60 hover:bg-blue-900/80 text-white font-bold py-2 px-6 rounded-full flex items-center transition-colors"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Retour à l'accueil
                    </Link>
                </div>
            </main>

            <!-- Footer -->
            <footer class="relative z-10 bg-blue-950/80 py-6 px-4 text-center">
                <div class="container mx-auto">
                    <div class="flex justify-center mb-2">
                        <img
                            src="/placeholder.svg"
                            alt="TFT Logo"
                            class="h-8 w-8 mr-2"
                        />
                        <span class="text-white font-bold">OPÉRATION TFT</span>
                    </div>
                    <p class="text-white text-sm">
                        © Opération TFT. All rights reserved. By Elodie Langlet.
                    </p>
                </div>
            </footer>
        </div>
    </AppLayout>
</template>
