const purgecss = require('@fullhuman/postcss-purgecss')({
    content: ['./templates/*.html.twig'],
    whitelist: ['emoji']
})

module.exports = {
    plugins: [
        ...process.env.NODE_ENV === 'production'
            ? [purgecss]
            : [],
        require('tailwindcss'),
    ]
}
