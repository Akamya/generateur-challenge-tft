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
    challenges: Array,
});

const showChallenge = ref(false);

function generateChallenge() {
    showChallenge.value = true;
}

function rerollChallenge() {
    // Here you would call your backend to get a new challenge
    // For now, we'll just simulate a reroll by hiding and showing the challenge
    showChallenge.value = false;
    setTimeout(() => {
        showChallenge.value = true;
    }, 300);
}

function acceptChallenge() {
    // Here you would call your backend to accept the challenge
    alert("Challenge accepté !");
}
</script>

<template>
    <div class="min-h-screen flex flex-col relative overflow-hidden">
        <!-- Background image -->
        <div class="absolute inset-0 z-0">
            <img
                src="/images/tft-background.jpg"
                alt="TFT Background"
                class="w-full h-full object-cover opacity-70"
            />
            <div class="absolute inset-0 bg-blue-900/70"></div>
        </div>

        <!-- Header -->
        <header class="relative z-10 bg-blue-950/80 py-4 px-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <img
                        src="/images/tft-logo.png"
                        alt="TFT Logo"
                        class="h-10 w-10 mr-2"
                    />
                    <span class="text-white text-xl font-bold"
                        >OPÉRATION TFT</span
                    >
                </div>
                <nav class="hidden md:flex space-x-8">
                    <Link
                        href="/accueil"
                        class="text-white hover:text-yellow-300"
                        >Accueil</Link
                    >
                    <Link
                        href="/challenges"
                        class="text-white hover:text-yellow-300"
                        >Challenges</Link
                    >
                    <Link
                        href="/classement"
                        class="text-white hover:text-yellow-300"
                        >Classement</Link
                    >
                </nav>
                <div class="flex space-x-4">
                    <Link
                        href="/login"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full"
                    >
                        Connexion
                    </Link>
                    <Link
                        href="/register"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full"
                    >
                        Inscription
                    </Link>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main
            class="relative z-10 flex-grow flex flex-col items-center justify-center py-12 px-4"
        >
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-8">
                <div
                    class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6"
                >
                    <img
                        src="/images/tft-logo.png"
                        alt="TFT Logo"
                        class="h-16 w-16"
                    />
                </div>
                <h1 class="text-white text-5xl font-bold mb-2">
                    OPÉRATION TFT
                </h1>
                <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                <p class="text-white text-xl mb-6">
                    Saurez-vous relever le challenge ?
                </p>

                <button
                    @click="generateChallenge"
                    class="bg-yellow-500 hover:bg-yellow-400 text-black text-xl font-bold py-3 px-8 rounded-full mb-6"
                >
                    Générer un Challenge
                </button>

                <p class="text-white text-center text-sm max-w-md">
                    Inscrivez-vous pour suivre vos challenges réussis et
                    apparaître dans le classement.
                </p>
            </div>

            <!-- Challenge Requirements -->
            <div
                v-if="showChallenge"
                class="bg-blue-900/80 rounded-lg p-8 max-w-2xl w-full"
            >
                <h2 class="text-white text-2xl font-bold mb-8 text-center">
                    VOUS DEVEZ JOUER
                </h2>

                <div class="space-y-4">
                    <!-- Challenge Item 1 -->
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-full p-2 mr-4">
                            <div class="text-white text-2xl font-bold">1</div>
                        </div>
                        <span class="text-white text-lg">Finir 1er</span>
                    </div>

                    <!-- Challenge Item 2 -->
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-full p-2 mr-4">
                            <div class="text-white text-2xl font-bold">★</div>
                        </div>
                        <span class="text-white text-lg"
                            >Tous les Rose noire</span
                        >
                    </div>

                    <!-- Challenge Item 3 -->
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-full p-2 mr-4">
                            <div class="text-white text-2xl font-bold">★</div>
                        </div>
                        <span class="text-white text-lg"
                            >Au moins 1 Embuscade</span
                        >
                    </div>

                    <!-- Challenge Item 4 -->
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-full p-2 mr-4">
                            <div class="text-white text-2xl font-bold">▲</div>
                        </div>
                        <span class="text-white text-lg"
                            >Formation Triangle</span
                        >
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center mt-8 space-x-6">
                    <button
                        @click="rerollChallenge"
                        class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded-lg flex items-center"
                    >
                        <div class="bg-red-800 rounded p-1 mr-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        Reroll
                    </button>
                    <button
                        @click="acceptChallenge"
                        class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-4 rounded-lg flex items-center"
                    >
                        <div class="bg-green-800 rounded p-1 mr-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        Accepter le défis
                    </button>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 bg-blue-950/80 py-6 px-4 text-center">
            <div class="container mx-auto">
                <div class="flex justify-center mb-2">
                    <img
                        src="/images/tft-logo.png"
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
</template>

<style>
/* You can add any additional custom styles here if needed */
</style>
