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
            <nav
                class="relative z-11 bg-primary-dark py-2 md:py-2 px-4 sm:px-6 lg:px-8 shadow-lg border-b border-primary-first"
            >
                <div
                    class="container mx-auto flex flex-wrap items-center justify-between"
                >
                    <!-- Logo -->
                    <div class="flex items-center mb-2 mt-3 lg:mb-0 lg:mt-0">
                        <img
                            src="/storage/opTft.svg"
                            alt="TFT OP Logo"
                            class="h-8 w-8 mr-2"
                        />
                        <span
                            class="text-primary-light text-xl font-bold font-parkinsans self-end"
                            >TFT OPERATION</span
                        >
                    </div>

                    <!-- Navigation Links -->
                    <div
                        class="hidden md:flex items-center justify-center flex-grow"
                    >
                        <div class="flex space-x-4 lg:space-x-8">
                            <NavLink
                                :href="route('homepage')"
                                :active="route().current('homepage')"
                                class="text-primary-light hover:text-primary-first"
                            >
                                Home
                            </NavLink>
                            <NavLink
                                :href="route('glossary')"
                                :active="route().current('glossary')"
                                class="text-primary-light hover:text-primary-first"
                            >
                                Glossary
                            </NavLink>
                            <NavLink
                                :href="route('leaderboard')"
                                :active="route().current('leaderboard')"
                                class="text-primary-light hover:text-primary-first"
                            >
                                Leaderboard
                            </NavLink>
                            <NavLink
                                v-if="$page.props.auth && $page.props.auth.user"
                                :href="
                                    route('history', $page.props.auth.user.id)
                                "
                                :active="
                                    route().current('history', {
                                        userID: $page.props.auth.user.id,
                                    })
                                "
                                class="text-primary-light hover:text-primary-first"
                            >
                                History
                            </NavLink>
                        </div>
                    </div>

                    <!-- Right Side Items -->
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="hidden sm:block w-full sm:w-auto max-w-xs">
                            <UserSearch />
                        </div>

                        <!-- User is authenticated -->
                        <div
                            v-if="$page.props.auth && $page.props.auth.user"
                            class="hidden sm:flex sm:items-center"
                        >
                            <!-- Teams Dropdown -->
                            <div
                                class="relative"
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
                                                class="bg-primary-first hover:bg-opacity-90 text-black font-bold py-2 px-4 rounded-full flex items-center"
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
                                                    $page.props.auth.user
                                                        .all_teams.length > 1
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
                                                    v-for="team in $page.props
                                                        .auth.user.all_teams"
                                                    :key="team.id"
                                                >
                                                    <form
                                                        @submit.prevent="
                                                            switchToTeam(team)
                                                        "
                                                    >
                                                        <DropdownLink
                                                            as="button"
                                                        >
                                                            <div
                                                                class="flex items-center"
                                                            >
                                                                <svg
                                                                    v-if="
                                                                        team.id ==
                                                                        $page
                                                                            .props
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
                                                                    {{
                                                                        team.name
                                                                    }}
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
                                            class="bg-primary-first hover:bg-opacity-90 text-black font-medium py-1 px-2.5 rounded-xl flex items-center text-sm transition-all duration-200"
                                        >
                                            <img
                                                class="size-6 rounded-full mr-1.5"
                                                :src="
                                                    $page.props.auth.user
                                                        .profile_photo_path
                                                        ? `/storage/${$page.props.auth.user.profile_photo_path}`
                                                        : '/storage/seed/default-avatar.svg'
                                                "
                                                :alt="
                                                    $page.props.auth.user
                                                        .username
                                                "
                                                :class="{
                                                    'object-cover':
                                                        $page.props.auth.user
                                                            .profile_photo_path,
                                                    invert: !$page.props.auth
                                                        .user
                                                        .profile_photo_path,
                                                }"
                                            />
                                            {{ $page.props.auth.user.username }}
                                        </button>

                                        <span
                                            v-else
                                            class="inline-flex rounded-md"
                                        >
                                            <button
                                                type="button"
                                                class="bg-primary-first hover:bg-opacity-90 text-black font-bold py-1.5 px-3 rounded-md flex items-center text-sm"
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

                                        <DropdownLink
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink
                                            v-if="
                                                $page.props.auth.user &&
                                                $page.props.auth.user.is_admin
                                            "
                                            :href="route('admin.index')"
                                        >
                                            Admin
                                        </DropdownLink>

                                        <DropdownLink
                                            v-if="
                                                $page.props.jetstream &&
                                                $page.props.jetstream
                                                    .hasApiFeatures
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
                                class="bg-primary-first hover:bg-opacity-90 text-black font-bold py-1.5 px-3 rounded-xl text-sm"
                            >
                                Sign In
                            </Link>
                            <Link
                                :href="route('register')"
                                class="bg-primary-first hover:bg-opacity-90 text-black font-bold py-1.5 px-3 rounded-xl text-sm"
                            >
                                Sign Up
                            </Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-primary-light hover:text-primary-first hover:bg-primary-blue/30 focus:outline-none focus:bg-primary-blue/30 focus:text-primary-first transition duration-150 ease-in-out"
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
                </div>

                <!-- Mobile Search -->
                <div class="sm:hidden m-2 px-2">
                    <UserSearch />
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden bg-primary-blue/80"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('homepage')"
                            :active="route().current('homepage')"
                            class="text-primary-light hover:text-primary-first"
                            active-class="bg-primary-blue text-primary-first"
                        >
                            Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('glossary')"
                            :active="route().current('glossary')"
                            class="text-primary-light hover:text-primary-first"
                            active-class="bg-primary-blue text-primary-first"
                        >
                            Glossary
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('leaderboard')"
                            :active="route().current('leaderboard')"
                            class="text-primary-light hover:text-primary-first"
                            active-class="bg-primary-blue text-primary-first"
                        >
                            Leaderboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth && $page.props.auth.user"
                            :href="route('history', $page.props.auth.user)"
                            :active="route().current('history')"
                            class="text-primary-light hover:text-primary-first"
                            active-class="bg-primary-blue text-primary-first"
                        >
                            History
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-primary-blue">
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
                                        class="font-medium text-base text-primary-light"
                                    >
                                        {{
                                            $page.props.auth.user.username ||
                                            $page.props.auth.user.name
                                        }}
                                    </div>
                                    <div
                                        class="font-medium text-sm text-primary-light/70"
                                    >
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.show')"
                                    :active="route().current('profile.show')"
                                    class="text-primary-light hover:text-primary-first"
                                    active-class="bg-primary-blue text-primary-first"
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
                                    class="text-primary-light hover:text-primary-first"
                                    active-class="bg-primary-blue text-primary-first"
                                >
                                    API Tokens
                                </ResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink
                                        as="button"
                                        class="text-primary-light hover:text-primary-first"
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
                                    <div class="border-t border-primary-blue" />

                                    <div
                                        class="block px-4 py-2 text-xs text-primary-light/70"
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
                                        class="text-primary-light hover:text-primary-first"
                                        active-class="bg-primary-blue text-primary-first"
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
                                        class="text-primary-light hover:text-primary-first"
                                        active-class="bg-primary-blue text-primary-first"
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
                                        <div
                                            class="border-t border-primary-blue"
                                        />

                                        <div
                                            class="block px-4 py-2 text-xs text-primary-light/70"
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
                                                    class="text-primary-light hover:text-primary-first"
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
                                    class="text-primary-light hover:text-primary-first"
                                    active-class="bg-primary-blue text-primary-first"
                                >
                                    Sign In
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('register')"
                                    :active="route().current('register')"
                                    class="text-primary-light hover:text-primary-first"
                                    active-class="bg-primary-blue text-primary-first"
                                >
                                    Sign Up
                                </ResponsiveNavLink>
                            </div>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-primary-blue shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main
                class="relative flex flex-col items-center justify-center flex-grow"
            >
                <div v-if="showBackground" class="absolute inset-0 z-0">
                    <img
                        src="/storage/tft-wallpaper.jpg"
                        alt="TFT Background"
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-primary-blue/70"></div>
                </div>
                <div
                    v-else
                    class="absolute inset-0 z-0 bg-primary-dark/95"
                ></div>
                <div class="relative z-10 w-full">
                    <slot />
                </div>
            </main>
            <Footer></Footer>
        </div>
    </div>
</template>
