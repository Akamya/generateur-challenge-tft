<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import UserSearch from "@/Components/UserSearch.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    title: String,
    showBackground: {
        type: Boolean,
        default: false,
    },
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title">
            <link rel="icon" href="/storage/opTft.svg" type="image/x-icon" />
        </Head>

        <Banner />

        <div class="flex flex-col min-h-screen">
            <!-- Primary Navigation Menu -->
            <nav class="relative z-10 bg-blue-950 py-4 px-6 shadow-lg">
                <div
                    class="container mx-auto flex justify-between items-center"
                >
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img
                            src="/storage/opTft.svg"
                            alt="TFT Logo"
                            class="h-8 w-8 mr-2"
                        />
                        <span class="text-white text-xl font-bold"
                            >TFT OPERATION</span
                        >
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-8">
                        <NavLink
                            :href="route('homepage')"
                            :active="route().current('homepage')"
                            class="text-white hover:text-yellow-300"
                            active-class="text-yellow-300"
                        >
                            Home
                        </NavLink>
                        <NavLink
                            :href="route('glossary')"
                            :active="route().current('glossary')"
                            class="text-white hover:text-yellow-300"
                            active-class="text-yellow-300"
                        >
                            Glossary
                        </NavLink>
                        <NavLink
                            :href="route('leaderboard')"
                            :active="route().current('leaderboard')"
                            class="text-white hover:text-yellow-300"
                            active-class="text-yellow-300"
                        >
                            Leaderboard
                        </NavLink>
                        <NavLink
                            v-if="$page.props.auth && $page.props.auth.user"
                            :href="route('history', $page.props.auth.user.id)"
                            :active="route().current('history')"
                            class="text-white hover:text-yellow-300"
                            active-class="text-yellow-300"
                        >
                            History
                        </NavLink>
                    </div>
                    <UserSearch />

                    <!-- User is authenticated -->
                    <div
                        v-if="$page.props.auth && $page.props.auth.user"
                        class="hidden sm:flex sm:items-center sm:ms-6"
                    >
                        <!-- Teams Dropdown -->
                        <div
                            class="ms-3 relative"
                            v-if="
                                $page.props.jetstream &&
                                $page.props.jetstream.hasTeamFeatures
                            "
                        >
                            <Dropdown align="right" width="60">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full flex items-center"
                                        >
                                            {{
                                                $page.props.auth.user
                                                    .current_team.name
                                            }}

                                            <svg
                                                class="ms-2 -me-0.5 size-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div
                                            class="block px-4 py-2 text-xs text-gray-400"
                                        >
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'teams.show',
                                                    $page.props.auth.user
                                                        .current_team
                                                )
                                            "
                                        >
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink
                                            v-if="
                                                $page.props.jetstream
                                                    .canCreateTeams
                                            "
                                            :href="route('teams.create')"
                                        >
                                            Create New Team
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template
                                            v-if="
                                                $page.props.auth.user.all_teams
                                                    .length > 1
                                            "
                                        >
                                            <div
                                                class="border-t border-gray-200"
                                            />

                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400"
                                            >
                                                Switch Teams
                                            </div>

                                            <template
                                                v-for="team in $page.props.auth
                                                    .user.all_teams"
                                                :key="team.id"
                                            >
                                                <form
                                                    @submit.prevent="
                                                        switchToTeam(team)
                                                    "
                                                >
                                                    <DropdownLink as="button">
                                                        <div
                                                            class="flex items-center"
                                                        >
                                                            <svg
                                                                v-if="
                                                                    team.id ==
                                                                    $page.props
                                                                        .auth
                                                                        .user
                                                                        .current_team_id
                                                                "
                                                                class="me-2 size-5 text-green-400"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="1.5"
                                                                stroke="currentColor"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                />
                                                            </svg>

                                                            <div>
                                                                {{ team.name }}
                                                            </div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        v-if="
                                            $page.props.jetstream &&
                                            $page.props.jetstream
                                                .managesProfilePhotos
                                        "
                                        class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full flex items-center"
                                    >
                                        <img
                                            class="size-8 rounded-full object-cover mr-2"
                                            :src="
                                                $page.props.auth.user
                                                    .profile_photo_url
                                            "
                                            :alt="
                                                $page.props.auth.user.username
                                            "
                                        />
                                        {{ $page.props.auth.user.username }}
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full flex items-center"
                                        >
                                            {{
                                                $page.props.auth.user
                                                    .username ||
                                                $page.props.auth.user.name
                                            }}

                                            <svg
                                                class="ms-2 -me-0.5 size-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink
                                        v-if="
                                            $page.props.jetstream &&
                                            $page.props.jetstream.hasApiFeatures
                                        "
                                        :href="route('api-tokens.index')"
                                    >
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- User is not authenticated (Guest) -->
                    <div v-else class="hidden sm:flex space-x-4">
                        <Link
                            :href="route('login')"
                            class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full"
                        >
                            Sign In
                        </Link>
                        <Link
                            :href="route('register')"
                            class="bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded-full"
                        >
                            Sign Up
                        </Link>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-yellow-300 hover:bg-blue-900 focus:outline-none focus:bg-blue-900 focus:text-yellow-300 transition duration-150 ease-in-out"
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                        >
                            <svg
                                class="size-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-blue-900"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('homepage')"
                            :active="route().current('homepage')"
                            class="text-white hover:text-yellow-300"
                            active-class="bg-blue-800 text-yellow-300"
                        >
                            Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('glossary')"
                            :active="route().current('glossary')"
                            class="text-white hover:text-yellow-300"
                            active-class="bg-blue-800 text-yellow-300"
                        >
                            Glossary
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('leaderboard')"
                            :active="route().current('leaderboard')"
                            class="text-white hover:text-yellow-300"
                            active-class="bg-blue-800 text-yellow-300"
                        >
                            Leaderboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth && $page.props.auth.user"
                            :href="route('history', $page.props.auth.user)"
                            :active="route().current('history')"
                            class="text-white hover:text-yellow-300"
                            active-class="bg-blue-800 text-yellow-300"
                        >
                            History
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-blue-800">
                        <!-- Authenticated User -->
                        <template
                            v-if="$page.props.auth && $page.props.auth.user"
                        >
                            <div class="flex items-center px-4">
                                <div
                                    v-if="
                                        $page.props.jetstream &&
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="shrink-0 me-3"
                                >
                                    <img
                                        class="size-10 rounded-full object-cover"
                                        :src="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                        :alt="
                                            $page.props.auth.user.username ||
                                            $page.props.auth.user.name
                                        "
                                    />
                                </div>

                                <div>
                                    <div
                                        class="font-medium text-base text-white"
                                    >
                                        {{
                                            $page.props.auth.user.username ||
                                            $page.props.auth.user.name
                                        }}
                                    </div>
                                    <div
                                        class="font-medium text-sm text-gray-300"
                                    >
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.show')"
                                    :active="route().current('profile.show')"
                                    class="text-white hover:text-yellow-300"
                                    active-class="bg-blue-800 text-yellow-300"
                                >
                                    Profile
                                </ResponsiveNavLink>

                                <ResponsiveNavLink
                                    v-if="
                                        $page.props.jetstream &&
                                        $page.props.jetstream.hasApiFeatures
                                    "
                                    :href="route('api-tokens.index')"
                                    :active="
                                        route().current('api-tokens.index')
                                    "
                                    class="text-white hover:text-yellow-300"
                                    active-class="bg-blue-800 text-yellow-300"
                                >
                                    API Tokens
                                </ResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink
                                        as="button"
                                        class="text-white hover:text-yellow-300"
                                    >
                                        Log Out
                                    </ResponsiveNavLink>
                                </form>

                                <!-- Team Management -->
                                <template
                                    v-if="
                                        $page.props.jetstream &&
                                        $page.props.jetstream.hasTeamFeatures
                                    "
                                >
                                    <div class="border-t border-blue-800" />

                                    <div
                                        class="block px-4 py-2 text-xs text-gray-300"
                                    >
                                        Manage Team
                                    </div>

                                    <!-- Team Settings -->
                                    <ResponsiveNavLink
                                        :href="
                                            route(
                                                'teams.show',
                                                $page.props.auth.user
                                                    .current_team
                                            )
                                        "
                                        :active="route().current('teams.show')"
                                        class="text-white hover:text-yellow-300"
                                        active-class="bg-blue-800 text-yellow-300"
                                    >
                                        Team Settings
                                    </ResponsiveNavLink>

                                    <ResponsiveNavLink
                                        v-if="
                                            $page.props.jetstream.canCreateTeams
                                        "
                                        :href="route('teams.create')"
                                        :active="
                                            route().current('teams.create')
                                        "
                                        class="text-white hover:text-yellow-300"
                                        active-class="bg-blue-800 text-yellow-300"
                                    >
                                        Create New Team
                                    </ResponsiveNavLink>

                                    <!-- Team Switcher -->
                                    <template
                                        v-if="
                                            $page.props.auth.user.all_teams
                                                .length > 1
                                        "
                                    >
                                        <div class="border-t border-blue-800" />

                                        <div
                                            class="block px-4 py-2 text-xs text-gray-300"
                                        >
                                            Switch Teams
                                        </div>

                                        <template
                                            v-for="team in $page.props.auth.user
                                                .all_teams"
                                            :key="team.id"
                                        >
                                            <form
                                                @submit.prevent="
                                                    switchToTeam(team)
                                                "
                                            >
                                                <ResponsiveNavLink
                                                    as="button"
                                                    class="text-white hover:text-yellow-300"
                                                >
                                                    <div
                                                        class="flex items-center"
                                                    >
                                                        <svg
                                                            v-if="
                                                                team.id ==
                                                                $page.props.auth
                                                                    .user
                                                                    .current_team_id
                                                            "
                                                            class="me-2 size-5 text-green-400"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="1.5"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            />
                                                        </svg>
                                                        <div>
                                                            {{ team.name }}
                                                        </div>
                                                    </div>
                                                </ResponsiveNavLink>
                                            </form>
                                        </template>
                                    </template>
                                </template>
                            </div>
                        </template>

                        <!-- Guest Links -->
                        <template v-else>
                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('login')"
                                    :active="route().current('login')"
                                    class="text-white hover:text-yellow-300"
                                    active-class="bg-blue-800 text-yellow-300"
                                >
                                    Sign In
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('register')"
                                    :active="route().current('register')"
                                    class="text-white hover:text-yellow-300"
                                    active-class="bg-blue-800 text-yellow-300"
                                >
                                    Sign Up
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-blue-900 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main
                class="relative py-12 px-4 flex flex-col items-center justify-center flex-grow"
            >
                <div v-if="showBackground" class="absolute inset-0 z-0">
                    <img
                        src="/storage/tft-wallpaper.jpg"
                        alt="TFT Background"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-blue-900/70"></div>
                </div>
                <slot />
            </main>
            <Footer></Footer>
        </div>
    </div>
</template>
