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
    <AppLayout :show-background="true">
        <Head title="Challenge Failed" />

        <div class="min-h-screen flex flex-col relative overflow-hidden">
            <!-- Main Content -->
            <main
                class="relative flex-grow flex flex-col items-center py-12 px-4"
            >
                <!-- Logo and Title -->
                <div class="flex flex-col items-center mb-8">
                    <div class="p-3 mb-2">
                        <img src="/storage/opTft.svg" alt="TFT Logo" />
                    </div>
                    <h1 class="text-5xl font-bold mb-2 text-red-400">
                        CHALLENGE FAILED
                    </h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                    <p class="text-white text-xl mb-6">
                        You didn't complete the challenge. Try again!
                    </p>
                </div>

                <!-- Results Container -->
                <div
                    class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full mb-8"
                >
                    <!-- Summary Section -->
                    <div class="mb-8">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            CHALLENGE SUMMARY
                        </h2>

                        <!-- Progress Bar -->
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="text-white">Success rate</span>
                            <span class="text-white"
                                >{{ stats.successRate }}%</span
                            >
                        </div>
                        <div class="w-full bg-blue-950 rounded-full h-4 mb-6">
                            <div
                                class="h-4 rounded-full transition-all duration-500 ease-out bg-green-500"
                                :style="{ width: `${stats.successRate}%` }"
                            ></div>
                        </div>
                    </div>

                    <!-- Detailed Results -->
                    <h2
                        class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                    >
                        CRITERIA DETAILS
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div
                            v-for="(status, key) in results"
                            :key="key"
                            class="p-4 rounded-lg h-full"
                            :class="
                                status.success
                                    ? 'bg-green-900/40'
                                    : 'bg-red-900/40'
                            "
                        >
                            <!-- Status Header -->
                            <div class="flex items-center mb-3">
                                <div
                                    class="rounded-full p-2 mr-3 flex items-center justify-center"
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
                                    <div
                                        class="text-lg font-bold text-white uppercase"
                                    >
                                        {{ key }}
                                    </div>
                                    <div
                                        :class="
                                            status.success
                                                ? 'text-green-300'
                                                : 'text-red-300'
                                        "
                                    >
                                        {{
                                            status.success ? "Passed" : "Failed"
                                        }}
                                    </div>
                                </div>
                            </div>

                            <!-- Criterion Details -->
                            <div class="space-y-2">
                                <div class="bg-blue-800/40 p-3 rounded-md">
                                    <span class="text-yellow-400 font-semibold"
                                        >Name:</span
                                    >
                                    <span class="text-white ml-2">{{
                                        challenge[key].name
                                    }}</span>
                                </div>

                                <div class="bg-blue-800/40 p-3 rounded-md">
                                    <span class="text-yellow-400 font-semibold"
                                        >Description:</span
                                    >
                                    <span class="text-white ml-2">{{
                                        challenge[key].description
                                    }}</span>
                                </div>

                                <div class="bg-blue-800/40 p-3 rounded-md">
                                    <span class="text-yellow-400 font-semibold"
                                        >Info:</span
                                    >
                                    <span class="text-white ml-2">{{
                                        status.info
                                    }}</span>
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
                        Back to Challenge
                    </button>
                    <a
                        :href="link"
                        target="_blank"
                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-3 px-6 rounded-lg flex items-center transition-colors"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path
                                fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        See the match
                    </a>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
