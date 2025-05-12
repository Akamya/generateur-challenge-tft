<script setup>
import { ref, defineProps } from "vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    auth: Object,
    origins: Array,
    classes: Array,
    constraints: Array,
});

console.log("props", props.classes);

const activeCategory = ref("constraints");

const setActiveCategory = (category) => {
    activeCategory.value = category;
};
</script>

<template>
    <AppLayout :show-background="true">
        <Head title="Glossary" />

        <main class="relative flex-grow w-full py-8 px-4 justify-center">
            <!-- Logo and Title -->
            <div class="flex flex-col items-center mb-6">
                <div class="p-2 mb-1">
                    <img
                        src="/storage/opTft.svg"
                        alt="TFT Logo"
                        class="w-16 h-auto"
                    />
                </div>
                <h1
                    class="text-4xl font-bold mb-1 text-primary-light font-parkinsans"
                >
                    GLOSSARY
                </h1>
                <div class="w-48 h-1 bg-primary-first mb-4"></div>
            </div>

            <!-- Category Navigation -->
            <div class="flex justify-center gap-2 mb-6">
                <button
                    @click="setActiveCategory('constraints')"
                    class="px-5 py-2 rounded-lg text-base font-bold transition-all duration-200 shadow-sm transform hover:scale-105 active:scale-95"
                    :class="
                        activeCategory === 'constraints'
                            ? 'bg-primary-first text-primary-dark'
                            : 'bg-primary-dark/80 text-primary-light hover:bg-primary-dark border border-primary-blue/30'
                    "
                >
                    Constraints
                </button>
                <button
                    @click="setActiveCategory('classes')"
                    class="px-5 py-2 rounded-lg text-base font-bold transition-all duration-200 shadow-sm transform hover:scale-105 active:scale-95"
                    :class="
                        activeCategory === 'classes'
                            ? 'bg-primary-first text-primary-dark'
                            : 'bg-primary-dark/80 text-primary-light hover:bg-primary-dark border border-primary-blue/30'
                    "
                >
                    Classes
                </button>
                <button
                    @click="setActiveCategory('origins')"
                    class="px-5 py-2 rounded-lg text-base font-bold transition-all duration-200 shadow-sm transform hover:scale-105 active:scale-95"
                    :class="
                        activeCategory === 'origins'
                            ? 'bg-primary-first text-primary-dark'
                            : 'bg-primary-dark/80 text-primary-light hover:bg-primary-dark border border-primary-blue/30'
                    "
                >
                    Origins
                </button>
            </div>

            <!-- Content Container -->
            <div
                class="bg-gradient-to-br from-primary-blue/90 to-primary-blue/70 rounded-lg overflow-hidden max-w-5xl w-full mx-auto shadow-md border border-primary-blue/30 p-5"
            >
                <!-- Origins Content -->
                <div v-if="activeCategory === 'origins'" class="space-y-4">
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        ORIGINS
                    </h2>

                    <div
                        v-if="props.origins"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <div
                            v-for="origin in props.origins"
                            :key="origin.id"
                            class="bg-primary-dark/80 rounded-lg p-3 hover:bg-primary-dark transition-colors shadow-sm border border-primary-blue/20"
                        >
                            <div class="flex items-center">
                                <div
                                    class="bg-primary-icon rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="
                                            origin?.image
                                                ? `/storage/${origin.image}`
                                                : '/storage/seed/default-origin.svg'
                                        "
                                        class="invert"
                                    />
                                </div>
                                <h3 class="text-primary-icon text-lg font-bold">
                                    {{ origin.name }}
                                </h3>
                            </div>
                            <p
                                class="text-primary-light text-xs mt-2 leading-relaxed"
                            >
                                {{ origin.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Classes Content -->
                <div v-if="activeCategory === 'classes'" class="space-y-4">
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        CLASSES
                    </h2>

                    <div
                        v-if="props.classes"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <div
                            v-for="classe in props.classes"
                            :key="classe.id"
                            class="bg-primary-dark/80 rounded-lg p-3 hover:bg-primary-dark transition-colors shadow-sm border border-primary-blue/20"
                        >
                            <div class="flex items-center">
                                <div
                                    class="bg-primary-icon rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="
                                            classe?.image
                                                ? `/storage/${classe.image}`
                                                : '/storage/seed/default-classe.svg'
                                        "
                                        class="invert"
                                    />
                                </div>
                                <h3 class="text-primary-icon text-lg font-bold">
                                    {{ classe.name }}
                                </h3>
                            </div>
                            <p
                                class="text-primary-light text-xs mt-2 leading-relaxed"
                            >
                                {{ classe.description }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Constraints Content -->
                <div v-if="activeCategory === 'constraints'" class="space-y-4">
                    <h2
                        class="text-primary-light text-xl font-bold mb-4 text-center border-b border-primary-first pb-2"
                    >
                        CONSTRAINTS
                    </h2>

                    <div
                        v-if="props.constraints"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                    >
                        <div
                            v-for="constraint in props.constraints"
                            :key="constraint.id"
                            class="bg-primary-dark/80 rounded-lg p-3 hover:bg-primary-dark transition-colors shadow-sm border border-primary-blue/20"
                        >
                            <div class="flex items-center">
                                <div
                                    class="bg-primary-icon rounded-full p-2 mr-3 flex items-center justify-center w-8 h-8"
                                >
                                    <img
                                        :src="`/storage/${constraint.image}`"
                                    />
                                </div>
                                <h3 class="text-primary-icon text-lg font-bold">
                                    {{ constraint.name }}
                                </h3>
                            </div>
                            <p
                                class="text-primary-light text-xs mt-2 leading-relaxed"
                            >
                                {{ constraint.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </AppLayout>
</template>
