/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      colors: {
        main: "#00205c",
        hover: "#FADC6F",
      },
    },
  },
  plugins: [],
};
