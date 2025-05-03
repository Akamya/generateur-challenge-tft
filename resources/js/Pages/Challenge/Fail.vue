<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, computed } from "vue";

const props = defineProps({
    challenge: Object,
    results: Object,
    link: String,
});

const stats = computed(() => {
    if (!props.results) return { total: 0, success: 0 };

    const total = Object.keys(props.results).length;
    const success = Object.values(props.results).filter(
        (status) => status.success
    ).length;
    const successRate = total > 0 ? Math.round((success / total) * 100) : 0;

    return { successRate };
});
</script>

<template>
    <AppLayout>
        <Head title="Défi échoué" />

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
                    <h1 class="text-5xl font-bold mb-2 text-red-400">
                        DÉFI ÉCHOUÉ
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                    <p class="text-white text-xl mb-6">
                        Vous n'avez pas réussi à compléter ce défi. Réessayez !
                    </p>
                </div>

                <!-- Results Container -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-2xl w-full mb-8"
                >
                    <!-- Summary Section -->
                    <div class="mb-8">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            RÉSUMÉ DU DÉFI
                        </h2>

                        <!-- Progress Bar -->
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="text-white">Taux de réussite</span>
                            <span class="text-white"
                                >{{ stats.successRate }}%</span
                            >
                        </div>
                        <div class="w-full bg-blue-950 rounded-full h-4 mb-6">
                            <div
                                class="h-4 rounded-full transition-all duration-500 ease-out bg-red-500"
                                :style="{ width: `${stats.successRate}%` }"
                            ></div>
                        </div>
                    </div>

                    <!-- Detailed Results -->
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        DÉTAILS DES CRITÈRES
                    </h2>

                    <div class="space-y-4">
                        <div
                            v-for="(status, key) in results"
                            :key="key"
                            class="flex items-center p-4 rounded-lg"
                            :class="
                                status.success
                                    ? 'bg-green-900/40'
                                    : 'bg-red-900/40'
                            "
                        >
                            <div
                                class="rounded-full p-2 mr-4 flex items-center justify-center"
                                :class="
                                    status.success
                                        ? 'bg-green-500'
                                        : 'bg-red-500'
                                "
                            >
                                <svg
                                    v-if="status.success"
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
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <svg
                                    v-else
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
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-white">
                                    {{ key }}
                                    {{ challenge[key].name }}
                                    {{ challenge[key].description }}
                                    {{ status.info }}
                                </div>
                                <div
                                    :class="
                                        status.success
                                            ? 'text-green-300'
                                            : 'text-red-300'
                                    "
                                >
                                    {{
                                        status.success
                                            ? "Critère validé"
                                            : "Critère non validé"
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-4">
                    <button
                        @click="
                            $inertia.get(route('challenge.show', challenge.id))
                        "
                        class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
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
                        Revenir au challenge
                    </button>
                    <a
                        :href="link"
                        target="_blank"
                        class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
                    >
                        See the match
                    </a>
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
