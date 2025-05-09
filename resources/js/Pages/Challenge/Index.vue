<script setup>
import { defineProps } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: Object,
    challenge: Object,
});
</script>

<template>
    <AppLayout :show-background="true">
        <div class="min-h-full flex flex-col relative overflow-hidden">
            <!-- Main Content -->
            <main
                class="relative flex-grow flex flex-col items-center justify-center py-12 px-4"
            >
                <!-- Logo and Title -->
                <div v-if="!challenge" class="flex flex-col items-center mb-8">
                    <div
                        class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6"
                    >
                        <img src="" alt="TFT Logo" class="h-16 w-16" />
                    </div>
                    <h1 class="text-white text-5xl font-bold mb-2">
                        TFT OPERATION
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                    <p class="text-white text-xl mb-6">
                        Will you rise to the challenge?
                    </p>

                    <button
                        @click="$inertia.get(route('challenge.generate'))"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black text-xl font-bold py-3 px-8 rounded-full mb-6"
                    >
                        Generate a Challenge
                    </button>

                    <p
                        v-if="!props.auth.user"
                        class="text-white text-center text-sm max-w-md"
                    >
                        Sign up to track your completed challenges and maybe
                        appear in the leaderboard.
                    </p>
                </div>

                <!-- Challenge Requirements -->
                <div
                    v-if="challenge"
                    class="bg-blue-900/80 rounded-lg p-8 max-w-2xl w-full min-h-[480px] min-w-[700px] flex flex-col justify-between"
                >
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        YOUR CHALLENGE
                    </h2>
                    <div
                        v-if="!props.auth.user"
                        class="flex justify-center items-center mb-6"
                    >
                        <p class="text-white text-center text-sm max-w-md">
                            Sign up to accept this challenge and climb the
                            ladder!
                        </p>
                    </div>

                    <div
                        v-if="props.auth.user"
                        class="flex justify-center items-center mb-6"
                    >
                        <p class="text-white text-center text-sm max-w-md">
                            Accept this challenge and climb the ladder!
                        </p>
                    </div>

                    <!-- Challenge Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Position Card -->
                        <div
                            class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-yellow-400 text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Position
                                    </h3>
                                    <p class="text-white text-lg font-bold">
                                        {{ challenge.position.value }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-blue-200 text-sm ml-13 pl-0.5">
                                {{ challenge.position.description }}
                            </p>
                        </div>

                        <!-- Class Card -->
                        <div
                            class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-yellow-400 text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Class
                                    </h3>
                                    <p class="text-white text-lg font-bold">
                                        {{ challenge.classe.name }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-blue-200 text-sm ml-13 pl-0.5">
                                {{ challenge.classe.description }}
                            </p>
                        </div>

                        <!-- Origin Card -->
                        <div
                            class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-yellow-400 text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Origin
                                    </h3>
                                    <p class="text-white text-lg font-bold">
                                        {{ challenge.origin.name }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-blue-200 text-sm ml-13 pl-0.5">
                                {{ challenge.origin.description }}
                            </p>
                        </div>

                        <!-- Constraint Card -->
                        <div
                            class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-orange-500 rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-yellow-400 text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Constraint
                                    </h3>
                                    <p class="text-white text-lg font-bold">
                                        {{ challenge.constraint.name }}
                                    </p>
                                </div>
                            </div>
                            <p class="text-blue-200 text-sm ml-13 pl-0.5">
                                {{ challenge.constraint.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-6">
                        <button
                            v-if="props.auth.user"
                            @click="
                                $inertia.post(route('challenge.accept'), {
                                    position_id: challenge.position.id,
                                    classe_id: challenge.classe.id,
                                    origin_id: challenge.origin.id,
                                    constraint_id: challenge.constraint.id,
                                })
                            "
                            class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Accept
                        </button>
                        <button
                            @click="$inertia.get(route('challenge.generate'))"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Reroll
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
