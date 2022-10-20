/** @type {import('tailwindcss').Config} */

module.exports = {
    content: ['./public/*.php', './views/**/*.php'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat'],
            },
        },
    },
    plugins: [require('@tailwindcss/typography'), require('@tailwindcss/forms')],
    darkMode: 'class',
}
