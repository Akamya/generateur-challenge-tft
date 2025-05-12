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
        (status) => status
    ).length;
    const successRate = total > 0 ? Math.round((success / total) * 100) : 0;

    return { successRate };
});
</script>

<template>
    <AppLayout :show-background="true">
        <Head title="Challenge Completed" />

        <div class="min-h-full flex flex-col relative overflow-hidden">
            <main
                class="relative flex-grow flex flex-col items-center py-12 px-4"
            >
                <!-- Logo and Title -->
                <div class="flex flex-col items-center mb-8">
                    <div class="p-3 mb-2">
                        <img
                            src="/storage/opTft.svg"
                            alt="TFT Logo"
                            class="w-24 h-auto"
                        />
                    </div>
                    <h1
                        class="text-4xl font-bold mb-2 text-green-500 font-parkinsans text-center"
                    >
                        CHALLENGE COMPLETED
                    </h1>
                    <div class="w-96 h-1 bg-primary-first mb-6"></div>
                    <p class="text-primary-light text-xl mb-6 text-center">
                        Congratulations! You have successfully completed this
                        challenge.
                    </p>
                </div>

                <!-- Results Container -->
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-xl overflow-hidden max-w-4xl w-full mb-8 shadow-lg border-2 border-primary-blue/30"
                >
                    <!-- Success Status Banner -->
                    <div
                        class="bg-green-600/20 w-full py-3 px-8 border-b border-green-600/30 text-center"
                    >
                        <h2
                            class="text-primary-light text-2xl font-bold flex items-center justify-center"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'circle-check']"
                                class="h-6 w-6 mr-2 text-green-500"
                            />
                            VERIFICATION RESULTS
                        </h2>
                    </div>

                    <!-- Content Container -->
                    <div class="p-8">
                        <!-- Summary Section -->
                        <div class="mb-8">
                            <!-- Progress Bar -->
                            <div class="mb-2 flex justify-between text-sm">
                                <span class="text-primary-light"
                                    >Success rate</span
                                >
                                <span class="text-primary-light"
                                    >{{ stats.successRate }}%</span
                                >
                            </div>
                            <div
                                class="w-full bg-primary-dark rounded-full h-4 mb-6 border border-primary-blue/30"
                            >
                                <div
                                    class="h-4 rounded-full transition-all duration-500 ease-out bg-green-500"
                                    :style="{ width: `${stats.successRate}%` }"
                                ></div>
                            </div>
                        </div>

                        <!-- Detailed Results -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Position Card -->
                            <div
                                v-if="results.position"
                                class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md border border-green-500/30"
                            >
                                <!-- Status Header -->
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                    >
                                        <img
                                            src="/storage/seed/podium.svg"
                                            class="w-6 h-6"
                                        />
                                    </div>
                                    <div>
                                        <div
                                            class="text-lg font-bold text-primary-first uppercase"
                                        >
                                            Position
                                        </div>
                                        <div class="text-green-400">Passed</div>
                                    </div>
                                </div>

                                <!-- Criterion Details -->
                                <div class="space-y-3">
                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Required:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.position.value
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Description:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.position.description
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Result:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            results.position.info
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Card -->
                            <div
                                v-if="results.classe"
                                class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md border border-green-500/30"
                            >
                                <!-- Status Header -->
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
                                            class="invert w-6 h-6"
                                        />
                                    </div>
                                    <div>
                                        <div
                                            class="text-lg font-bold text-primary-first uppercase"
                                        >
                                            Class
                                        </div>
                                        <div class="text-green-400">Passed</div>
                                    </div>
                                </div>

                                <!-- Criterion Details -->
                                <div class="space-y-3">
                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Required:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.classe.name
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Description:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.classe.description
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Result:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            results.classe.info
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Origin Card -->
                            <div
                                v-if="results.origin"
                                class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md border border-green-500/30"
                            >
                                <!-- Status Header -->
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
                                            class="invert w-6 h-6"
                                        />
                                    </div>
                                    <div>
                                        <div
                                            class="text-lg font-bold text-primary-first uppercase"
                                        >
                                            Origin
                                        </div>
                                        <div class="text-green-400">Passed</div>
                                    </div>
                                </div>

                                <!-- Criterion Details -->
                                <div class="space-y-3">
                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Required:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.origin.name
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Description:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.origin.description
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Result:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            results.origin.info
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Constraint Card -->
                            <div
                                v-if="results.constraint"
                                class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md border border-green-500/30"
                            >
                                <!-- Status Header -->
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                    >
                                        <img
                                            :src="`/storage/${challenge.constraint.image}`"
                                            class="w-6 h-6"
                                        />
                                    </div>
                                    <div>
                                        <div
                                            class="text-lg font-bold text-primary-first uppercase"
                                        >
                                            Constraint
                                        </div>
                                        <div class="text-green-400">Passed</div>
                                    </div>
                                </div>

                                <!-- Criterion Details -->
                                <div class="space-y-3">
                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Required:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.constraint.name
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Description:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            challenge.constraint.description
                                        }}</span>
                                    </div>

                                    <div
                                        class="bg-primary-blue/20 p-3 rounded-lg border border-primary-blue/30"
                                    >
                                        <span
                                            class="text-primary-first font-semibold"
                                            >Result:</span
                                        >
                                        <span class="text-primary-light ml-2">{{
                                            results.constraint.info
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div
                    class="bg-primary-dark/50 rounded-xl p-5 border border-primary-blue/30 max-w-md w-full"
                >
                    <div class="flex flex-wrap justify-center gap-4">
                        <button
                            @click="$inertia.get(route('challenge.generate'))"
                            class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'arrows-rotate']"
                                class="mr-2"
                            />
                            New Challenge
                        </button>
                        <a
                            :href="link"
                            target="_blank"
                            class="bg-primary-blue hover:bg-primary-blue/80 text-primary-light font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'eye']"
                                class="mr-2"
                            />
                            See the match
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
