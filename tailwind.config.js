/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  daisyui: {
    themes: ["light", "dark"],
  },

  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
}