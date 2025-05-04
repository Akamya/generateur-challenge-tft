<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    auth: Object,
    origins: Array,
    positions: Array,
    classes: Array,
    constraints: Array,
});

const activeCategory = ref("classes");

const setActiveCategory = (category) => {
    activeCategory.value = category;
};
</script>

<template>
    <AppLayout>
        <Head title="Glossary" />

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
                    <h1 class="text-white text-5xl font-bold mb-2">GLOSSARY</h1>
                    <div class="w-64 h-1 bg-yellow-500 mb-6"></div>
                </div>

                <!-- Category Navigation -->
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <button
                        @click="setActiveCategory('classes')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'classes'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Classes
                    </button>
                    <button
                        @click="setActiveCategory('origins')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'origins'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Origins
                    </button>
                    <button
                        @click="setActiveCategory('constraints')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'constraints'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Constraints
                    </button>
                    <button
                        @click="setActiveCategory('positions')"
                        class="px-6 py-3 rounded-full text-lg font-bold transition-colors"
                        :class="
                            activeCategory === 'positions'
                                ? 'bg-yellow-500 text-blue-900'
                                : 'bg-blue-900/60 text-white hover:bg-blue-900/80'
                        "
                    >
                        Positions
                    </button>
                </div>

                <!-- Content Container -->
                <div class="bg-blue-900/80 rounded-lg p-8 max-w-4xl w-full">
                    <!-- Origins Content -->
                    <div v-if="activeCategory === 'origins'" class="space-y-6">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            ORIGINS
                        </h2>

                        <div
                            v-if="props.origins"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        >
                            <div
                                v-for="origin in props.origins"
                                :key="origin.id"
                                class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ origin.name }}
                                    </h3>
                                </div>
                                <p class="text-white text-sm ml-12">
                                    {{ origin.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Positions Content -->
                    <div
                        v-if="activeCategory === 'positions'"
                        class="space-y-6"
                    >
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            POSITIONS
                        </h2>

                        <div v-if="props.positions" class="space-y-8">
                            <div
                                v-for="position in props.positions"
                                :key="position.id"
                                class="bg-blue-800/60 rounded-lg p-6 hover:bg-blue-800/80 transition-colors"
                            >
                                <div
                                    class="flex flex-col md:flex-row md:items-center gap-4"
                                >
                                    <div class="flex items-center">
                                        <div
                                            class="bg-orange-500 rounded-full p-3 mr-3"
                                        >
                                            <div
                                                class="text-white text-xl font-bold"
                                            >
                                                ★
                                            </div>
                                        </div>
                                        <h3
                                            class="text-white text-xl font-bold"
                                        >
                                            {{ position.name }}
                                        </h3>
                                    </div>

                                    <div
                                        v-if="position.image_url"
                                        class="md:ml-auto"
                                    >
                                        <img
                                            :src="position.image_url"
                                            :alt="position.name"
                                            class="h-24 w-24 object-cover rounded-lg border-2 border-yellow-500"
                                        />
                                    </div>
                                </div>

                                <p class="text-white mt-4">
                                    {{ position.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Classes Content -->
                    <div v-if="activeCategory === 'classes'" class="space-y-6">
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            CLASSES
                        </h2>

                        <div
                            v-if="props.classes"
                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                        >
                            <div
                                v-for="classe in props.classes"
                                :key="classe.id"
                                class="bg-blue-800/60 rounded-lg p-4 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-3">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ classe.name }}
                                    </h3>
                                </div>
                                <p class="text-white text-sm ml-12">
                                    {{ classe.description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Constraints Content -->
                    <div
                        v-if="activeCategory === 'constraints'"
                        class="space-y-6"
                    >
                        <h2
                            class="text-white text-2xl font-bold mb-6 text-center border-b border-yellow-500 pb-2"
                        >
                            CONSTRAINTS
                        </h2>

                        <div v-if="props.constraints" class="space-y-6">
                            <div
                                v-for="constraint in props.constraints"
                                :key="constraint.id"
                                class="bg-blue-800/60 rounded-lg p-6 hover:bg-blue-800/80 transition-colors"
                            >
                                <div class="flex items-center mb-4">
                                    <div
                                        class="bg-orange-500 rounded-full p-3 mr-3"
                                    >
                                        <div
                                            class="text-white text-xl font-bold"
                                        >
                                            ★
                                        </div>
                                    </div>
                                    <h3 class="text-white text-xl font-bold">
                                        {{ constraint.name }}
                                    </h3>
                                </div>
                                <p class="text-white ml-12">
                                    {{ constraint.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
