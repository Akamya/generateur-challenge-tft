<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref, computed, watch } from "vue";

const props = defineProps({
    user: Object,
    currentChallenge: Object,
    completedChallenges: Array,
    seasons: Array,
    classes: Array,
    origins: Array,
    constraints: Array,
    positions: Array,
});

const filters = ref({
    season_id:
        props.seasons.find((season) => !!season.active)?.id ||
        props.seasons[0]?.id,
    position_id: "",
    constraint_id: "",
    classe_id: "",
    origin_id: "",
});

// For pagination of completed challenges
const itemsPerPage = 5;
const currentPage = ref(1);

// reset pagination if filters change
watch(
    () => ({ ...filters.value }),
    () => {
        currentPage.value = 1;
    },
    { deep: true }
);

const totalPages = computed(() => {
    return Math.ceil(filteredChallenges.value.length / itemsPerPage);
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
    return new Date(dateString).toLocaleDateString("en-EN", options);
};

const filteredOrigins = computed(() => {
    return props.origins.filter(
        (origin) => origin.season_id === filters.value.season_id
    );
});

const filteredClasses = computed(() => {
    return props.classes.filter(
        (classe) => classe.season_id === filters.value.season_id
    );
});

const filteredChallenges = computed(() => {
    return props.completedChallenges.filter((challenge) => {
        return (
            (!filters.value.season_id ||
                challenge.season_id === filters.value.season_id) &&
            (!filters.value.position_id ||
                challenge.position_id === filters.value.position_id) &&
            (!filters.value.constraint_id ||
                challenge.constraint_id === filters.value.constraint_id) &&
            (!filters.value.classe_id ||
                challenge.classe_id === filters.value.classe_id) &&
            (!filters.value.origin_id ||
                challenge.origin_id === filters.value.origin_id)
        );
    });
});

const paginatedChallenges = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredChallenges.value.slice(start, end);
});
</script>

