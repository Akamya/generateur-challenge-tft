<script setup>
import { defineProps, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, usePage } from "@inertiajs/vue3";

const props = defineProps({
    auth: Object,
    challenge: Object,
});

const isLoading = ref(false);

// Function to handle challenge generation with loading state
const generateChallenge = () => {
    isLoading.value = true;
    router.get(
        route("challenge.generate"),
        {},
        {
            onSuccess: () => {
                isLoading.value = false;
                // Scroll to the challenge section after it loads
                setTimeout(() => {
                    const challengeSection =
                        document.getElementById("challenge-section");
                    if (challengeSection) {
                        challengeSection.scrollIntoView({ behavior: "smooth" });
                    }
                }, 100);
            },
            onError: () => {
                isLoading.value = false;
            },
        }
    );
};
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out forwards;
}
</style>

<template>
    <AppLayout :show-background="true">
        <div class="min-h-full flex flex-col relative overflow-hidden">
            <main
                class="relative flex-grow flex flex-col items-center justify-start py-12 px-4"
            >
                <!-- Logo and Title -->
                <div class="flex flex-col items-center mb-10">
                    <div class="p-3 mb-2">
                        <img
                            src="/storage/opTft.svg"
                            alt="TFT OP Logo"
                            class="w-24 h-auto"
                        />
                    </div>

                    <h1
                        class="text-primary-light text-5xl font-bold mb-2 font-parkinsans text-center"
                    >
                        TFT OPERATION
                    </h1>
                    <div class="w-96 h-1 bg-primary-first mb-6"></div>
                    <p class="text-primary-light text-xl mb-6 text-center">
                        Will you rise to the challenge?
                    </p>

                    <button
                        v-if="!challenge"
                        @click="generateChallenge"
                        class="bg-primary-first hover:bg-opacity-90 text-black text-xl font-bold py-3 px-6 rounded-xl mb-6 transition-colors transform hover:scale-105 active:scale-95 flex items-center"
                        :disabled="isLoading"
                    >
                        <svg
                            v-if="isLoading"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-black"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        {{
                            isLoading ? "Generating..." : "Generate a Challenge"
                        }}
                    </button>

                    <p class="text-primary-light text-center text-sm max-w-md">
                        Sign up to track your completed challenges and maybe
                        appear in the leaderboard.
                    </p>
                </div>

                <!-- Challenge Requirements - Only visible when a challenge exists -->
                <div
                    v-if="challenge"
                    id="challenge-section"
                    class="bg-primary-blue/80 rounded-xl p-8 max-w-2xl w-full min-h-[480px] flex flex-col justify-between shadow-lg mb-12 animate-fadeIn"
                >
                    <h2
                        class="text-primary-light text-2xl font-bold mb-6 text-center border-b border-primary-first pb-2"
                    >
                        YOUR CHALLENGE
                    </h2>
                    <div
                        v-if="!props.auth.user"
                        class="flex justify-center items-center mb-6"
                    >
                        <p
                            class="text-primary-light text-center text-sm max-w-md"
                        >
                            Sign up to accept this challenge and climb the
                            ladder!
                        </p>
                    </div>

                    <div
                        v-if="props.auth.user"
                        class="flex justify-center items-center mb-6"
                    >
                        <p
                            class="text-primary-light text-center text-sm max-w-md"
                        >
                            Accept this challenge and climb the ladder!
                        </p>
                    </div>

                    <!-- Challenge Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Position Card -->
                        <div
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform"
                        >
                            <div class="flex items-center mb-3">
                                <img
                                    src="/storage/seed/podium.svg"
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                />
                                <div>
                                    <h3
                                        class="text-primary-first text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Position
                                    </h3>
                                    <p
                                        class="text-primary-light text-lg font-bold"
                                    >
                                        {{ challenge.position.value }}
                                    </p>
                                </div>
                            </div>
                            <p
                                class="text-primary-light/70 text-sm ml-13 pl-0.5"
                            >
                                {{ challenge.position.description }}
                            </p>
                        </div>

                        <!-- Class Card -->
                        <div
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
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
                                <div>
                                    <h3
                                        class="text-primary-first text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Class
                                    </h3>
                                    <p
                                        class="text-primary-light text-lg font-bold"
                                    >
                                        {{ challenge.classe.name }}
                                    </p>
                                </div>
                            </div>
                            <p
                                class="text-primary-light/70 text-sm ml-13 pl-0.5"
                            >
                                {{ challenge.classe.description }}
                            </p>
                        </div>

                        <!-- Origin Card -->
                        <div
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
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

                                <div>
                                    <h3
                                        class="text-primary-first text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Origin
                                    </h3>
                                    <p
                                        class="text-primary-light text-lg font-bold"
                                    >
                                        {{ challenge.origin.name }}
                                    </p>
                                </div>
                            </div>
                            <p
                                class="text-primary-light/70 text-sm ml-13 pl-0.5"
                            >
                                {{ challenge.origin.description }}
                            </p>
                        </div>

                        <!-- Constraint Card -->
                        <div
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform"
                        >
                            <div class="flex items-center mb-3">
                                <img
                                    src="/storage/seed/constraint.svg"
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                />
                                <div>
                                    <h3
                                        class="text-primary-first text-sm font-semibold uppercase tracking-wider"
                                    >
                                        Constraint
                                    </h3>
                                    <p
                                        class="text-primary-light text-lg font-bold"
                                    >
                                        {{ challenge.constraint.name }}
                                    </p>
                                </div>
                            </div>
                            <p
                                class="text-primary-light/70 text-sm ml-13 pl-0.5"
                            >
                                {{ challenge.constraint.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-6">
                        <button
                            v-if="props.auth.user"
                            @click="
                                router.post(route('challenge.accept'), {
                                    position_id: challenge.position.id,
                                    classe_id: challenge.classe.id,
                                    origin_id: challenge.origin.id,
                                    constraint_id: challenge.constraint.id,
                                })
                            "
                            class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'check']"
                                class="mr-1"
                            />
                            Accept
                        </button>
                        <button
                            @click="generateChallenge"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                            :disabled="isLoading"
                        >
                            <svg
                                v-if="isLoading"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <font-awesome-icon :icon="['fas', 'dice']" />
                            </svg>
                            <font-awesome-icon
                                v-else
                                class="mr-1"
                                :icon="['fas', 'dice']"
                            />

                            {{ isLoading ? "Generating..." : "Reroll" }}
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
