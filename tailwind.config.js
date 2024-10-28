/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php", "./public/**/*.html", "./public/js/**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/forms")],
};
