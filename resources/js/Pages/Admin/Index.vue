<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref } from "vue";
import SeasonsTab from "@/Pages/Admin/SeasonsTab.vue";
import ClassesTab from "@/Pages/Admin/ClassesTab.vue";

const props = defineProps({
    seasons: Array,
    origins: Array,
    classes: Array,
});

const activeTab = ref("seasons");
</script>

<template>
    <AppLayout :show-background="true">
        <main class="relative flex-grow flex flex-col items-center py-12 px-4">
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-10">
                <div
                    class="bg-blue-900 rounded-full p-3 border-4 border-yellow-500 mb-6 shadow-lg shadow-blue-900/50"
                >
                    <img
                        src="/placeholder.svg?height=64&width=64"
                        alt="TFT Logo"
                        class="h-16 w-16"
                    />
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
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-white text-2xl font-bold">
                                Origins
                            </h2>
                            <p class="text-blue-300">
                                Manage champion origins for TFT
                            </p>
                        </div>
                        <div class="flex space-x-4">
                            <div class="relative">
                                <select
                                    class="bg-blue-800 text-white border border-blue-700 rounded-lg px-4 py-2 appearance-none pr-10 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                >
                                    <option
                                        v-for="season in props.seasons"
                                        :key="season.id"
                                        :value="season.id"
                                    >
                                        {{ season.name }}
                                    </option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none"
                                >
                                    <svg
                                        class="w-5 h-5 text-yellow-400"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <button
                                class="bg-gradient-to-r from-yellow-500 to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 text-black font-bold py-2 px-4 rounded-lg transition-colors shadow-md flex items-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Add Origin
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Example origins - replace with actual data -->
                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    K/DA
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                K/DA members gain stacking AP when they cast
                                abilities.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    Pentakill
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                Pentakill members gain AD after scoring a
                                takedown.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <div
                            class="bg-blue-800/40 rounded-lg p-6 border border-blue-700/30 flex flex-col h-full"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-yellow-400">
                                    True Damage
                                </h3>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400"
                                >
                                    Set 10
                                </span>
                            </div>
                            <p class="text-white flex-grow mb-4">
                                True Damage members deal bonus true damage with
                                attacks.
                            </p>
                            <div class="flex justify-end space-x-2 mt-auto">
                                <button
                                    class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Edit origin"
                                >
                                    Edit
                                </button>
                                <button
                                    class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded transition-colors"
                                    title="Delete origin"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>

                        <!-- Empty state for no origins -->
                        <div
                            v-if="false"
                            class="col-span-2 text-center py-10 bg-blue-800/40 rounded-lg"
                        >
                            <p class="text-blue-300 text-lg">
                                No origins found for this season.
                            </p>
                            <button
                                class="mt-4 bg-yellow-500 hover:bg-yellow-400 text-black font-medium py-2 px-4 rounded transition-colors"
                            >
                                Add your first origin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AppLayout>
</template>
