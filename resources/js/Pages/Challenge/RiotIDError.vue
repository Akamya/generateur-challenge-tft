<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
    <AppLayout>
        <Head title="Summoner Not Found - Opération TFT" />

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
                class="relative flex-grow flex flex-col items-center justify-center py-12 px-4"
            >
                <!-- Error Icon -->
                <div
                    class="bg-blue-900 rounded-full p-6 border-4 border-yellow-500 mb-8"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-16 w-16 text-red-400"
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

                <!-- Error Message -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-lg w-full text-center mb-8"
                >
                    <h1 class="text-white text-2xl font-bold mb-4">
                        We couldn't find your summoner.
                    </h1>
                    <p class="text-white text-xl mb-6">
                        Please verify your Riot username.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <button
                            @click="$inertia.visit(route('profile.show'))"
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
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Update Profile
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
