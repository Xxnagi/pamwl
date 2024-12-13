/** @type {import('tailwindcss').Config} */
export default {
  purge: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  content: [],
  theme: {
    extend: {
      fontFamily: {
        nunito: ["Nunito", "sans-serif"],
      },
      colors: {
        primary: {
          DEFAULT: "#your-primary-color-hex",
          // You can add variations like
          light: "#lighter-shade",
          dark: "#darker-shade",
        },
      },
    },
  },
  plugins: [],
};
