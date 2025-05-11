import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Roboto", ...defaultTheme.fontFamily.sans],
                parkinsans: ["Parkinsans"],
            },
            colors: {
                primary: {
                    dark: "rgb(0, 24, 35)",
                    first: "rgb(255, 183, 3)",
                    blue: "rgb(2,48,71)",
                    light: "rgb(237, 246, 250)",
                    icon: "rgb(251, 133, 0)",
                },
            },
        },
    },

    plugins: [forms, typography],
};
