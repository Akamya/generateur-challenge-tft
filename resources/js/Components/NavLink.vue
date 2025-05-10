<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const page = usePage();
const isActive = ref(false);

// Function to check if the link is active
const checkActive = () => {
    let tempIsActive = false;

    // If active prop is explicitly provided, use it
    if (props.active !== undefined) {
        tempIsActive = props.active;
    } else {
        // For History link, do a special check
        if (props.href.includes("/history/")) {
            const currentPath = window.location.pathname;
            tempIsActive = currentPath.startsWith("/history/");
        } else {
            // Default: Compare exact paths
            const currentPath = window.location.pathname;
            const linkPath = props.href.split("?")[0]; // Remove query parameters
            tempIsActive = currentPath === linkPath;
        }
    }

    isActive.value = tempIsActive;
};

// Check active state on mount
onMounted(checkActive);

// Watch for route changes
watch(() => page.url, checkActive);

// Compute classes based on active state
const classes = computed(() => {
    // Base classes that are always applied
    const baseClasses =
        "inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-primary-light focus:outline-none transition duration-150 ease-in-out";

    // Border classes that change based on active state
    const borderClasses = isActive.value
        ? "border-b-2 border-primary-first"
        : "border-b-2 border-transparent hover:border-gray-300";

    // Hover text color
    const hoverClasses = "hover:text-primary-first";

    return `${baseClasses} ${borderClasses} ${hoverClasses}`;
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
