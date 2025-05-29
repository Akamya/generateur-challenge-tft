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
                Privacy Policy
            </h1>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Introduction
                </h2>
                <p>
                    <strong>TFT OPERATION</strong> is committed to protecting
                    your privacy. This Privacy Policy explains the personal data
                    we collect and how we use it.
                </p>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Data Controller
                </h2>
                <p>
                    The data controller responsible for your personal data is:
                </p>
                <ul class="list-disc list-inside mt-3">
                    <li><strong>Project name</strong>: TFT OPERATION</li>
                    <li><strong>Responsible person</strong>: Elodie Langlet</li>
                    <li><strong>Email</strong>: elodie.langlet@gmail.com</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Data Collected
                </h2>
                <p>
                    Our site collects and processes minimal personal data,
                    including:
                </p>
                <ul class="list-disc list-inside mt-3">
                    <li>
                        Information you provide via sign up form (email, hashed
                        password and Riot username)
                    </li>

                    <li>
                        Data related to completed challenges and user scores for
                        leaderboard features
                    </li>
                    <li>
                        Personal data retrieved through the Riot Games API
                        (e.g., summoner name, unique IDs, game stats)
                    </li>
                </ul>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Use of Riot Games API Data
                </h2>
                <p>
                    To offer personalized challenges and verify your progress,
                    we connect to the Riot Games API. We only request access to
                    data related to your TFT account necessary for challenge
                    validation.
                </p>
                <p class="mt-3">
                    We do <strong>not</strong> store any of your Riot Games
                    account data beside your username.
                </p>
                <p class="mt-3">
                    Your data from Riot is used exclusively for the site's
                    functionality and is not shared with third parties.
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
                    Sign Up Form
                </h2>
                <p>
                    When you sign up, we collect only the necessary information
                    to let you have an account and have more access of the
                    site's features (email, hashed password and Riot username).
                    These details are stored and not used for other purposes.
                </p>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Your Rights
                </h2>
                <p>
                    Under GDPR, you have the following rights regarding your
                    personal data:
                </p>
                <ul class="list-disc list-inside mt-3">
                    <li>Right to access your data</li>
                    <li>Right to rectify inaccurate data</li>
                    <li>Right to erasure ("right to be forgotten")</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2
                    class="text-2xl font-semibold mb-3"
                    :style="{ color: 'rgb(251, 133, 0)' }"
                >
                    Data Security
                </h2>
                <p>
                    While we collect minimal personal data, we take appropriate
                    technical and organizational measures to ensure the security
                    and confidentiality of your information.
                </p>
            </section>
        </div>
    </AppLayout>
</template>
