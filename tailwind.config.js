import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    // (optional) include JS if you later add interactive components
    './resources/js/**/*.js',
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        ram: {
          blue: '#0096D6',   // primary
          yellow: '#FFC800', // accent
          teal: '#5CB3AD',   // secondary/accent
          dark: '#0B3A53',   // headings/links
        },
      },
      boxShadow: {
        soft: '0 8px 24px rgba(11,58,83,0.08)',
      },
    },
  },

  plugins: [forms],
};
