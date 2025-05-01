<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref, computed } from "vue";

const props = defineProps({
    user: Object,
    currentChallenge: Object,
    completedChallenges: Array,
});

// For pagination of completed challenges
const itemsPerPage = 5;
const currentPage = ref(1);

const paginatedChallenges = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.completedChallenges
        ? props.completedChallenges.slice(start, end)
        : [];
});

const totalPages = computed(() => {
    return props.completedChallenges
        ? Math.ceil(props.completedChallenges.length / itemsPerPage)
        : 0;
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

// Format date
const formatDate = (dateString) => {
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    };
    return new Date(dateString).toLocaleDateString("fr-FR", options);
};
</script>

<template>
    <AppLayout>
        <Head title="Historique - Opération TFT" />

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
                        HISTORIQUE
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                </div>

                <!-- User Profile Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        PROFIL JOUEUR
                    </h2>

                    <div
                        class="flex flex-col md:flex-row items-center md:items-start gap-8"
                    >
                        <!-- Avatar and Basic Info -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-blue-800 rounded-full p-1 border-4 border-yellow-500 mb-4"
                            >
                                <div
                                    class="bg-blue-700 rounded-full p-4 h-24 w-24 flex items-center justify-center"
                                >
                                    <img
                                        src="user?.profile_photo"
                                        class="text-4xl font-bold text-white"
                                    />
                                </div>
                            </div>
                            <h3 class="text-white text-xl font-bold">
                                {{ user.username }}
                            </h3>
                            <p class="text-blue-300">
                                {{ user.riot_username || "Non défini" }}
                            </p>
                        </div>

                        <!-- Stats -->
                        <div
                            class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-4"
                        >
                            <div
                                class="bg-blue-800/60 rounded-lg p-4 text-center"
                            >
                                <div class="text-3xl font-bold text-white mb-2">
                                    {{ user.score || 0 }}
                                </div>
                                <div class="text-sm text-blue-200">
                                    Challenges réussis
                                </div>
                            </div>

                            <div
                                class="bg-blue-800/60 rounded-lg p-4 text-center"
                            >
                                <div class="text-3xl font-bold text-white mb-2">
                                    {{ user.ranking || "N/A" }}
                                </div>
                                <div class="text-sm text-blue-200">
                                    Classement
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Challenge Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        DÉFI ACTUEL
                    </h2>

                    <div
                        v-if="currentChallenge"
                        class="bg-blue-800/60 rounded-lg p-6"
                    >
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3"
                                >
                                    <div class="text-white text-lg font-bold">
                                        P
                                    </div>
                                </div>
                                <span class="text-white"
                                    >Position:
                                    {{ currentChallenge.position.name }}</span
                                >
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3"
                                >
                                    <div class="text-white text-lg font-bold">
                                        C
                                    </div>
                                </div>
                                <span class="text-white"
                                    >Classe:
                                    {{ currentChallenge.classe.name }}</span
                                >
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3"
                                >
                                    <div class="text-white text-lg font-bold">
                                        O
                                    </div>
                                </div>
                                <span class="text-white"
                                    >Origine:
                                    {{ currentChallenge.origin.name }}</span
                                >
                            </div>

                            <div class="flex items-center">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3"
                                >
                                    <div class="text-white text-lg font-bold">
                                        C
                                    </div>
                                </div>
                                <span class="text-white"
                                    >Contrainte:
                                    {{ currentChallenge.constraint.name }}</span
                                >
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="bg-blue-800/60 rounded-lg p-6 text-center"
                    >
                        <p class="text-white text-lg mb-4">
                            Pas de défi en cours.
                        </p>
                    </div>
                </div>

                <!-- Completed Challenges Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        DÉFIS COMPLÉTÉS
                    </h2>

                    <div
                        v-if="
                            completedChallenges &&
                            completedChallenges.length > 0
                        "
                        class="space-y-4"
                    >
                        <div
                            v-for="challenge in paginatedChallenges"
                            :key="challenge.id"
                            class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                        >
                            <div
                                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-3"
                            >
                                <div class="text-blue-300 text-sm">
                                    {{ formatDate(challenge.updated_at) }}
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="bg-orange-500 rounded-full p-1.5 mr-2"
                                    >
                                        <div
                                            class="text-white text-sm font-bold"
                                        >
                                            P
                                        </div>
                                    </div>
                                    <span class="text-white text-sm">{{
                                        challenge.position.name
                                    }}</span>
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="bg-orange-500 rounded-full p-1.5 mr-2"
                                    >
                                        <div
                                            class="text-white text-sm font-bold"
                                        >
                                            C
                                        </div>
                                    </div>
                                    <span class="text-white text-sm">{{
                                        challenge.classe.name
                                    }}</span>
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="bg-orange-500 rounded-full p-1.5 mr-2"
                                    >
                                        <div
                                            class="text-white text-sm font-bold"
                                        >
                                            O
                                        </div>
                                    </div>
                                    <span class="text-white text-sm">{{
                                        challenge.origin.name
                                    }}</span>
                                </div>

                                <div class="flex items-center">
                                    <div
                                        class="bg-orange-500 rounded-full p-1.5 mr-2"
                                    >
                                        <div
                                            class="text-white text-sm font-bold"
                                        >
                                            C
                                        </div>
                                    </div>
                                    <span class="text-white text-sm">{{
                                        challenge.constraint.name
                                    }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div
                                        class="bg-green-500 rounded-full p-1 mr-2"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-white"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                    </div>
                                    <span class="text-green-400 text-sm"
                                        >Complété</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="totalPages > 1"
                            class="flex justify-center items-center mt-6 space-x-2"
                        >
                            <button
                                @click="prevPage"
                                :disabled="currentPage === 1"
                                class="bg-blue-700 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed text-white p-2 rounded-lg transition-colors"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>

                            <span class="text-white">
                                Page {{ currentPage }} sur {{ totalPages }}
                            </span>

                            <button
                                @click="nextPage"
                                :disabled="currentPage === totalPages"
                                class="bg-blue-700 hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed text-white p-2 rounded-lg transition-colors"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div
                        v-else
                        class="bg-blue-800/60 rounded-lg p-6 text-center"
                    >
                        <p class="text-white">Pas encore de défi complété.</p>
                    </div>
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
