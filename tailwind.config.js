/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: ['./public/*.php', './views/**/*.php'],
    theme: {
        extend: {
            fontFamily: {
                sans: [ ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [require('@tailwindcss/typography'), require('@tailwindcss/forms')],
    darkMode: 'class',
}