<template>
    <AppLayout :show-background="false">
        <Head title="History" />

        <div class="min-h-screen flex flex-col relative overflow-hidden">
            <!-- Main Content -->
            <main
                class="relative flex-grow flex flex-col items-center py-8 px-4"
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
                        class="text-4xl font-bold mb-1 text-primary-light font-parkinsans tracking-wider"
                    >
                        HISTORY
                    </h1>
                    <div
                        class="w-48 h-1 bg-gradient-to-r from-primary-first via-primary-first/80 to-primary-first mb-4 rounded-full"
                    ></div>
                </div>

                <!-- User Profile Section -->
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-3xl w-full mb-5 shadow-md border border-primary-blue/30 p-5"
                >
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        PLAYER PROFILE
                    </h2>

                    <div
                        class="flex flex-col md:flex-row items-center md:items-start gap-5"
                    >
                        <!-- Avatar and Basic Info -->
                        <div class="flex flex-col items-center">
                            <div class="relative w-20 h-20 mb-3">
                                <div
                                    class="absolute inset-0 rounded-full border-3 border-primary-first shadow-lg"
                                ></div>
                                <div
                                    class="absolute inset-0 rounded-full bg-gradient-to-br bg-primary-blue transform scale-95"
                                ></div>
                                <div
                                    class="absolute inset-0 rounded-full overflow-hidden transform scale-90"
                                >
                                    <img
                                        :src="
                                            user?.profile_photo
                                                ? `/storage/${user.profile_photo}`
                                                : '/storage/seed/default-avatar.svg'
                                        "
                                        alt="Profile picture"
                                        class="w-full h-full"
                                        :class="{
                                            'object-cover': user?.profile_photo,
                                            invert: !user?.profile_photo,
                                        }"
                                    />
                                </div>
                            </div>
                            <h3 class="text-primary-light text-lg font-bold">
                                {{ user.username }}
                            </h3>
                            <p class="text-primary-light/70 text-xs">
                                {{ user.riot_username }}
                            </p>
                        </div>

                        <!-- Stats -->
                        <div
                            class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-3"
                        >
                            <div
                                class="bg-primary-dark/80 rounded-lg p-4 text-center shadow-sm border border-primary-blue/20"
                            >
                                <div
                                    class="text-2xl font-bold text-primary-first mb-1"
                                >
                                    {{ user.score || 0 }}
                                </div>
                                <div
                                    class="text-xs text-primary-light/80 uppercase tracking-wider"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'trophy']"
                                        class="mr-1"
                                    />
                                    Completed challenges
                                </div>
                            </div>

                            <div
                                class="bg-primary-dark/80 rounded-lg p-4 text-center shadow-sm border border-primary-blue/20"
                            >
                                <div
                                    class="text-2xl font-bold text-primary-first mb-1"
                                >
                                    {{ user.ranking || "N/A" }}
                                </div>
                                <div
                                    class="text-xs text-primary-light/80 uppercase tracking-wider"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'medal']"
                                        class="mr-1"
                                    />
                                    Ranking
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Challenge Section -->
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-3xl w-full mb-5 shadow-md border border-primary-blue/30 p-5"
                >
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        CURRENT CHALLENGE
                    </h2>

                    <div
                        v-if="currentChallenge"
                        class="bg-primary-dark/80 rounded-lg p-4 shadow-sm border border-primary-blue/20"
                    >
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-2">
                            <div
                                class="flex items-center bg-primary-blue/30 p-3 rounded-lg"
                            >
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'ranking-star']"
                                        class="text-primary-dark text-sm"
                                    />
                                </div>
                                <span
                                    class="text-primary-light text-sm font-medium"
                                    >Position:
                                    <span class="text-primary-first">{{
                                        currentChallenge.position.value
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-primary-blue/30 p-3 rounded-lg"
                            >
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="
                                            currentChallenge.classe?.image
                                                ? `/storage/${currentChallenge.classe.image}`
                                                : '/storage/seed/default-classe.svg'
                                        "
                                        class="invert"
                                    />
                                </div>
                                <span
                                    class="text-primary-light text-sm font-medium"
                                    >Class:
                                    <span class="text-primary-first">{{
                                        currentChallenge.classe.name
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-primary-blue/30 p-3 rounded-lg"
                            >
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="
                                            currentChallenge.origin?.image
                                                ? `/storage/${currentChallenge.origin.image}`
                                                : '/storage/seed/default-origin.svg'
                                        "
                                        class="invert"
                                    />
                                </div>
                                <span
                                    class="text-primary-light text-sm font-medium"
                                    >Origin:
                                    <span class="text-primary-first">{{
                                        currentChallenge.origin.name
                                    }}</span></span
                                >
                            </div>

                            <div
                                class="flex items-center bg-primary-blue/30 p-3 rounded-lg"
                            >
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="`/storage/${currentChallenge.constraint.image}`"
                                    />
                                </div>
                                <span
                                    class="text-primary-light text-sm font-medium"
                                    >Constraint:
                                    <span class="text-primary-first">{{
                                        currentChallenge.constraint.name
                                    }}</span></span
                                >
                            </div>
                        </div>
                    </div>

                    <div
                        v-else
                        class="bg-primary-dark/80 rounded-lg p-5 text-center shadow-sm border border-primary-blue/20"
                    >
                        <p class="text-primary-light text-base">
                            <font-awesome-icon
                                :icon="['fas', 'info-circle']"
                                class="mr-2"
                            />
                            No challenge in progress.
                        </p>
                    </div>
                </div>

                <!-- Completed Challenges Section -->
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-3xl w-full mb-5 shadow-md border border-primary-blue/30 p-5"
                >
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        COMPLETED CHALLENGES
                    </h2>

                    <div
                        class="flex flex-wrap items-center gap-2 mb-4 justify-center"
                    >
                        <!-- Saison -->
                        <div>
                            <label
                                class="text-primary-first text-xs font-medium"
                                >Season</label
                            >
                            <select
                                v-model="filters.season_id"
                                class="mt-1 block w-full rounded-md border-primary-blue/30 bg-primary-dark/80 text-primary-light text-sm shadow-sm focus:border-primary-first focus:ring focus:ring-primary-first/30"
                            >
                                <option
                                    v-for="season in seasons"
                                    :key="season.id"
                                    :value="season.id"
                                >
                                    {{ season.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="text-primary-first text-xs font-medium"
                                >Position</label
                            >
                            <select
                                v-model="filters.position_id"
                                class="mt-1 block w-full rounded-md border-primary-blue/30 bg-primary-dark/80 text-primary-light text-sm shadow-sm focus:border-primary-first focus:ring focus:ring-primary-first/30"
                            >
                                <option value="">All</option>
                                <option
                                    v-for="position in positions"
                                    :key="position.id"
                                    :value="position.id"
                                >
                                    {{ position.value }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="text-primary-first text-xs font-medium"
                                >Constraint</label
                            >
                            <select
                                v-model="filters.constraint_id"
                                class="mt-1 block w-full rounded-md border-primary-blue/30 bg-primary-dark/80 text-primary-light text-sm shadow-sm focus:border-primary-first focus:ring focus:ring-primary-first/30"
                            >
                                <option value="">All</option>
                                <option
                                    v-for="constraint in constraints"
                                    :key="constraint.id"
                                    :value="constraint.id"
                                >
                                    {{ constraint.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="text-primary-first text-xs font-medium"
                                >Class</label
                            >
                            <select
                                v-model="filters.classe_id"
                                class="mt-1 block w-full rounded-md border-primary-blue/30 bg-primary-dark/80 text-primary-light text-sm shadow-sm focus:border-primary-first focus:ring focus:ring-primary-first/30"
                            >
                                <option value="">All</option>
                                <option
                                    v-for="classe in filteredClasses"
                                    :key="classe.id"
                                    :value="classe.id"
                                >
                                    {{ classe.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="text-primary-first text-xs font-medium"
                                >Origin</label
                            >
                            <select
                                v-model="filters.origin_id"
                                class="mt-1 block w-full rounded-md border-primary-blue/30 bg-primary-dark/80 text-primary-light text-sm shadow-sm focus:border-primary-first focus:ring focus:ring-primary-first/30"
                            >
                                <option value="">All</option>
                                <option
                                    v-for="origin in filteredOrigins"
                                    :key="origin.id"
                                    :value="origin.id"
                                >
                                    {{ origin.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div
                        v-if="
                            filteredChallenges && filteredChallenges.length > 0
                        "
                        class="space-y-3"
                    >
                        <div
                            v-for="challenge in paginatedChallenges"
                            :key="challenge.id"
                            class="bg-primary-dark/80 rounded-lg p-3 shadow-sm border border-primary-blue/20"
                        >
                            <div
                                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2 border-b border-primary-blue/30 pb-2"
                            >
                                <div
                                    class="text-primary-first text-xs font-medium"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'calendar']"
                                        class="mr-1"
                                    />
                                    {{ formatDate(challenge.updated_at) }}
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-2"
                            >
                                <div
                                    class="flex items-center bg-primary-blue/30 p-2 rounded-lg"
                                >
                                    <div
                                        class="bg-primary-first rounded-full p-1.5 mr-2 flex items-center justify-center w-6 h-6"
                                    >
                                        <font-awesome-icon
                                            :icon="['fas', 'ranking-star']"
                                            class="text-primary-dark text-xs"
                                        />
                                    </div>
                                    <span class="text-primary-light text-xs">{{
                                        challenge.position.value
                                    }}</span>
                                </div>

                                <div
                                    class="flex items-center bg-primary-blue/30 p-2 rounded-lg"
                                >
                                    <div
                                        class="bg-primary-first rounded-full p-1.5 mr-2 flex items-center justify-center w-6 h-6"
                                    >
                                        <img
                                            :src="
                                                challenge.classe?.image
                                                    ? `/storage/${challenge.classe.image}`
                                                    : '/storage/seed/default-classe.svg'
                                            "
                                            class="invert"
                                        />
                                    </div>
                                    <span class="text-primary-light text-xs">{{
                                        challenge.classe.name
                                    }}</span>
                                </div>

                                <div
                                    class="flex items-center bg-primary-blue/30 p-2 rounded-lg"
                                >
                                    <div
                                        class="bg-primary-first rounded-full p-1.5 mr-2 flex items-center justify-center w-6 h-6"
                                    >
                                        <img
                                            :src="
                                                challenge.origin?.image
                                                    ? `/storage/${challenge.origin.image}`
                                                    : '/storage/seed/default-origin.svg'
                                            "
                                            class="invert"
                                        />
                                    </div>
                                    <span class="text-primary-light text-xs">{{
                                        challenge.origin.name
                                    }}</span>
                                </div>

                                <div
                                    class="flex items-center bg-primary-blue/30 p-2 rounded-lg"
                                >
                                    <div
                                        class="bg-primary-first rounded-full p-1.5 mr-2 flex items-center justify-center w-6 h-6"
                                    >
                                        <img
                                            :src="`/storage/${challenge.constraint.image}`"
                                        />
                                    </div>
                                    <span class="text-primary-light text-xs">{{
                                        challenge.constraint.name
                                    }}</span>
                                </div>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 pt-2 border-t border-primary-blue/30"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="bg-green-500 rounded-full p-1 mr-2 flex items-center justify-center w-5 h-5"
                                    >
                                        <font-awesome-icon
                                            :icon="['fas', 'check']"
                                            class="text-white text-xs"
                                        />
                                    </div>
                                    <span
                                        class="text-green-400 text-xs font-medium"
                                        >Completed</span
                                    >
                                </div>

                                <!-- View Match button -->
                                <a
                                    :href="
                                        'https://www.metatft.com/player/euw/' +
                                        user.riot_username +
                                        '-EUW?match=' +
                                        challenge.match_id
                                    "
                                    target="_blank"
                                    class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold py-1.5 px-4 rounded-lg flex items-center transition-colors shadow-sm text-xs transform hover:scale-105 active:scale-95"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'eye']"
                                        class="mr-1.5"
                                    />
                                    View Match
                                </a>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div
                            v-if="totalPages > 1"
                            class="flex justify-center items-center mt-4 space-x-2"
                        >
                            <button
                                @click="prevPage"
                                :disabled="currentPage === 1"
                                class="bg-primary-blue hover:bg-primary-blue/80 disabled:opacity-50 disabled:cursor-not-allowed text-primary-light p-2 rounded-lg transition-colors shadow-sm flex items-center text-sm transform hover:scale-105 active:scale-95"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'chevron-left']"
                                />
                            </button>

                            <span
                                class="text-primary-light bg-primary-dark/80 px-3 py-1.5 rounded-lg text-sm border border-primary-blue/30"
                            >
                                Page {{ currentPage }} of {{ totalPages }}
                            </span>

                            <button
                                @click="nextPage"
                                :disabled="currentPage === totalPages"
                                class="bg-primary-blue hover:bg-primary-blue/80 disabled:opacity-50 disabled:cursor-not-allowed text-primary-light p-2 rounded-lg transition-colors shadow-sm flex items-center text-sm transform hover:scale-105 active:scale-95"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'chevron-right']"
                                />
                            </button>
                        </div>
                    </div>

                    <div
                        v-else
                        class="bg-primary-dark/80 rounded-lg p-5 text-center shadow-sm border border-primary-blue/20"
                    >
                        <p class="text-primary-light text-sm">
                            <font-awesome-icon
                                :icon="['fas', 'info-circle']"
                                class="mr-2"
                            />
                            No challenge completed yet.
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
