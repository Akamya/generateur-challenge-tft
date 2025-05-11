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
    <AppLayout :show-background="false">
        <Head title="Admin" />
        <div class="w-full max-w-7xl mx-auto px-4 py-8 relative z-10">
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-8">
                <div class="p-3 mb-2">
                    <img
                        src="/storage/opTft.svg"
                        alt="TFT Logo"
                        class="w-20 h-auto"
                    />
                </div>
                <h1
                    class="text-primary-light text-4xl font-bold mb-2 font-parkinsans text-center"
                >
                    ADMIN PANEL
                </h1>
                <div class="w-48 h-1 bg-primary-first mb-4"></div>
            </div>

            <!-- Admin Interface -->
            <div
                class="w-full bg-primary-dark/80 backdrop-blur-sm rounded-xl shadow-lg border border-primary-blue/30 overflow-hidden"
            >
                <!-- Navigation Tabs -->
                <div
                    class="flex border-b border-primary-blue/30 bg-primary-dark/50"
                >
                    <button
                        @click="activeTab = 'seasons'"
                        :class="[
                            'px-6 py-4 font-bold text-lg transition-colors',
                            activeTab === 'seasons'
                                ? 'text-primary-first border-b-2 border-primary-first bg-primary-dark/30'
                                : 'text-primary-light hover:text-primary-first hover:bg-primary-dark/20',
                        ]"
                    >
                        Seasons
                    </button>
                    <button
                        @click="activeTab = 'classes'"
                        :class="[
                            'px-6 py-4 font-bold text-lg transition-colors',
                            activeTab === 'classes'
                                ? 'text-primary-first border-b-2 border-primary-first bg-primary-dark/30'
                                : 'text-primary-light hover:text-primary-first hover:bg-primary-dark/20',
                        ]"
                    >
                        Classes
                    </button>
                    <button
                        @click="activeTab = 'origins'"
                        :class="[
                            'px-6 py-4 font-bold text-lg transition-colors',
                            activeTab === 'origins'
                                ? 'text-primary-first border-b-2 border-primary-first bg-primary-dark/30'
                                : 'text-primary-light hover:text-primary-first hover:bg-primary-dark/20',
                        ]"
                    >
                        Origins
                    </button>
                </div>

                <!-- Tab Content Containers -->
                <div class="p-6">
                    <div v-if="activeTab === 'seasons'" class="rounded-lg">
                        <SeasonsTab :seasons="seasons" />
                    </div>

                    <div v-if="activeTab === 'classes'" class="rounded-lg">
                        <ClassesTab :seasons="seasons" :classes="classes" />
                    </div>

                    <div v-if="activeTab === 'origins'" class="rounded-lg">
                        <OriginsTab :seasons="seasons" :origins="origins" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
