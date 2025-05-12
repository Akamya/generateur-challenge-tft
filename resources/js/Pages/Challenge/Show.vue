<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";

const props = defineProps({
    challenge: Object,
});
</script>

<template>
    <AppLayout :show-background="true">
        <div class="min-h-full flex flex-col relative overflow-hidden">
            <main
                class="relative flex-grow flex flex-col items-center justify-center py-6 px-4"
            >
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-xl p-8 max-w-2xl w-full min-h-[480px] flex flex-col justify-between shadow-lg border-2 border-primary-blue/30"
                >
                    <!-- Challenge Status Banner -->
                    <div
                        class="bg-primary-first/20 -mx-8 -mt-8 mb-6 py-3 px-8 rounded-t-xl border-b border-primary-first/30"
                    >
                        <div class="flex items-center justify-between">
                            <h2
                                class="text-primary-light text-2xl font-bold flex items-center"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'circle-check']"
                                    class="h-6 w-6 mr-2 text-primary-first"
                                />
                                ACTIVE CHALLENGE
                            </h2>
                            <span
                                class="bg-primary-first text-primary-dark text-xs font-bold px-3 py-1 rounded-full"
                            >
                                IN PROGRESS
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-center items-center mb-6">
                        <p
                            class="text-primary-light text-center text-sm max-w-md bg-primary-dark/30 py-2 px-4 rounded-lg border border-primary-blue/30"
                        >
                            Give it your all in TFT! Then let's verify if you
                            crushed the challenge!
                        </p>
                    </div>

                    <!-- Challenge Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Position Card -->
                        <div
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform border border-primary-blue/20"
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
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform border border-primary-blue/20"
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
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform border border-primary-blue/20"
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
                            class="bg-primary-dark/80 rounded-xl p-4 hover:bg-primary-dark transition-colors shadow-md transform border border-primary-blue/20"
                        >
                            <div class="flex items-center mb-3">
                                <div
                                    class="bg-primary-first rounded-full p-2 mr-3 flex items-center justify-center w-10 h-10"
                                >
                                    <img
                                        :src="`/storage/${challenge.constraint.image}`"
                                    />
                                </div>
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
                    <div
                        class="bg-primary-dark/50 rounded-xl p-5 border border-primary-blue/30"
                    >
                        <h3
                            class="text-primary-first text-center mb-4 font-bold"
                        >
                            CHALLENGE VERIFICATION
                        </h3>
                        <div class="flex justify-center space-x-6">
                            <button
                                @click="
                                    $inertia.post(
                                        route('challenge.complete', {
                                            id: challenge.id,
                                        })
                                    )
                                "
                                class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'check']"
                                    class="mr-2"
                                />

                                Verify
                            </button>

                            <button
                                @click="
                                    $inertia.delete(
                                        route('challenge.destroy', {
                                            id: challenge.id,
                                        })
                                    )
                                "
                                class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'xmark']"
                                    class="mr-2"
                                />
                                Abandon
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
