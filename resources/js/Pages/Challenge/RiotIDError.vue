<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
    <AppLayout :show-background="true">
        <Head title="Match Not Found" />

        <div class="min-h-full flex flex-col relative overflow-hidden">
            <main
                class="relative flex-grow flex flex-col items-center justify-center py-12 px-4"
            >
                <div
                    class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-xl overflow-hidden max-w-lg w-full flex flex-col items-center shadow-lg border-2 border-primary-blue/30"
                >
                    <!-- Error Status Banner -->
                    <div
                        class="bg-red-600/20 w-full py-3 px-8 border-b border-red-600/30 text-center"
                    >
                        <h2
                            class="text-primary-light text-2xl font-bold flex items-center justify-center"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'circle-exclamation']"
                                class="h-6 w-6 mr-2 text-red-500"
                            />
                            MATCH NOT FOUND
                        </h2>
                    </div>

                    <!-- Content Container -->
                    <div class="p-8 w-full flex flex-col items-center">
                        <div
                            class="bg-primary-dark/80 rounded-full p-6 border-2 border-red-500/50 mb-6 shadow-lg"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'triangle-exclamation']"
                                class="h-16 w-16 text-red-500"
                            />
                        </div>

                        <div class="text-center mb-8 w-full">
                            <h1
                                class="text-primary-light text-2xl font-bold mb-4"
                            >
                                We couldn't find your matches.
                            </h1>
                            <p
                                class="text-primary-light/80 text-lg mb-6 bg-primary-dark/30 py-2 px-4 rounded-lg border border-primary-blue/30 max-w-md mx-auto"
                            >
                                Please verify your Riot username.
                            </p>
                        </div>

                        <!-- Action Button -->
                        <div
                            class="bg-primary-dark/50 rounded-xl p-5 border border-primary-blue/30 w-full"
                        >
                            <h3
                                class="text-primary-first text-center mb-4 font-bold"
                            >
                                ACCOUNT VERIFICATION
                            </h3>
                            <div class="flex justify-center">
                                <button
                                    @click="
                                        $inertia.visit(route('profile.show'))
                                    "
                                    class="bg-primary-first hover:bg-primary-first/90 text-primary-dark font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-md transform hover:scale-105 active:scale-95"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'user']"
                                        class="mr-2"
                                    />
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
