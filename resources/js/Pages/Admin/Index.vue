<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref } from "vue";
import SeasonsTab from "@/Pages/Admin/SeasonsTab.vue";
import ClassesTab from "@/Pages/Admin/ClassesTab.vue";
import OriginsTab from "@/Pages/Admin/OriginsTab.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    seasons: Array,
    origins: Array,
    classes: Array,
});

const activeTab = ref("seasons");
</script>

<template>
    <AppLayout :show-background="true">
        <Head title="Admin" />
        <main class="relative flex-grow flex flex-col items-center py-12 px-4">
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-10">
                <div class="p-3 mb-2">
                    <img src="/storage/opTft.svg" alt="TFT Logo" />
                </div>
                <h1 class="text-white text-5xl font-bold mb-2 tracking-wider">
                    ADMIN PANEL
                </h1>
                <div
                    class="w-64 h-1 bg-gradient-to-r from-yellow-500 via-yellow-400 to-yellow-500 mb-6 rounded-full"
                ></div>
            </div>

            <!-- Admin Interface -->
            <div class="max-w-6xl w-full mx-auto">
                <!-- Navigation Tabs -->
                <div class="flex mb-8 border-b border-blue-700">
                    <button
                        @click="activeTab = 'seasons'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'seasons'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Seasons
                    </button>
                    <button
                        @click="activeTab = 'classes'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'classes'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Classes
                    </button>
                    <button
                        @click="activeTab = 'origins'"
                        :class="[
                            'px-6 py-3 font-bold text-lg transition-colors',
                            activeTab === 'origins'
                                ? 'text-yellow-400 border-b-2 border-yellow-400'
                                : 'text-white hover:text-yellow-300',
                        ]"
                    >
                        Origins
                    </button>
                </div>

                <!-- Seasons Tab -->
                <div
                    v-if="activeTab === 'seasons'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <SeasonsTab :seasons="seasons" />
                </div>

                <!-- Classes Tab -->
                <div
                    v-if="activeTab === 'classes'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <ClassesTab :seasons="seasons" :classes="classes" />
                </div>

                <!-- Origins Tab -->
                <div
                    v-if="activeTab === 'origins'"
                    class="bg-blue-900/80 rounded-lg p-8 backdrop-blur-sm shadow-xl border border-blue-800/50"
                >
                    <OriginsTab :seasons="seasons" :origins="origins" />
                </div>
            </div>
        </main>
    </AppLayout>
</template>
