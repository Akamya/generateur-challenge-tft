<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref } from "vue";

const props = defineProps({
    topPlayers: Array,
    userRanking: Object,
    auth: Object,
});

// For highlighting the current user in the leaderboard
const isCurrentUser = (userId) => {
    return props.auth?.user?.id === userId;
};
</script>

<template>
    <AppLayout>
        <Head title="Classement - Opération TFT" />

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
                        CLASSEMENT
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                    <p class="text-white text-xl mb-6">
                        Les meilleurs joueurs d'Opération TFT
                    </p>
                </div>

                <!-- User's Ranking Section -->
                <div
                    v-if="userRanking"
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        VOTRE CLASSEMENT
                    </h2>

                    <div
                        class="flex flex-col md:flex-row items-center justify-between gap-6"
                    >
                        <div class="flex items-center">
                            <div class="bg-yellow-500 rounded-full p-4 mr-4">
                                <span
                                    class="text-blue-900 text-2xl font-bold"
                                    >{{ userRanking.rank }}</span
                                >
                            </div>
                            <div>
                                <h3 class="text-white text-xl font-bold">
                                    {{ userRanking.username }}
                                </h3>
                                <p class="text-blue-300">
                                    {{ userRanking.riot_username }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-blue-800/60 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-white mb-2">
                                {{ userRanking.score }}
                            </div>
                            <div class="text-sm text-blue-200">Score total</div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Section -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        TOP 10 JOUEURS
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left border-b border-blue-700">
                                    <th class="p-3 text-white">Rang</th>
                                    <th class="p-3 text-white">Joueur</th>
                                    <th class="p-3 text-white">Nom Riot</th>
                                    <th class="p-3 text-white text-right">
                                        Score
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(player, index) in topPlayers"
                                    :key="player.id"
                                    :class="[
                                        'border-b border-blue-700/50 hover:bg-blue-800/40 transition-colors cursor-pointer',
                                        isCurrentUser(player.id)
                                            ? 'bg-blue-700/50'
                                            : '',
                                    ]"
                                    @click="
                                        $inertia.get(
                                            route('history', player.id)
                                        )
                                    "
                                >
                                    <td class="p-3">
                                        <div class="flex items-center">
                                            <div
                                                class="rounded-full w-8 h-8 flex items-center justify-center mr-2"
                                                :class="[
                                                    index === 0
                                                        ? 'bg-yellow-500 text-blue-900'
                                                        : index === 1
                                                        ? 'bg-gray-300 text-blue-900'
                                                        : index === 2
                                                        ? 'bg-amber-700 text-white'
                                                        : 'bg-blue-700 text-white',
                                                ]"
                                            >
                                                <span class="font-bold">{{
                                                    index + 1
                                                }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span
                                            class="font-medium"
                                            :class="
                                                isCurrentUser(player.id)
                                                    ? 'text-yellow-400'
                                                    : 'text-white'
                                            "
                                        >
                                            {{ player.username }}
                                            <span
                                                v-if="isCurrentUser(player.id)"
                                                class="text-xs ml-2"
                                                >(You)</span
                                            >
                                        </span>
                                    </td>
                                    <td class="p-3 text-blue-300">
                                        {{ player.riot_username }}
                                    </td>
                                    <td
                                        class="p-3 text-right font-bold text-white"
                                    >
                                        {{ player.score }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div
                        v-if="!topPlayers || topPlayers.length === 0"
                        class="text-center py-8"
                    >
                        <p class="text-white text-lg">No players found.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        @click="$inertia.get(route('history', auth.user.id))"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        Mon historique
                    </button>
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
