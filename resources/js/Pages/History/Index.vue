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
        <Head title="History" />

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
                <div class="flex flex-col items-center mb-10">
                    <div
                        class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6 shadow-lg shadow-blue-900/50"
                    >
                        <img
                            src="/placeholder.svg"
                            alt="TFT Logo"
                            class="h-16 w-16"
                        />
                    </div>
                    <h1
                        class="text-white text-5xl font-bold mb-2 tracking-wider"
                    >
                        HISTORY
                    </h1>
                    <div
                        class="w-64 h-1 bg-gradient-to-r from-yellow-500 via-yellow-400 to-yellow-500 mb-6 rounded-full"
                    ></div>
                </div>

                <!-- User Profile Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        PLAYER PROFILE
                    </h2>

                    <div
                        class="flex flex-col md:flex-row items-center md:items-start gap-8"
                    >
                        <!-- Avatar and Basic Info -->
                        <div class="flex flex-col items-center">
                            <div
                                class="bg-blue-800 rounded-full p-1 border-4 border-yellow-500 mb-4 shadow-lg"
                            >
                                <div
                                    class="bg-gradient-to-br from-blue-700 to-blue-900 rounded-full p-4 h-24 w-24 flex items-center justify-center"
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
                                {{ user.riot_username }}
                            </p>
                        </div>

                        <!-- Stats -->
                        <div
                            class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-4"
                        >
                            <div
                                class="bg-gradient-to-br from-blue-800/80 to-blue-900/80 rounded-lg p-6 text-center shadow-md"
                            >
                                <div class="text-3xl font-bold text-white mb-2">
                                    {{ user.score || 0 }}
                                </div>
                                <div
                                    class="text-sm text-blue-200 uppercase tracking-wider"
                                >
                                    Completed challenges
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-br from-blue-800/80 to-blue-900/80 rounded-lg p-6 text-center shadow-md"
                            >
                                <div class="text-3xl font-bold text-white mb-2">
                                    {{ user.ranking || "N/A" }}
                                </div>
                                <div
                                    class="text-sm text-blue-200 uppercase tracking-wider"
                                >
                                    Ranking
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Challenge Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        CURRENT CHALLENGE
                    </h2>

                    <div
                        v-if="currentChallenge"
                        class="bg-gradient-to-br from-blue-800/60 to-blue-900/60 rounded-lg p-6 shadow-md"
                    >
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div
                                class="flex items-center bg-blue-800/40 p-4 rounded-lg"
                            >
                                <div
                                    class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-3 mr-4 shadow-md"
                                >
                                    <div class="text-white text-lg font-bold">
                                        P
                                    </div>
                                </div>
                                <span class="text-white font-medium"
                                    >Position:
                                    <span class="text-yellow-300">{{
                                        currentChallenge.position.name
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-blue-800/40 p-4 rounded-lg"
                            >
                                <div
                                    class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-3 mr-4 shadow-md"
                                >
                                    <div class="text-white text-lg font-bold">
                                        C
                                    </div>
                                </div>
                                <span class="text-white font-medium"
                                    >Class:
                                    <span class="text-yellow-300">{{
                                        currentChallenge.classe.name
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-blue-800/40 p-4 rounded-lg"
                            >
                                <div
                                    class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-3 mr-4 shadow-md"
                                >
                                    <div class="text-white text-lg font-bold">
                                        O
                                    </div>
                                </div>
                                <span class="text-white font-medium"
                                    >Origin:
                                    <span class="text-yellow-300">{{
                                        currentChallenge.origin.name
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-blue-800/40 p-4 rounded-lg"
                            >
                                <div
                                    class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-3 mr-4 shadow-md"
                                >
                                    <div class="text-white text-lg font-bold">
                                        C
                                    </div>
                                </div>
                                <span class="text-white font-medium"
                                    >Constraint:
                                    <span class="text-yellow-300">{{
                                        currentChallenge.constraint.name
                                    }}</span></span
                                >
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="bg-gradient-to-br from-blue-800/60 to-blue-900/60 rounded-lg p-8 text-center shadow-md"
                    >
                        <p class="text-white text-lg mb-4">
                            No challenge in progress.
                        </p>
                    </div>
                </div>

                <!-- Completed Challenges Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        COMPLETED CHALLENGES
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
                            class="bg-gradient-to-br from-blue-800/60 to-blue-900/60 rounded-lg p-5 shadow-md border border-blue-700/30"
                        >
                            <div
                                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 border-b border-blue-700/50 pb-2"
                            >
                                <div
                                    class="text-yellow-300 text-sm font-medium"
                                >
                                    {{ formatDate(challenge.updated_at) }}
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4"
                            >
                                <div
                                    class="flex items-center bg-blue-800/40 p-3 rounded-lg"
                                >
                                    <div
                                        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-2 mr-3 shadow-sm"
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

                                <div
                                    class="flex items-center bg-blue-800/40 p-3 rounded-lg"
                                >
                                    <div
                                        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-2 mr-3 shadow-sm"
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

                                <div
                                    class="flex items-center bg-blue-800/40 p-3 rounded-lg"
                                >
                                    <div
                                        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-2 mr-3 shadow-sm"
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

                                <div
                                    class="flex items-center bg-blue-800/40 p-3 rounded-lg"
                                >
                                    <div
                                        class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-2 mr-3 shadow-sm"
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

                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-2 border-t border-blue-700/50"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-1 mr-2 shadow-sm"
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
                                    <span
                                        class="text-green-400 text-sm font-medium"
                                        >Completed</span
                                    >
                                </div>

                                <!-- View Match button - kept hover effect since it's interactive -->
                                <a
                                    :href="
                                        'https://www.metatft.com/player/euw/' +
                                        user.riot_username +
                                        '-EUW?match=' +
                                        challenge.match_id
                                    "
                                    target="_blank"
                                    class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold py-2 px-5 rounded-full flex items-center transition-colors shadow-md"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 mr-2"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    View Match
                                </a>
                            </div>
                        </div>

                        <!-- Pagination - kept hover effect since it's interactive -->
                        <div
                            v-if="totalPages > 1"
                            class="flex justify-center items-center mt-8 space-x-4"
                        >
                            <button
                                @click="prevPage"
                                :disabled="currentPage === 1"
                                class="bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-600 hover:to-blue-500 disabled:opacity-50 disabled:cursor-not-allowed text-white p-3 rounded-lg transition-colors shadow-md flex items-center"
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

                            <span
                                class="text-white bg-blue-900/60 px-4 py-2 rounded-lg"
                            >
                                Page {{ currentPage }} of {{ totalPages }}
                            </span>

                            <button
                                @click="nextPage"
                                :disabled="currentPage === totalPages"
                                class="bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-600 hover:to-blue-500 disabled:opacity-50 disabled:cursor-not-allowed text-white p-3 rounded-lg transition-colors shadow-md flex items-center"
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
                        class="bg-gradient-to-br from-blue-800/60 to-blue-900/60 rounded-lg p-8 text-center shadow-md"
                    >
                        <p class="text-white">No challenge completed yet.</p>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
