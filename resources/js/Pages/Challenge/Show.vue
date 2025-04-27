<script setup>
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
// import tftTraitsData from "/storage/icons/tft-trait.json";

const props = defineProps({
    challenge: Object,
});

// function getTraitIcon(traitName) {
//     if (!traitName) return "/default-icon.png";

//     const lowerTraitName = traitName.toLowerCase();
//     const traits = tftTraitsData.data;
//     const traitEntry = Object.values(traits).find(
//         (trait) => trait.name.toLowerCase() === lowerTraitName
//     );

//     if (traitEntry && traitEntry.image && traitEntry.image.full) {
//         return `/storage/icons/${traitEntry.image.full}`;
//     }

//     return "/default-icon.png";
// }

function markAsCompleted() {
    $inertia.post(route("challenge.complete", props.challenge.id));
}

function cancelChallenge() {
    $inertia.post(route("challenge.cancel", props.challenge.id));
}
</script>

<template>
    <AppLayout>
        <Head :title="`Challenge #${challenge.id}`" />

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
                class="relative flex-grow flex flex-col items-center justify-center py-12 px-4"
            >
                <div class="bg-blue-900/80 rounded-lg p-8 max-w-2xl w-full">
                    <h2 class="text-white text-3xl font-bold mb-8 text-center">
                        VOTRE CHALLENGE
                    </h2>

                    <div class="space-y-6 mb-8">
                        <!-- Challenge Items -->
                        <div class="flex items-center">
                            <!-- <div class="bg-orange-500 rounded-full p-2 mr-4">
                                <img
                                    :src="getTraitIcon(challenge.position.name)"
                                    alt="Position Icon"
                                    class="h-6 w-6"
                                />
                            </div> -->
                            <span class="text-white text-lg"
                                >Position : {{ challenge.position.name }}</span
                            >
                        </div>

                        <div class="flex items-center">
                            <!-- <div class="bg-orange-500 rounded-full p-2 mr-4">
                                <img
                                    :src="getTraitIcon(challenge.classe.name)"
                                    alt="Class Icon"
                                    class="h-6 w-6"
                                />
                            </div> -->
                            <span class="text-white text-lg"
                                >Classe : {{ challenge.classe.name }}</span
                            >
                        </div>

                        <div class="flex items-center">
                            <!-- <div class="bg-orange-500 rounded-full p-2 mr-4">
                                <img
                                    :src="getTraitIcon(challenge.origin.name)"
                                    alt="Origin Icon"
                                    class="h-6 w-6"
                                />
                            </div> -->
                            <span class="text-white text-lg"
                                >Origine : {{ challenge.origin.name }}</span
                            >
                        </div>

                        <!-- Additional challenge details if needed -->
                        <div v-if="challenge.season" class="flex items-center">
                            <span class="text-white text-lg"
                                >Saison : {{ challenge.season.name }}</span
                            >
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-6">
                        <button
                            @click="markAsCompleted"
                            class="bg-green-600 hover:bg-green-500 text-white font-bold py-3 px-6 rounded-lg flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Challenge Réussi
                        </button>

                        <button
                            @click="cancelChallenge"
                            class="bg-red-600 hover:bg-red-500 text-white font-bold py-3 px-6 rounded-lg flex items-center"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            Abondonner
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>
