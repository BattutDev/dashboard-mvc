/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  daisyui: {
    themes: ["winter", "night"],
    darkTheme: "night",
  },

  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}