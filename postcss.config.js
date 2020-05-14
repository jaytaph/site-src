const purgecss = require('@fullhuman/postcss-purgecss')({
    content: ['./templates/**/*.html.twig'],
    whitelistPatternsChildren: [/token$/, /pre$/, /code$/, /fa/],
    whitelist: ['emoji', 'markdown']
})

module.exports = {
    plugins: [
        ...process.env.NODE_ENV === 'production'
            ? [purgecss]
            : [],
        require('tailwindcss'),
    ]
}
