/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.jsx',
    './resources/js/**/*.ts',
    './resources/js/**/*.tsx',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        taskflow: {
          bg: '#0A0F1C',
          sidebar: '#0D1323',
          card: '#1A2235',
          input: '#13192B',
          blue: '#2962FF',
          teal: '#00E5FF',
          purple: '#9D4EDD',
          sky: '#00B4D8',
          orange: '#FF9100',
          text_sec: '#94A3B8',
        },
      },
    },
  },
  plugins: [],
};
