<template>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
    >
        <div class="flex flex-col items-center">
            <slot name="logo" />

            <h1
                class="text-primary-light text-5xl font-bold mt-5 mb-2 font-parkinsans text-center"
            >
                TFT OPERATION
            </h1>

            <div class="w-96 h-1 bg-primary-first mb-6"></div>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white/80 backdrop-blur-md shadow-md overflow-hidden sm:rounded-lg transition ease-in-out duration-300"
        >
            <slot />
        </div>
    </div>
</template>
