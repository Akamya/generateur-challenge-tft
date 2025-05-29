<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <footer
        class="relative z-10 bg-primary-dark py-1 px-4 text-center border-t shadow-lg border-primary-first"
    >
        <div class="container mx-auto">
            <!-- Logo + Nom -->
            <div class="flex justify-center mb-1">
                <img
                    src="/storage/opTft.svg"
                    alt="TFT OP Logo"
                    class="h-7 w-7 mr-2"
                />
                <span
                    class="text-primary-light text-sm font-bold mt-2 font-parkinsans"
                >
                    TFT OPERATION
                </span>
            </div>

            <!-- Liens légaux -->
            <div class="flex justify-center space-x-4 text-xs mb-2">
                <Link
                    href="/legal-notice"
                    class="text-primary-light underline hover:text-white transition"
                >
                    Legal Notice
                </Link>
                <span class="text-primary-light">|</span>
                <Link
                    href="/privacy-policy"
                    class="text-primary-light underline hover:text-white transition"
                >
                    Privacy Policy
                </Link>
            </div>

            <!-- Mention de droits -->
            <p class="text-primary-light text-xs mb-1">
                © TFT OPERATION. All rights reserved. By Elodie Langlet.
            </p>
        </div>
    </footer>
</template>
