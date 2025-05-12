<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";

const props = defineProps({
    topPlayers: Array,
    userRanking: Object,
    auth: Object,
});

const isCurrentUser = (userId) => {
    return props.auth?.user?.id === userId;
};
</script>

<template>
    <AppLayout :show-background="true">
        <Head title="Leaderboard" />

        <main
            class="relative w-full flex-grow flex flex-col items-center py-8 px-4"
        >
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-6">
                <div class="p-2 mb-1">
                    <img
                        src="/storage/opTft.svg"
                        alt="TFT Logo"
                        class="w-16 h-auto"
                    />
                </div>
                <h1
                    class="text-4xl font-bold mb-1 text-primary-light font-parkinsans"
                >
                    LEADERBOARD
                </h1>
                <div class="w-64 h-1 bg-primary-first mb-4"></div>
                <p class="text-primary-light text-base mb-4">
                    The best players of TFT Operation
                </p>
            </div>

            <!-- User's Ranking Section -->
            <div
                v-if="userRanking"
                class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-3xl w-full mb-5 shadow-md border border-primary-blue/30 p-5"
            >
                <h2
                    class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                >
                    YOUR RANKING
                </h2>

                <div
                    class="flex flex-col md:flex-row items-center justify-between gap-4"
                >
                    <div class="flex items-center">
                        <div
                            class="bg-primary-first rounded-full p-3 mr-3 flex items-center justify-center w-10 h-10"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'trophy']"
                                class="text-primary-dark text-lg"
                            />
                        </div>
                        <div>
                            <div class="flex items-center">
                                <span
                                    class="bg-primary-dark/80 text-primary-light px-2 py-0.5 rounded text-sm mr-2"
                                >
                                    #{{ userRanking.rank }}
                                </span>
                                <h3
                                    class="text-primary-first text-lg font-bold"
                                >
                                    {{ userRanking.username }}
                                </h3>
                            </div>
                            <p class="text-primary-light/80 text-sm">
                                {{ userRanking.riot_username }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="bg-primary-dark/80 rounded-lg p-3 text-center border border-primary-blue/20 shadow-sm"
                    >
                        <div class="text-2xl font-bold text-primary-first mb-1">
                            {{ userRanking.score }}
                        </div>
                        <div class="text-xs text-primary-light/80">
                            Total score
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Section -->
            <div
                class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-3xl w-full mb-5 shadow-md border border-primary-blue/30 p-5"
            >
                <h2
                    class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                >
                    TOP 10 PLAYERS
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr
                                class="text-left border-b border-primary-blue/50"
                            >
                                <th class="p-2 text-primary-light text-sm">
                                    Rank
                                </th>
                                <th class="p-2 text-primary-light text-sm">
                                    Player
                                </th>
                                <th class="p-2 text-primary-light text-sm">
                                    Riot Name
                                </th>
                                <th
                                    class="p-2 text-primary-light text-sm text-right"
                                >
                                    Score
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(player, index) in topPlayers"
                                :key="player.id"
                                :class="[
                                    'border-b border-primary-blue/30 hover:bg-primary-dark/50 transition-colors cursor-pointer',
                                    isCurrentUser(player.id)
                                        ? 'bg-primary-dark/70'
                                        : '',
                                ]"
                                @click="
                                    $inertia.get(route('history', player.id))
                                "
                            >
                                <td class="p-2">
                                    <div class="flex items-center">
                                        <div
                                            class="rounded-full w-7 h-7 flex items-center justify-center mr-2"
                                            :class="[
                                                index === 0
                                                    ? 'bg-yellow-500 text-primary-dark'
                                                    : index === 1
                                                    ? 'bg-gray-300 text-primary-dark'
                                                    : index === 2
                                                    ? 'bg-amber-700 text-primary-light'
                                                    : 'bg-primary-dark text-primary-light',
                                            ]"
                                        >
                                            <font-awesome-icon
                                                :icon="
                                                    index < 3
                                                        ? ['fas', 'medal']
                                                        : ['fas', 'hashtag']
                                                "
                                                class="text-xs"
                                                v-if="index < 3"
                                            />
                                            <span
                                                class="text-xs font-bold"
                                                v-else
                                                >{{ index + 1 }}</span
                                            >
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2">
                                    <span
                                        class="font-medium text-sm"
                                        :class="
                                            isCurrentUser(player.id)
                                                ? 'text-primary-first'
                                                : 'text-primary-light'
                                        "
                                    >
                                        {{ player.username }}
                                        <span
                                            v-if="isCurrentUser(player.id)"
                                            class="text-xs ml-1 bg-primary-first/20 text-primary-first px-1 py-0.5 rounded"
                                            >You</span
                                        >
                                    </span>
                                </td>
                                <td class="p-2 text-primary-light/70 text-xs">
                                    {{ player.riot_username }}
                                </td>
                                <td
                                    class="p-2 text-right font-bold text-primary-first text-sm"
                                >
                                    {{ player.score }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    v-if="!topPlayers || topPlayers.length === 0"
                    class="text-center py-6"
                >
                    <p class="text-primary-light text-base">
                        <font-awesome-icon
                            :icon="['fas', 'info-circle']"
                            class="mr-2"
                        />
                        No players found.
                    </p>
                </div>
            </div>
        </main>
    </AppLayout>
</template>
