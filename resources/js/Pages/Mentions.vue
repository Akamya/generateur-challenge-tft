<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
    <AppLayout :show-background="true">
        <div
            class="max-w-4xl mx-auto px-6 py-12 rounded-lg shadow-lg"
            :style="{
                backgroundColor: 'rgb(2,48,71)',
                color: 'rgb(237, 246, 250)',
            }"
        >
            <h1
                class="text-4xl font-extrabold mb-10 text-center"
                :style="{ color: 'rgb(251, 133, 0)' }"
            >
                Legal Notice
            </h1>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Intellectual Property
                </h2>
                <p>
                    All content on this website is protected by Belgian and
                    international copyright and intellectual property laws. The
                    textual content and layout are the exclusive property of
                    Elodie Langlet, unless otherwise stated.
                </p>
                <p class="mt-3">
                    This site may use visuals related to the game
                    <em>Teamfight Tactics</em> for educational and
                    non-commercial purposes only. <em>Teamfight Tactics</em> and
                    its assets are the property of
                    <strong>Riot Games, Inc.</strong> and are used here under
                    fair use guidelines.
                </p>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Personal Data Protection
                </h2>
                <p>
                    In accordance with the
                    <strong>General Data Protection Regulation (GDPR)</strong>
                    and the Belgian law of July 30, 2018 on the protection of
                    natural persons with regard to the processing of personal
                    data, you have the right to access, rectify, delete, or
                    limit the processing of your data.
                </p>

                <p class="mt-3">
                    For more details, please consult our
                    <a
                        href="#"
                        class="underline hover:text-orange-400"
                        :style="{ color: 'rgb(237, 246, 250)' }"
                        >Privacy Policy</a
                    >.
                </p>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Cookies
                </h2>
                <p>
                    This website uses cookies to improve your browsing
                    experience. In accordance with Belgian law, you are informed
                    that you can configure your browser at any time to refuse
                    the use of cookies.
                </p>
                <p class="mt-3">
                    By creating an account and logging in, you accept the use of
                    session cookies.
                </p>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Applicable Law and Jurisdiction
                </h2>
                <p>
                    These legal notices are governed by Belgian law. In the
                    event of a dispute, only the Belgian courts will have
                    jurisdiction.
                </p>
            </section>

            <section>
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Disclaimer
                </h2>
                <p>
                    All content is provided for information purposes only.
                    Although we strive to keep it accurate and up to date,
                    errors may occur. We commit to correcting any issues brought
                    to our attention as quickly as possible.
                </p>
            </section>
        </div>
    </AppLayout>
</template>
